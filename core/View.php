<?php
namespace Core;

class View {
  public static function render($view, $context = []) {
    $view = str_replace('.', '/', $view);
    if(count($context) > 0) {
      extract($context);
    }

    global $ROOT_DIR;
    require $ROOT_DIR."/resources/views/{$view}.php";
  }
}