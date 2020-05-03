# Setup

Install/setup Doctrine
```
composer require doctrine\orm:2.6.2
```

Create src/bootstrap.php:
```php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
  
const DS = DIRECTORY_SEPARATOR;
require_once ".." . DS . "vendor" . DS . "autoload.php";
  
$isDevMode = true;
$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/mappings"), $isDevMode);
  
$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . DS . '_data' . DS . 'db.sqlite',
);  
  
$entityManager = EntityManager::create($conn, $config);
```

Create src/cli-config.php:

```php

require_once 'bootstrap.php';
  
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
```
This file is required to run doctrine-commands (from src folder).

