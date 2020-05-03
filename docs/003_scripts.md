# Scripts

## Create Product script

Create src/create_product.php
```php
require_once "bootstrap.php";
  
$newProductName = $argv[1];
  
$product = new Product();
$product->setName($newProductName);
  
$entityManager->persist($product);
$entityManager->flush();
  
echo "Created Product with ID " . $product->getId() . "\n";
```

Run script
```php
php create_product.php ORM
php create_product.php DBAL
```

This should create two records in the database


Update database schema
```
vendor/bin/doctrine orm:schema-tool:update --force --dump-sql
```

This should create database file according to mapped schema


## List Products script

Create src/list_products.php
```php
require_once 'bootstrap.php';
  
use maxlzp\doctrine\models\Product;
  
$productRepository = $entityManager->getRepository(Product::class);
$products = $productRepository->findAll();
  
foreach ($products as $product) {
    echo sprintf("-%s\n", $product->getName());
}
```

Run script
```php
php list_products.php
```


## Show Product script

Create src/show_product.php
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

Run script
```php
php show_product.php 1
```


## Update Product script

Create src/update_product.php
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

Run script
```php
php update_product.php 1 NewORM
```