<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

use maxlzp\doctrine\models\household\Id;
use maxlzp\doctrine\models\household\Meter;

require_once __DIR__ . '/../../bootstrap.php';

$meterId = $argv[1];


if (null === $meterId) {
    throw new InvalidArgumentException("Meter id must be specified.");
}

$meter = $entityManager->find(Meter::class, Id::create($meterId));

if (null === $meter) {
    throw new InvalidArgumentException("Meter cannot be found.");
}

$entityManager->remove($meter);
$entityManager->flush();

echo "Removed meter\n";
