<?php
namespace App;

use Core\Database;

class Foo {
  public $id = 0;
  public $name = '';
  public $address = '';

  protected function __setParameters($parameters = []) {
    foreach($parameters as $key => $value) {
      $this->{$key} = $value;
    }
  }

  public function __construct($parameters = []) {
    $this->__setParameters($parameters);
  }

  public function get($id) {
    $db = new Database();
    $db->open();
    $rows = $db->select(sprintf("SELECT * FROM foo WHERE id = %d", $db->esc($id)));
    if(count($rows) > 0) {
      $this->__setParameters($rows[0]);
    }
    $db->close();
  }

  public static function getAll() {
    $db = new Database();

    $foos = [];
    $db->open();
    $rows = $db->select("SELECT * FROM foo");
    foreach($rows as $row) {
      $foos[] = new Foo($row);
    }
    $db->close();

    return $foos;
  }

  public function save() {
    $db = new Database();

    try {
      $db->open();
      $db->transact();
      if($this->id == 0) {
        $insertQuery = sprintf(
          "INSERT INTO foo (name, address) VALUES ('%s', '%s')",
          $db->esc($this->name),
          $db->esc($this->address)
        );
        $this->id = $db->insert($insertQuery);
      }
      else {
        $updateQuery = sprintf(
          "UPDATE foo SET name = '%s', address = '%s' WHERE id = %d",
          $db->esc($this->name),
          $db->esc($this->address),
          $db->esc($this->id)
        );
        $db->run($updateQuery);
      }
      $db->commit();
    }
    catch(\Exception $e) {
      $db->rollback();
    }
    finally {
      $db->close();
    }
  }

  public function delete() {
    $db = new Database();
    $db->open();
    $db->run(sprintf("DELETE FROM foo WHERE id = %d", $db->esc($this->id)));
    $db->close();
  }
}