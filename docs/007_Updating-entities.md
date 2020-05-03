# Updating entities

Modify Bug class to be able to close the bug

```php
class Bug
{ 
    ...
      
    public function close()
    {
        $this->status = "CLOSE";
    }
}
```

Create src\close_bug.php

```php
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

```

Run script
```php
php close_bug.php 1
```