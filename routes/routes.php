<?php
use Core\Router;
use App\Controllers\FooController;

Router::route('get', '', function() {
  echo "Hello World!";
});

Router::route('get', 'foo', function() {
  FooController::index();
});

Router::route('get', 'foo/{id}', function($id) {
  FooController::show($id);
});

Router::route('post', 'foo/save', function() {
  FooController::save();
});