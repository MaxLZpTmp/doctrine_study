
# Create User Bug Relations

Update Bug-class
```php
use Doctrine\Common\Collections\ArrayCollection;

class Bug
{
    // ... (previous code)

    protected $products;
  
    protected $engineer;
    protected $reporter;
  
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
      
    public function setEngineer(User $engineer)
    {
        $engineer->assignedToBug($this);
        $this->engineer = $engineer;
    }
  
    public function setReporter(User $reporter)
    {
        $reporter->addReportedBug($this);
        $this->reporter = $reporter;
    }
  
    public function getEngineer()
    {
        return $this->engineer;
    }
  
    public function getReporter()
    {
        return $this->reporter;
    }  
      
    public function assignToProduct(Product $product)
    {
        $this->products[] = $product;
    }
  
    public function getProducts()
    {
        return $this->products;
    }      
}

```

Update User class

```php
use Doctrine\Common\Collections\ArrayCollection;

class User
{
    // ... (previous code)

    protected $reportedBugs;
    protected $assignedBugs;
    public function __construct()
    {
        $this->reportedBugs = new ArrayCollection();
        $this->assignedBugs = new ArrayCollection();
    }
      
    public function addReportedBug(Bug $bug)
    {
        $this->reportedBugs[] = $bug;
    }
  
    public function assignedToBug(Bug $bug)
    {
        $this->assignedBugs[] = $bug;
    }    
}

```

Update Bug mapping file
```php
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                          https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Bug" table="bugs">
        <id name="id" type="integer">
            <generator strategy="AUTO" />
        </id>

        <field name="description" type="text" />
        <field name="created" type="datetime" />
        <field name="status" type="string" />

        <many-to-one target-entity="User" field="reporter" inversed-by="reportedBugs" />
        <many-to-one target-entity="User" field="engineer" inversed-by="assignedBugs" />

        <many-to-many target-entity="Product" field="products" />
    </entity>
</doctrine-mapping>

```
Since reporter and engineer are on the owning side of a bi-directional relation, we also have to specify the inversed-by attribute. They have to point to the field names on the inverse side of the relationship.


Update User mapping file
```xml
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                          https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

     <entity name="User" table="users">
         <id name="id" type="integer">
             <generator strategy="AUTO" />
         </id>

         <field name="name" type="string" />

         <one-to-many target-entity="Bug" field="reportedBugs" mapped-by="reporter" />
         <one-to-many target-entity="Bug" field="assignedBugs" mapped-by="engineer" />
     </entity>
</doctrine-mapping>
```


Apply changes
```
vendor/bin/doctrine orm:schema-tool:update --force
```