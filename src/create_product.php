<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */
// create_product.php <name>
require_once 'bootstrap.php';

use maxlzp\doctrine\models\Product;


$newProductName = $argv[1];

$product = new Product();
$product->setName($newProductName);

$entityManager->persist($product);
$entityManager->flush();

echo "Created Product with ID " . $product->getId() . "\n";

