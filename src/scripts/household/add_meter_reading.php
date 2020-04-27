<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

use maxlzp\doctrine\models\household\Id;
use maxlzp\doctrine\models\household\Meter;

require_once __DIR__ . '/../../bootstrap.php';

$meterId = $argv[1];
$value = (float)$argv[2];
$date = $argc < 4 ? new DateTimeImmutable() : $argv[3];

if (null === $meterId || null === $value)
{
    echo "Invalid input. Reading was not added.\n";
    exit(1);
}

$meter = $entityManager->find(Meter::class, Id::create($meterId));

if (null == $meter)
{
    echo "Meter was not found. id: {$meterId} \n";
    exit(1);
}

$meter->addReading($date, $value);
$entityManager->flush();

echo "Reading was added\n";
exit(0);
