<?php
/**
 * User: MaxLZp
 * @link https://github.com/MaxLZp
 */
// show_bug.php <bug-id>

use maxlzp\doctrine\models\Bug;

require_once 'bootstrap.php';

$bugId = (int)$argv[1];
$bug = $entityManager->find(Bug::class, $bugId);
if (null == $bug) {
    echo "Bug with id:{$bugId} not found\n";
    exit(0);
}

echo "Bug: " . $bug->getDescription() . "\n";
echo "Engineer: ".$bug->getEngineer()->getName()."\n";
exit(0);