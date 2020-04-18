<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
require_once ".." . DS . "vendor" . DS . "autoload.php";

$isDevMode = true;
$pathsToXmlMapping = [
    __DIR__ . DS . "mappings",
];
$config = Setup::createXMLMetadataConfiguration($pathsToXmlMapping, $isDevMode);

$conn = [
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . DS . '_data' . DS . 'db.sqlite',
];

$entityManager = EntityManager::create($conn, $config);
