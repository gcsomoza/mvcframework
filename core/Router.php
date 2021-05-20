<?php
namespace Core;

class Router {
  public static $routes = [];
  
  public static function url($url_string) {
    return '?url=' . $url_string;
  }

  public static function route($method, $url, $callback) {
    $route_key = $method.'_'.$url;
    self::$routes[$route_key] = [
      'method' => $method,
      'url' => $url,
      'callback' => $callback
    ];
  }

  public static function run() {
    $request_method = strtolower($_SERVER['REQUEST_METHOD']);
    $url = '';
    if(isset($_GET['url'])) {
      $url = $_GET['url'];
    }
    $url = filter_var($url, FILTER_SANITIZE_URL);

    foreach(self::$routes as $key => $route) {
      if($request_method == $route['method'] && self::isUrlMatch($url, $route['url'], $parameters)) {
        call_user_func_array($route['callback'], $parameters);
        break;
      }
      else {
        continue;
      }
    }
  }

  protected static function isUrlMatch($url, $route_url, &$parameters) {
    $pattern =  preg_replace('/(\\/)/i', '\\\\$1', $route_url);
    $pattern =  preg_replace('/(\\{[a-zA-Z0-9_]+\\})/i', '[^\\/]+', $pattern);
    preg_match('/^'.$pattern.'$/', $url, $matches);
    $is_match = count($matches) > 0;

    $parameters = [];
    if($is_match > 0) {
      $url = explode('/', $url);
      $route_url = explode('/', $route_url);
      foreach($route_url as $index => $route_url_value) {
        if(strlen($route_url_value) > 2 && $route_url_value[0] == '{' && $route_url_value[strlen($route_url_value) - 1] == '}') {
          $parameters[] = $url[$index];
        }
      }
    }
    return $is_match;
  }
}