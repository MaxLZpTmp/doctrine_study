<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

use maxlzp\doctrine\models\household\Household;
use maxlzp\doctrine\models\household\Id;

require_once __DIR__ . '/../../bootstrap.php';

$householdId = $argv[1];

if (null === $householdId) {
    throw new InvalidArgumentException("Household id must be specified.");
}

$household = $entityManager->find(Household::class, Id::create($householdId));

if (null === $household) {
    throw new InvalidArgumentException("Household cannot be found.");
}

$entityManager->remove($household);
$entityManager->flush();

echo "Removed household\n";
