<?php
namespace Core;

class Database {
  protected $mysqli;
  protected $is_connected = false;

  public function open() {
    global $DB_HOST;
    global $DB_USER;
    global $DB_PASS;
    global $DB_NAME;
    global $DB_PORT;
    $this->mysqli = new \mysqli($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME,$DB_PORT);

    // Check connection
    if ($this->mysqli->connect_errno) {
      $this->is_connected = false;
    }
    $this->is_connected = true; 
  }

  public function close() {
    if($this->is_connected) {
      $this->mysqli->close();
    }
  }

  public function transact() {
    if($this->is_connected) {
      $this->mysqli->begin_transaction();
    }
  }

  public function commit() {
    if($this->is_connected) {
      $this->mysqli->commit();
    }
  }

  public function rollback() {
    if($this->is_connected) {
      $this->mysqli->rollback();
    }
  }

  public function esc($str) {
    if(!$this->is_connected) return $str;
    return $this->mysqli->real_escape_string($str);
  }

  public function select($query) {
    $rows = [];

    if(!$this->is_connected) return $rows;

    // Perform query
    if ($qs = $this->mysqli->query($query)) {
      while($row = $qs->fetch_assoc()) {
        $rows[] = $row;
      }
      // Free result set
      $qs->free_result();
    }
    else {
      throw new \Exception("Select Error: " . $this->mysqli->error);
    }
    
    return $rows;
  }

  public function insert($query) {
    $insert_id = 0;

    if(!$this->is_connected) return $insert_id;

    // Perform query
    if ($this->mysqli->query($query) === TRUE) {
      $insert_id = $this->mysqli->insert_id;
    }
    else {
      throw new \Exception("Insert Error: " . $this->mysqli->error);
    }
    
    return $insert_id;
  }

  public function run($query) {
    if(!$this->is_connected) return;

    // Perform query
    if ($this->mysqli->query($query) !== TRUE) {
      throw new \Exception("Run Query Error: " . $this->mysqli->error);
    }
  }
}