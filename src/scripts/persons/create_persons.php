<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

use maxlzp\doctrine\models\persons\Customer;
use maxlzp\doctrine\models\persons\Manager;

require_once __DIR__ . '/../../bootstrap.php';

$manager = new Manager('Manager');
$customer = new Customer('Customer');

$entityManager->persist($manager);
$entityManager->persist($customer);
$entityManager->flush();

echo "Persons are created \n";