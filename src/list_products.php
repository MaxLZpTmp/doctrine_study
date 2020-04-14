<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

require_once 'bootstrap.php';

use maxlzp\doctrine\models\Product;

$productRepository = $entityManager->getRepository(Product::class);
$products = $productRepository->findAll();

foreach ($products as $product) {
    echo sprintf("-%s\n", $product->getName());
}

