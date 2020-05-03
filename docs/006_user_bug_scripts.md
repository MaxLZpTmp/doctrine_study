# User and Bug scripts

## Create User script

Create src\create_user.php

```php
use maxlzp\doctrine\models\User;
  
require_once 'bootstrap.php';
  
$newUsername = $argv[1];
  
$user = new User();
$user->setName($newUsername);
  
$entityManager->persist($user);
$entityManager->flush();
  
echo "Created User with id:" . $user->getId() . "\n";
```
Run script
```
php create_user.php berbelei
```


## Create Bug script

Create src/create_bug.php

```php
// create_bug.php <reporter-id> <engineer-id> <product-ids>
// create_bug.php 1 1 1,2,3
  
use maxlzp\doctrine\models\Bug;
use maxlzp\doctrine\models\Product;
use maxlzp\doctrine\models\User;
  
require_once 'bootstrap.php';
  
$reporterId = $argv[1];
$engineerId = $argv[2];
$productIds = explode(',', $argv[3]);
  
$reporter = $entityManager->find(User::class, $reporterId);
$engineer = $entityManager->find(User::class, $engineerId);
  
if (!$reporter || !$engineer) {
    echo "No reporter and/or engineer found for the given id(s).\n";
    exit(1);
}
  
$bug = new Bug();
$bug->setDescription("Something does not work!");
$bug->setCreated(new \DateTime());
$bug->setStatus("OPEN");
  
foreach ($productIds as $productId) {
    $product = $entityManager->find(Product::class, $productId);
    $bug->assignToProduct($product);
}
  
$bug->setReporter($reporter);
$bug->setEngineer($engineer);
  
$entityManager->persist($bug);
$entityManager->flush();
  
  
echo "Your new Bug Id: " . $bug->getId() . "\n";
```

Run script
```
php create_bug.php 1 1 1
```

## Create BugsList script

Create src/list_bugs.php

```php

require_once 'bootstrap.php';
use maxlzp\doctrine\models\Bug;
  
$dql = "SELECT b, e, r FROM " . Bug::class . " b JOIN b.engineer e JOIN b.reporter r ORDER BY b.created DESC";
// Next line is from doctrine GetStarted tutorial doesn't work
// Cannot find Bug class
//$dql = "SELECT b, e, r FROM Bug b JOIN b.engineer e JOIN b.reporter r ORDER BY b.created DESC";
  
$query = $entityManager->createQuery($dql);
$query->setMaxResults(30);
$bugs = $query->getResult();
  
foreach ($bugs as $bug) {
    echo $bug->getDescription()." - ".$bug->getCreated()->format('d.m.Y')."\n";
    echo "    Reported by: ".$bug->getReporter()->getName()."\n";
    echo "    Assigned to: ".$bug->getEngineer()->getName()."\n";
    foreach ($bug->getProducts() as $product) {
        echo "    Platform: ".$product->getName()."\n";
    }
    echo "\n";
}

```

Run script
```
php list_bugs.php
```


## Show Bug script

Create src\show_bug.php

```php 
// show_bug.php <bug-id>
  
use maxlzp\doctrine\models\Bug;
  
require_once 'bootstrap.php';
  
$bugId = (int)$argv[1];
$bug = $entityManager->find(Bug::class, $bugId);
  
if (null == $bug) {
    echo "Bug with id:${bugId} not found\n";
    exit(0);
}
  
echo "Bug: " . $bug->getDescription() . "\n";
echo "Engineer: ".$bug->getEngineer()->getName()."\n";
exit(0);
```

Run script
```
php show_bug.php 1

```

##### Proxies configuration
Proxy class will be generated in the Proxies folder.
Config this folder in bootstrap.php:
```php
... Previous code ...
  
$pathToProxies = __DIR__ . DS . '_data' . DS . 'Proxies';
$proxiesNamespace = 'maxlzp\\doctrine\\_data\\Proxies';
  
... Previous code ...
  
$config->setProxyDir($pathToProxies);
$config->setProxyNamespace($proxiesNamespace);

```


## User dashboard

Create src\dashboard.php
```php
use maxlzp\doctrine\models\Bug;
  
require_once 'bootstrap.php';
  
$userId = (int)$argv[1];
  
$dql = "SELECT b, e, r FROM " . Bug::class . " b "
    . "JOIN b.reporter r "
    . "JOIN b.engineer e "
    . "WHERE b.status = 'OPEN' AND (e.id = ?1 OR r.id = ?1) "
    . "ORDER BY b.created DESC";
  
$bugs = $entityManager
    ->createQuery($dql)
    ->setParameter(1, $userId)
    ->setMaxResults(15)
    ->getResult();
  
echo "\nYou have created or assigned to " . \count($bugs) . " open bugs:\n\n";
  
foreach ($bugs as $bug) {
    echo $bug->getId() . " - " . $bug->getDescription()."\n";
}
```

Run script
```
php dashboard.php 1
```


## Number Of Bugs

Create src\products.php

```php

use maxlzp\doctrine\models\Bug;
  
require_once 'bootstrap.php';
  
$dql = "SELECT p.id, p.name, COUNT(b.id) as openBugs FROM " . Bug::class . " b "
    . "JOIN b.products p "
    . "WHERE b.status = 'OPEN' "
    . "GROUP BY p.id";
  
$products = $entityManager
    ->createQuery($dql)
    ->getScalarResult();
  
foreach ($products as $productBug)
{
    echo $productBug['name'] . " has " .$productBug['openBugs'] ." bugs. \n";
}
```

Run script
```
php products.php
```
