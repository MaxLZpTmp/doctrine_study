<?php
/**
 * User: MaxLZp
 * @link https://github.com/MaxLZp
 */

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