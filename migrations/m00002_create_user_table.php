<?php

class m00002_create_user_table {
  public function up() {
    $query = "
      CREATE TABLE user (
        id INT AUTO_INCREMENT,
        username VARCHAR(255),
        password VARCHAR(255),
        is_active TINYINT DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
      ) ENGINE=InnoDB; 
    ";
    return $query;
  }
}