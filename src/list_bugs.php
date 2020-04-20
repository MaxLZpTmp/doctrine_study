<?php
/**
 * User: MaxLZp
 * @link https://github.com/MaxLZp
 */

require_once 'bootstrap.php';

use maxlzp\doctrine\models\Bug;

$dql = "SELECT b, e, r FROM " . Bug::class . " b JOIN b.engineer e JOIN b.reporter r ORDER BY b.created DESC";

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


// Array Hydration of the Bug List
//
// For a simple list view like the previous one
// we only need read access to our entities
// and can switch the hydration from objects to simple PHP arrays instead.

//$dql = "SELECT b, e, r, p FROM Bug b JOIN b.engineer e ".
//    "JOIN b.reporter r JOIN b.products p ORDER BY b.created DESC";
//$query = $entityManager->createQuery($dql);
//$bugs = $query->getArrayResult();
//
//foreach ($bugs as $bug) {
//    echo $bug['description'] . " - " . $bug['created']->format('d.m.Y')."\n";
//    echo "    Reported by: ".$bug['reporter']['name']."\n";
//    echo "    Assigned to: ".$bug['engineer']['name']."\n";
//    foreach ($bug['products'] as $product) {
//        echo "    Platform: ".$product['name']."\n";
//    }
//    echo "\n";
//}
