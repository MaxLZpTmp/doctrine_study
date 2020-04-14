<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

require_once 'bootstrap.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);