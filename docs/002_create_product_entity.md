# Create Entities

Create models/Product.php
```php
namespace maxlzp\doctrine\models;
 
class Product
{
    /**
     * @var int
     */
    private $id;
      
    /**
     * @var string
     */
    private $name;
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
  
    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
  
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
  
    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }
}
```

Create models/User.php
```php
namespace maxlzp\doctrine\models;
 
class User
{
    private $banned;
    private $username;
    private $passwordHash;
    private $bans;
  
    public function toNickname(): string
    {
        return $this->username;
    }
  
    public function authenticate(string $password, callable $checkHash): bool
    {
        return $checkHash($password, $this->passwordHash) && ! $this->hasActiveBans();
    }
  
    public function changePassword(string $password, callable $hash): void
    {
        $this->passwordHash = $hash($password);
    }
  
    public function ban(\DateInterval $duration): void
    {
        assert($duration->invert !== 1);
        $this->bans[] = new Ban($this);
    }
}
```

Create Product mapping file 
(mappings/maxlzp.doctrine.models.Product.dcm.xml)
```xml
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                          https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="maxlzp\doctrine\models\Product" table="products">
        <id name="id" type="integer">
            <generator strategy="AUTO" />
        </id>

        <field name="name" type="string" />
    </entity>
</doctrine-mapping>
```

Update database schema
```
vendor/bin/doctrine orm:schema-tool:update --force --dump-sql
```

This should create database file according to mapped schema.