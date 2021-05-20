<?php

class m00001_create_foo_table {
  public function up() {
    $query = "
      CREATE TABLE foo (
        id INT AUTO_INCREMENT,
        name VARCHAR(255),
        address VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
      ) ENGINE=InnoDB;
    ";
    return $query;
  }
}