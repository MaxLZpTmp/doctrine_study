<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

use maxlzp\doctrine\models\household\Household;
use maxlzp\doctrine\models\household\Id;
use maxlzp\doctrine\models\household\Meter;

require_once __DIR__ . '/../../bootstrap.php';

$householdId = $argv[1];
$meterTitle = $argv[2];

if (null === $householdId) {
    throw  new InvalidArgumentException("Household id must be specified!");
}

$household = $entityManager->find(Household::class, Id::create($householdId));

if (null === $household) {
    throw new InvalidArgumentException("Cannot create meter. Husehold not found.");
}

if (null === $meterTitle)
{
    throw new InvalidArgumentException("Cannot create meter without title\n");
}

$meter = new Meter($household, $meterTitle);

$entityManager->persist($meter);
$entityManager->flush();

$meterId = $meter->getId();
echo "Meter with id: {$meterId} was created \n";
exit(0);