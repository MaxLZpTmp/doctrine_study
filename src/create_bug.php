<?php
/**
 * User: MaxLZp
 * @link https://github.com/MaxLZp
 */
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

echo "Your new Bug Id: ".$bug->getId()."\n";