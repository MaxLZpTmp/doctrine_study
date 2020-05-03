<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

use maxlzp\doctrine\models\household\Id;

require_once __DIR__ . '/../../bootstrap.php';

$meterId = $argv[1];

if (null === $meterId) {
    echo "Invalid input\n";
    exit(1);
}

$meter = $entityManager->getRepository(\maxlzp\doctrine\models\household\Meter::class)
    ->find(Id::create($meterId));

if (null === $meter) {
    echo "Cannot find meter with id: {$meterId} \n";
    exit(1);
}

echo "Readings for " . $meter->getTitle() . " [" . $meter->getId() . " ]\n";
foreach ($meter->getReadings() as $reading) {
    echo "Date: " . $reading->getDate()->format("Y.m.d H:i:s") . "\tValue: " . $reading->getValue() . "\n";
}
echo "\n";
