<?php
/**
 * User: MaxLZp
 * @link https://github.com/MaxLZp
 */
// close_bug.php <bug-id>

use maxlzp\doctrine\models\Bug;

require_once 'bootstrap.php';

$bugId = (int)$argv[1];
$bug = $entityManager->find(Bug::class, $bugId);
if (null === $bug)
{
    echo "Cannot find bug to close [id: {$bugId}].\n";
    exit(0);
}

$bug->close();

$entityManager->flush();
echo "Bug closed [id: {$bugId}].\n";