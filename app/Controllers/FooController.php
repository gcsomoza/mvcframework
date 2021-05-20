<?php
namespace App\Controllers;

use Core\View;
use App\Foo;

class FooController {
  public static function index() {
    $foos = Foo::getAll();

    View::render('foo.index', [
      'foos' => $foos
    ]);
  }

  public static function show($id) {
    $foo = new Foo();
    if($id !== 'new') $foo->get($id);

    View::render('foo.show', [
      'foo' => $foo
    ]);
  }

  public static function save() {
    $foo = new Foo();
    $foo->id = $_POST['id'];
    $foo->name = $_POST['name'];
    $foo->address = $_POST['address'];
    $foo->save();
    $id = ($foo->id > 0) ? $foo->id : 'new';
    
    redirect("foo/{$id}");
  }
}