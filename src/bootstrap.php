<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Types\Type;
use maxlzp\doctrine\_data\mappings\types\UuidType;

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
require_once ".." . DS . 'vendor' . DS . 'autoload.php';

$isDevMode = true;
$pathsToXmlMapping = [
    __DIR__ . DS . '_data' . DS . 'mappings',
];
$pathToProxies = __DIR__ . DS . '_data' . DS . 'Proxies';
$proxiesNamespace = 'maxlzp\\doctrine\\_data\\Proxies';

$config = Setup::createXMLMetadataConfiguration($pathsToXmlMapping, $isDevMode);
$config->setProxyDir($pathToProxies);
$config->setProxyNamespace($proxiesNamespace);

$conn = [
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . DS . '_data' . DS . 'db.sqlite',
];

$entityManager = EntityManager::create($conn, $config);


Type::addType('uuidtype', UuidType::class);

$conn = $entityManager->getConnection();
$conn->getDatabasePlatform()->registerDoctrineTypeMapping('string', 'uuidtype');
//$conn->getDatabasePlatform()->registerDoctrineTypeMapping('uuidtype', 'uuidtype');


