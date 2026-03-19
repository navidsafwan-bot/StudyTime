<?php

use Illuminate\Support\Facades\Route;//thsi does not work without this line, it is used to define routes in Laravel

Route::get('/', function () {
    return view('home');
});

//named routes we are going to use this in the blade file to link to the about page
Route::get('/test',function() {
    return view('signup');
})->name("signuppage");


//groped routes
Route::get('/aboutus',function() {
    return view('about');
})->name("aboutus");
 
Route::prefix()->group(function() {

  Route::get("/navid", function(){
   return view("navid_info");
  })->name("navidinfo");

  Route::get("/Md.Samsul", function(){
   return view("Samsul_info");
  })->name("samsulinfo");

    Route::get("/bishal", function(){
   return view("bishal_info");
  })->name("bishalinfo");


}); 