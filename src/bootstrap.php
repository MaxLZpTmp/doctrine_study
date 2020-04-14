<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

const DS = DIRECTORY_SEPARATOR;
require_once ".." . DS . "vendor" . DS . "autoload.php";

$isDevMode = true;
$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config"), $isDevMode);

$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . DS . 'data' . DS . 'db.sqlite',
);

$entityManager = EntityManager::create($conn, $config);

var_dump($conn);