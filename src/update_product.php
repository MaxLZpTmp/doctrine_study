<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

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