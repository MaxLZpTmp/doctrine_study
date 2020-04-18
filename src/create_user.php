<?php
/**
 * User: MaxLZp
 * @link https://github.com/MaxLZp
 */

use maxlzp\doctrine\models\User;

require_once 'bootstrap.php';

$newUsername = $argv[1];

$user = new User();
$user->setName($newUsername);

$entityManager->persist($user);
$entityManager->flush();

echo "Created User with id:" . $user->getId() . "\n";
