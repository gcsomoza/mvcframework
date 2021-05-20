<?php

function render($view) {
  Core\View::render($view);
}

function url($url_string) {
  echo Core\Router::url($url_string);
}

function redirect($route) {
  $url = Core\Router::url($route);
  header("Location: {$url}");
}