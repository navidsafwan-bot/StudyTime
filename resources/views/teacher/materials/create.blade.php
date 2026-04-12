@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Upload Material for {{ $course->title }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('materials.store', $course->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">PDF File</label>
            <input type="file" class="form-control" id="file" name="file" accept="application/pdf" required>
            <div class="form-text">Max file size: 2MB</div>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
        <a href="{{ route('materials.index', $course->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
