# Create Bug User entities

Create src/models/Bug.php
```php

namespace maxlzp\doctrine\models;
  
use Doctrine\ORM\Mapping as ORM;
  
class Bug
{
    /**
     * @var int
     */
    protected $id;
  
    /**
     * @var string
     */
    protected $description;
  
    /**
     * @var \DateTime
     */
    protected $created;
  
    /**
     * @var string
     */
    protected $status;
  
    public function getId()
    {
        return $this->id;
    }
  
    public function getDescription()
    {
        return $this->description;
    }
  
    public function setDescription($description)
    {
        $this->description = $description;
    }
  
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }
  
    public function getCreated()
    {
        return $this->created;
    }
  
    public function setStatus($status)
    {
        $this->status = $status;
    }
  
    public function getStatus()
    {
        return $this->status;
    }
}
```

Create Bug mapping file (src/mappings/maxlzp.doctrine.models.Bug.dcm.xml)

```xml
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                          https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="maxlzp\doctrine\models\Bug" table="bugs">
        <id name="id" type="integer">
            <generator strategy="AUTO" />
        </id>
  
        <field name="description" type="string" />
        <field name="created" type="datetime" />
        <field name="status" type="string" />
    </entity>
</doctrine-mapping>
```
Create(or update) src/models/User.php
```php
namespace maxlzp\doctrine\models;

/**
 * Class User
 * @package maxlzp\doctrine\models
 */
class User
{
    /**
     * @var int
     */
    protected $id;
  
    /**
     * @var string
     */
    protected $name;
  
    public function getId()
    {
        return $this->id;
    }
  
    public function getName()
    {
        return $this->name;
    }
  
    public function setName($name)
    {
        $this->name = $name;
    }
}
```

Create Bug mapping file (src/mappings/maxlzp.doctrine.models.User.dcm.xml)

```xml
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                          https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="maxlzp\doctrine\models\User" table="users">
        <id name="id" type="integer">
            <generator strategy="AUTO" />
        </id>
  
        <field name="name" type="string" />
    </entity>
</doctrine-mapping>
```
