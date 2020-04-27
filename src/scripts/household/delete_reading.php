<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

use maxlzp\doctrine\models\household\Id;
use maxlzp\doctrine\models\household\MeterReading;

require_once __DIR__ . '/../../bootstrap.php';

$readingId = $argv[1];

if (null === $readingId) {
    throw new InvalidArgumentException("Reading id must be aupplied.");
}

$reading = $entityManager->find(MeterReading::class, Id::create($readingId));

if (null === $reading) {
    throw new InvalidArgumentException("Cannotfind reading to delete.");
}

$entityManager->remove($reading);
$entityManager->flush();

echo 'Reading was deleted successfully!\n';