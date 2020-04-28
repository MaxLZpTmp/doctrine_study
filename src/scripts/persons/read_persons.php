<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

use maxlzp\doctrine\models\persons\Customer;
use maxlzp\doctrine\models\persons\Manager;

require_once __DIR__ . '/../../bootstrap.php';

$managers = $entityManager->getRepository(Manager::class)->findAll();
$customers = $entityManager->getRepository(Customer::class)->findAll();

foreach ($managers as $manager) {
    echo $manager->getOccupation() . "\t" . $manager->getReport() . "\n";
}

foreach ($customers as $customer) {
    echo $customer->makeOrder() . "\n";
}
