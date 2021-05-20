<?php
  require $ROOT_DIR.'/config.php';

  // Core
  require $ROOT_DIR.'/core/Router.php';
  require $ROOT_DIR.'/core/View.php';
  require $ROOT_DIR.'/core/Database.php';

  require $ROOT_DIR.'/core/functions.php';

  // Controllers
  require $ROOT_DIR.'/app/Controllers/FooController.php';

  // Models
  require $ROOT_DIR.'/app/Foo.php';

  // Utilities
  require $ROOT_DIR.'/routes/routes.php';