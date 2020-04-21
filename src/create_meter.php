<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

require_once 'bootstrap.php';

$meterTitle = $argv[1];

if (null === $meterTitle)
{
    throw new InvalidArgumentException("Cannot create meter without title\n");
}

$meter = new \maxlzp\doctrine\models\household\Meter($meterTitle);

$entityManager->persist($meter);
$entityManager->flush();

$meterId = $meter->getId();
echo "Meter with id: {$meterId} was created \n";
exit(0);