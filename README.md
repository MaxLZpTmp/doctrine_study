# Doctrine study project

* [Setup](#SETUP)
* [Create Entities](#Create-Entities)
    * [Create Product mapping](#Create-Product-mapping-file)
* ["Create Product" script](#Create-Product-script)
* ["List Products" script](#List-Products-script)
* ["Show Product" script](#Show-Product-script)
* ["Update Product" script](#Update-Product-script)
* [Create Bug and User entities. Create mapping files](#Create-Bug-User-entities)
* [Create entities relations](#Create-Relations)


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


### Update database schema
```
vendor/bin/doctrine orm:schema-tool:update --force --dump-sql
```

This should create database file according to mapped schema


## List Products script

#### Create src/list_products.php
```php
require_once 'bootstrap.php';
  
use maxlzp\doctrine\models\Product;
  
$productRepository = $entityManager->getRepository(Product::class);
$products = $productRepository->findAll();
  
foreach ($products as $product) {
    echo sprintf("-%s\n", $product->getName());
}
```

#### Run script
```php
php list_products.php
```


## Show Product script

#### Create src/show_product.php
```php
require_once 'bootstrap.php';

use maxlzp\doctrine\models\Product;
  
$id = $argv[1];
$product = $entityManager->find(Product::class, $id);

if ($product === null) {
    echo "No product found.\n";
    exit(1);
}

echo sprintf("-%s\n", $product->getName());
```

#### Run script
```php
php show_product.php 1
```


## Update Product script

#### Create src/update_product.php
```php
require_once 'bootstrap.php';
  
use maxlzp\doctrine\models\Product;
  
$id = $argv[1];
$newName = $argv[2];
  
$product = $entityManager->find(Product::class, $id);
  
if (null == $product) {
    echo "Product not found.\n";
    exit(1);
}
  
$product->setName($newName);
  
$entityManager->flush();
```

#### Run script
```php
php update_product.php 1 NewORM
```

## Create Bug User entities

#### Create src/models/Bug.php
```php

namespace maxlzp\doctrine\models;
  
use Doctrine\ORM\Mapping as ORM;
  
class Bug
{
    /**
     * @var int
     */
    protected $id;
  
    /**
     * @var string
     */
    protected $description;
  
    /**
     * @var \DateTime
     */
    protected $created;
  
    /**
     * @var string
     */
    protected $status;
  
    public function getId()
    {
        return $this->id;
    }
  
    public function getDescription()
    {
        return $this->description;
    }
  
    public function setDescription($description)
    {
        $this->description = $description;
    }
  
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }
  
    public function getCreated()
    {
        return $this->created;
    }
  
    public function setStatus($status)
    {
        $this->status = $status;
    }
  
    public function getStatus()
    {
        return $this->status;
    }
}
```

#### Create Bug mapping file (src/mappings/maxlzp.doctrine.models.Bug.dcm.xml)

```xml
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                          https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="maxlzp\doctrine\models\Bug" table="bugs">
        <id name="id" type="integer">
            <generator strategy="AUTO" />
        </id>
  
        <field name="description" type="string" />
        <field name="created" type="datetime" />
        <field name="status" type="string" />
    </entity>
</doctrine-mapping>
```
#### Create(or update) src/models/User.php
```php
namespace maxlzp\doctrine\models;

/**
 * Class User
 * @package maxlzp\doctrine\models
 */
class User
{
    /**
     * @var int
     */
    protected $id;
  
    /**
     * @var string
     */
    protected $name;
  
    public function getId()
    {
        return $this->id;
    }
  
    public function getName()
    {
        return $this->name;
    }
  
    public function setName($name)
    {
        $this->name = $name;
    }
}
```

#### Create Bug mapping file (src/mappings/maxlzp.doctrine.models.User.dcm.xml)

```xml
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                          https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="maxlzp\doctrine\models\User" table="users">
        <id name="id" type="integer">
            <generator strategy="AUTO" />
        </id>
  
        <field name="name" type="string" />
    </entity>
</doctrine-mapping>
```
## Create Relations

#### Update Bug-class
```php
use Doctrine\Common\Collections\ArrayCollection;

class Bug
{
    // ... (previous code)

    protected $products;
  
    protected $engineer;
    protected $reporter;
  
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
      
    public function setEngineer(User $engineer)
    {
        $engineer->assignedToBug($this);
        $this->engineer = $engineer;
    }
  
    public function setReporter(User $reporter)
    {
        $reporter->addReportedBug($this);
        $this->reporter = $reporter;
    }
  
    public function getEngineer()
    {
        return $this->engineer;
    }
  
    public function getReporter()
    {
        return $this->reporter;
    }  
      
    public function assignToProduct(Product $product)
    {
        $this->products[] = $product;
    }
  
    public function getProducts()
    {
        return $this->products;
    }      
}

```

#### Update User class

```php
use Doctrine\Common\Collections\ArrayCollection;

class User
{
    // ... (previous code)

    protected $reportedBugs;
    protected $assignedBugs;
    public function __construct()
    {
        $this->reportedBugs = new ArrayCollection();
        $this->assignedBugs = new ArrayCollection();
    }
      
    public function addReportedBug(Bug $bug)
    {
        $this->reportedBugs[] = $bug;
    }
  
    public function assignedToBug(Bug $bug)
    {
        $this->assignedBugs[] = $bug;
    }    
}

```

#### Update Bug mapping file
```php
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                          https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Bug" table="bugs">
        <id name="id" type="integer">
            <generator strategy="AUTO" />
        </id>

        <field name="description" type="text" />
        <field name="created" type="datetime" />
        <field name="status" type="string" />

        <many-to-one target-entity="User" field="reporter" inversed-by="reportedBugs" />
        <many-to-one target-entity="User" field="engineer" inversed-by="assignedBugs" />

        <many-to-many target-entity="Product" field="products" />
    </entity>
</doctrine-mapping>

```
Since reporter and engineer are on the owning side of a bi-directional relation, we also have to specify the inversed-by attribute. They have to point to the field names on the inverse side of the relationship.


#### Update User mapping file
```xml
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                          https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

     <entity name="User" table="users">
         <id name="id" type="integer">
             <generator strategy="AUTO" />
         </id>

         <field name="name" type="string" />

         <one-to-many target-entity="Bug" field="reportedBugs" mapped-by="reporter" />
         <one-to-many target-entity="Bug" field="assignedBugs" mapped-by="engineer" />
     </entity>
</doctrine-mapping>
```


Apply changes
```
vendor/bin/doctrine orm:schema-tool:update --force
```