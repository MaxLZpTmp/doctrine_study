# Doctrine study project

##SETUP

####Install Doctrine
```
composer require doctrine\orm:2.6.2
```

####Create src/bootstrap.php:
```php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
  
const DS = DIRECTORY_SEPARATOR;
require_once ".." . DS . "vendor" . DS . "autoload.php";
  
$isDevMode = true;
$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config"), $isDevMode);
  
$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . DS . 'data' . DS . 'db.sqlite',
);  
  
$entityManager = EntityManager::create($conn, $config);
```

####Create src/cli-config.php:
```php

require_once 'bootstrap.php';
  
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
```

#####Doctrine commands
```
vendor/bin/doctrine orm:schema-tool:drop --force
vendor/bin/doctrine orm:schema-tool:create
vendor/bin/doctrine orm:schema-tool:update --force

```

