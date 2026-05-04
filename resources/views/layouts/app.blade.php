<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'StudyTime')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">StudyTime</a>
            <div class="navbar-nav ms-auto">
                @if(auth()->check())
                    <!-- Notifications Dropdown -->
                    @if(auth()->user()->role === 'student')
                    <div class="nav-item dropdown me-3">
                        <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
                            </svg>
                            <span id="notification-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none; font-size: 0.65rem;">
                                0
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notificationsDropdown" id="notification-list" style="width: 350px; max-height: 400px; overflow-y: auto;">
                            <li><span class="dropdown-item text-muted text-center small py-3">Loading...</span></li>
                        </ul>
                    </div>
                    @endif

                    <a class="nav-link me-3" href="{{ route('profile.index') }}">Profile</a>
                    <span class="navbar-text me-3">Welcome, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                    </form>
                @else
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                    <a class="nav-link" href="{{ route('signup') }}">Sign Up</a>
                @endif
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @if(auth()->check() && auth()->user()->role === 'student')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const badge = document.getElementById('notification-badge');
            const list = document.getElementById('notification-list');
            
            function fetchNotifications() {
                fetch('{{ route('notifications.index') }}')
                    .then(res => res.json())
                    .then(data => {
                        if (data.unread_count > 0) {
                            badge.style.display = 'inline-block';
                            badge.textContent = data.unread_count;
                        } else {
                            badge.style.display = 'none';
                        }

                        if (data.notifications.length === 0) {
                            list.innerHTML = '<li><span class="dropdown-item text-muted text-center small py-3">No notifications</span></li>';
                            return;
                        }

                        list.innerHTML = '';
                        data.notifications.forEach(notif => {
                            const isUnread = !notif.read_status;
                            const bgClass = isUnread ? 'bg-light' : '';
                            const fwClass = isUnread ? 'fw-bold' : '';
                            const time = new Date(notif.created_at).toLocaleString([], {month: 'short', day: 'numeric', hour: '2-digit', minute:'2-digit'});
                            
                            const li = document.createElement('li');
                            li.innerHTML = `
                                <form method="POST" action="/notifications/${notif.id}/read" class="m-0 p-0">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="dropdown-item py-2 border-bottom ${bgClass}" style="white-space: normal;">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 ${fwClass}" style="font-size: 0.9rem;">${notif.title}</h6>
                                            <small class="text-muted" style="font-size: 0.7rem;">${time}</small>
                                        </div>
                                        <p class="mb-1 small text-muted">${notif.message}</p>
                                        <small class="text-primary">${notif.course ? notif.course.title : ''}</small>
                                    </button>
                                </form>
                            `;
                            list.appendChild(li);
                        });
                    })
                    .catch(err => console.error("Error fetching notifications:", err));
            }

            fetchNotifications();
            setInterval(fetchNotifications, 10000);

            // Mark all as read when dropdown is opened
            const notifDropdown = document.getElementById('notificationsDropdown');
            if (notifDropdown) {
                notifDropdown.addEventListener('show.bs.dropdown', function () {
                    if (badge.style.display !== 'none') {
                        fetch('{{ route('notifications.readAll') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        }).then(() => {
                            badge.style.display = 'none';
                            badge.textContent = '0';
                            
                            // Visually mark existing unread items as read in the DOM
                            const unreadItems = list.querySelectorAll('.bg-light');
                            unreadItems.forEach(item => {
                                item.classList.remove('bg-light');
                                const title = item.querySelector('.fw-bold');
                                if (title) title.classList.remove('fw-bold');
                            });
                        });
                    }
                });
            }
        });
    </script>
    @endif
</body>
</html>