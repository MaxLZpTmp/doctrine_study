# Doctrine study project

* [Setup](#SETUP)
* [Create Entities](#Create-Entities)
    * [Create Product mapping](#Create-Product-mapping-file)
* [Create Product script](#Create-Product-script)

## SETUP

#### Install/setup Doctrine
```
composer require doctrine\orm:2.6.2
```

#### Create src/bootstrap.php:
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

#### Create src/cli-config.php:

```php

require_once 'bootstrap.php';
  
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
```
This file is required to run following commands (from src folder)

##### Doctrine commands
```
vendor/bin/doctrine orm:schema-tool:drop --force
vendor/bin/doctrine orm:schema-tool:create
vendor/bin/doctrine orm:schema-tool:update --force

```
## Create Entities

### Create models/Product.php
```php
namespace maxlzp\doctrine\models;
 
class Product
{
    /**
     * @var int
     */
    private $id;
      
    /**
     * @var string
     */
    private $name;
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
  
    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
  
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
  
    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }
}
```

### Create models/User.php
```php
namespace maxlzp\doctrine\models;
 
class User
{
    private $banned;
    private $username;
    private $passwordHash;
    private $bans;
  
    public function toNickname(): string
    {
        return $this->username;
    }
  
    public function authenticate(string $password, callable $checkHash): bool
    {
        return $checkHash($password, $this->passwordHash) && ! $this->hasActiveBans();
    }
  
    public function changePassword(string $password, callable $hash): void
    {
        $this->passwordHash = $hash($password);
    }
  
    public function ban(\DateInterval $duration): void
    {
        assert($duration->invert !== 1);
        $this->bans[] = new Ban($this);
    }
}
```

### Create Product mapping file 
(mappings/maxlzp.doctrine.models.Product.dcm.xml)
```xml
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                          https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="maxlzp\doctrine\models\Product" table="products">
        <id name="id" type="integer">
            <generator strategy="AUTO" />
        </id>

        <field name="name" type="string" />
    </entity>
</doctrine-mapping>
```

### Update database schema
```
vendor/bin/doctrine orm:schema-tool:update --force --dump-sql
```

This should create database file according to mapped schema


## Create Product script

#### Create src/create_product.php
```php
require_once "bootstrap.php";
  
$newProductName = $argv[1];
  
$product = new Product();
$product->setName($newProductName);
  
$entityManager->persist($product);
$entityManager->flush();
  
echo "Created Product with ID " . $product->getId() . "\n";
```

#### Run script
```php
php create_product.php ORM
php create_product.php DBAL
```

This should create two records in the database