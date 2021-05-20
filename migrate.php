<?php
require 'config.php';
require 'core/Database.php';

use Core\Database;

$db = new Database();
try {
  $db->open();
  $db->transact();

  $createMigrationsTable = "
    CREATE TABLE IF NOT EXISTS migrations (
      id INT AUTO_INCREMENT,
      name VARCHAR(255),
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (id)
    ) ENGINE=InnoDB;
  ";

  $db->run($createMigrationsTable);

  $rows = $db->select("SELECT name FROM migrations");
  $appliedMigrations = [];
  foreach($rows as $row) {
    $appliedMigrations[] = $row['name'];
  }
  $migrationFiles = scandir('migrations');
  $filesToMigrate = array_diff($migrationFiles, $appliedMigrations);
  if(count($filesToMigrate) > 2) {
    foreach($filesToMigrate as $file) {
      if($file == '.' || $file == '..') continue;
      require 'migrations/'.$file;
      $className = basename($file, '.php');
      $classInstance = new $className;
      $query = $classInstance->up();
      $db->run($query);
      $db->insert("INSERT INTO migrations (name) VALUES ('{$file}')");
      echo $file . ' migrated!' . PHP_EOL;
    }
  }
  else {
    echo "Nothing to migrate!" . PHP_EOL;
  }

  $db->commit();
}
catch(\Exeption $e) {
  echo $e . PHP_EOL;
  $db->rollback();
}
finally {
  $db->close();
}