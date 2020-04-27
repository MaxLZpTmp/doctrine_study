<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

require_once __DIR__ . '/../../bootstrap.php';

$householdTitle = $argv[1];

if (null === $householdTitle)
{
    throw new InvalidArgumentException("Cannot create household without title\n");
}

$meter = new \maxlzp\doctrine\models\household\Household($householdTitle);

$entityManager->persist($meter);
$entityManager->flush();

$meterId = $meter->getId();
echo "Household with id: {$meterId} was created \n";
exit(0);