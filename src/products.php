<?php
/**
 * User: MaxLZp
 * @link https://github.com/MaxLZp
 */

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