# Single table inheritance

Create class hierarchy:
    
    Person:
        Manager   
        Customer  
        
Person.php
```php

namespace maxlzp\doctrine\models\persons;

use maxlzp\doctrine\models\household\Id;

/**
 * Class Person
 * @package maxlzp\doctrine\models\household
 */
abstract class Person
{
    /**
     * @var Id
     */
    private $id;
  
    /**
     * @var string
     */
    private $name;
  
    /**
     * Person constructor.
     * @param string $name
     * @param string|null $id
     */
    public function __construct(string $name, string $id = null)
    {
        $this->id = Id::create($id);
        $this->name = $name;
    }
  
    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }
  
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
```        
        
Customer.php 
```php
namespace maxlzp\doctrine\models\persons;
  
class Customer extends Person
{
    /**
     * @return string
     */
    public function makeOrder(): string
    {
        return $this->getName() .
            ' made an order at '
            . (new \DateTimeImmutable())->format('Y.m.d h:m:s');
    }
}
```

Manager.php
```php
namespace maxlzp\doctrine\models\persons;
  
class Manager extends Person
{
    /**
     * @return string
     */
    public function getReport(): string
    {
        return $this->getName()
            . ' created a report at '
            . (new \DateTimeImmutable())->format('Y.m.d h:m:s');
    }
}
```

Create mapping file for Person class (maxlzp.doctrine.models.persons.Person.dcm.xml)
```xml
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                          https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">
  
    <entity name="maxlzp\doctrine\models\persons\Person" table="persons" inheritance-type="SINGLE_TABLE">
        <discriminator-column name="discr" type="string" />
        <discriminator-map>
            <discriminator-mapping value="manager" class="maxlzp\doctrine\models\persons\Manager"/>
            <discriminator-mapping value="customer" class="maxlzp\doctrine\models\persons\Customer"/>
        </discriminator-map>
  
        <id name="id" type="uuidtype">
        </id>
  
        <field name="name" type="string" />
  
    </entity>
</doctrine-mapping>
```

Create mapping file for Manager class (maxlzp.doctrine.models.persons.Manager.dcm.xml)
```xml
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                          https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">
  
    <entity name="maxlzp\doctrine\models\persons\Manager" table="persons">
    </entity>
</doctrine-mapping>
```

Create mapping file for Customer class (maxlzp.doctrine.models.persons.Customer.dcm.xml)
```xml
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                          https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">
  
    <entity name="maxlzp\doctrine\models\persons\Customer" table="persons">
    </entity>
</doctrine-mapping>
```

Run 
```php
vendor/bin/doctrine orm:schema-tool:update --force
```

Create demo-script create_persons.php and run it
```php
use maxlzp\doctrine\models\persons\Customer;
use maxlzp\doctrine\models\persons\Manager;
  
require_once __DIR__ . '/../../bootstrap.php';
  
$manager = new Manager('Manager');
$customer = new Customer('Customer');
  
$entityManager->persist($manager);
$entityManager->persist($customer);
$entityManager->flush();
  
echo "Persons are created \n";
```

Create demo-script read_persons.php and run it
```php

use maxlzp\doctrine\models\persons\Customer;
use maxlzp\doctrine\models\persons\Manager;
  
require_once __DIR__ . '/../../bootstrap.php';
  
$managers = $entityManager->getRepository(Manager::class)->findAll();
$customers = $entityManager->getRepository(Customer::class)->findAll();
  
foreach ($managers as $manager) {
    echo $manager->getReport() . "\n";
}
  
foreach ($customers as $customer) {
    echo $customer->makeOrder() . "\n";
}
```

Child entities may have different fields. These fields must be mapped at corresponding mapping file.
 
Manager.php 
 ```php
    ...
    private $occupation = 'Manager';
  
    /**
     * @return string
     */
    public function getOccupation(): string
    {
        return $this->occupation;
    }
    ...
 ```
 
 maxlzp.doctrine.models.persons.Manager.dcm.xml:
 ```xml
    ...
    <field name="occupation" type="string" />
    ...
 ```
 
 And apply changes with 
 ```php
 vendor\bin\doctrine orm:schema-tools:update --force
 ```