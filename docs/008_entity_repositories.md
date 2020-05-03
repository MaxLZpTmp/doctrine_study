# Entity repositories

Example
```php
$product = $entityManager->getRepository('Product')
                         ->findOneBy([
                            'name' => $productName
                         ]);
                           
$bugs = $entityManager->getRepository('Bug')
                      ->findBy([
                        'status' => 'CLOSED'
                      ]);
  
foreach ($bugs as $bug) {
    // do stuff
}
```

#### Create repository

Create src\repositories\BugRepository class
(with dql's used previously put into separate methods)

```php
use Doctrine\ORM\EntityRepository;
  
class BugRepository extends EntityRepository
{
    public function getRecentBugs($number = 30)
    {
        $dql = "SELECT b, e, r FROM Bug b JOIN b.engineer e JOIN b.reporter r ORDER BY b.created DESC";
  
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setMaxResults($number);
        return $query->getResult();
    }
  
    public function getRecentBugsArray($number = 30)
    {
        $dql = "SELECT b, e, r, p FROM Bug b JOIN b.engineer e ".
               "JOIN b.reporter r JOIN b.products p ORDER BY b.created DESC";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setMaxResults($number);
        return $query->getArrayResult();
    }
  
    public function getUsersBugs($userId, $number = 15)
    {
        $dql = "SELECT b, e, r FROM Bug b JOIN b.engineer e JOIN b.reporter r ".
               "WHERE b.status = 'OPEN' AND e.id = ?1 OR r.id = ?1 ORDER BY b.created DESC";
  
        return $this->getEntityManager()->createQuery($dql)
                             ->setParameter(1, $userId)
                             ->setMaxResults($number)
                             ->getResult();
    }
  
    public function getOpenBugsByProduct()
    {
        $dql = "SELECT p.id, p.name, count(b.id) AS openBugs FROM Bug b ".
               "JOIN b.products p WHERE b.status = 'OPEN' GROUP BY p.id";
        return $this->getEntityManager()->createQuery($dql)->getScalarResult();
    }
}

```

Update Bug mapping-file (add "repository-class" attribute).



```xmp

      ...
     <entity name="Bug" table="bugs" repository-class="maxlzp\doctrine\repositories\BugRepository">

      </entity>
      ...
      
```

And use it instead of dql's and querying entityManager.

Create src\list_bugs_repository.php^

```php
use maxlzp\doctrine\models\Bug;
  
require_once 'bootstrap.php';
  
$bugs = $entityManager->getRepository(Bug::class)->getRecentBugs();
  
foreach ($bugs as $bug) {
    echo $bug->getDescription()." - ".$bug->getCreated()->format('d.m.Y')."\n";
    echo "    Reported by: ".$bug->getReporter()->getName()."\n";
    echo "    Assigned to: ".$bug->getEngineer()->getName()."\n";
    foreach ($bug->getProducts() as $product) {
        echo "    Platform: ".$product->getName()."\n";
    }
    echo "\n";
}
```

Run script
```
php list_bugs_repository.php
```
