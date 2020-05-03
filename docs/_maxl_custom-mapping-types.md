# Custom mapping types

Create class to map src\models\household\Id :
```php
namespace maxlzp\doctrine\models\household;
  
use Ramsey\Uuid\Uuid;
  
/**
 * Class Id
 * @package maxlzp\doctrine\models\household
 */
class Id
{
    /**
     * @var string
     */
    private $id;
  
    /**
     * Id constructor.
     * @param string|null $id
     */
    protected function __construct(string $id = null)
    {
        $this->id = (null === $id) ? Uuid::uuid4() : $id;
    }
  
    /**
     * Factory method
     * 
     * @param string|null $id
     * @return Id
     */
    public static function create(string $id = null): Id
    {
       return new self($id); 
    }
  
    /**
     * Returns Id value
     * 
     * @return string
     */
    public function getId(): string
    {
       return $this->id; 
    }
  
    /**
     * Must be implemented.
     * Allows Doctrine Custom mapping type tp use this class
     * 
     * @return string
     */
    public function __toString(): string
    {
        return $this->getId();
    }
}
```

Replace string-Id with Id value-object in classes that are using it (MeterReading, Meter, etc.)
```php

/**
 * Class MeterReading
 * @package maxlzp\doctrine\models\household
 */
class MeterReading
{
    /**
     * @var Id
     */
    private $id;
  
    ...
  
    /**
     * MeterReading constructor.
     * @param Meter $meter
     * @param \DateTimeImmutable $date
     * @param $value
     * @param null $id
     */
    public function __construct(Meter $meter, \DateTimeImmutable $date, $value, $id = null)
    {
        $this->guardNonNumericValue($value);
        $this->id = Id::create($id);
        $this->date = $date;
        $this->value = $value;
        $this->meter = $meter;
    }
  
    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }
  
    ...

}

```

Subclass Doctrine\DBAL\Types\Type and implement/override the methods.

Create src\\_data\mappings\types\UuidType.php :

```php
namespace maxlzp\doctrine\_data\mappings\types;
  
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
  
class UuidType extends Type
{
    const UUIDTYPE = 'uuidtype';
  
    /**
     * Gets the SQL declaration snippet for a field of this type.
     *
     * @param mixed[] $fieldDeclaration The field declaration.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $this->getName();
        //return 'ID'; 
    }
  
    /**
     * Create object from database value
     * 
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return Id
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return Id::create($value);
    }
  
    /**
     * Create database value from object
     * 
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getId();
    }
  
    /**
     * Gets the name of this type.
     *
     * @return string
     *
     * @todo Needed?
     */
    public function getName()
    {
        return self::UUIDTYPE;
    }
}

```

In bootstrapping code (bootstrap.php) register this type:

```php 
// ...
use Doctrine\DBAL\Types\Type;
// ...
// Register my type
Type::addType('uuidtype', UuidType::class);

```

To convert the underlying database type of your new mytype directly into an instance of MyType when performing schema operations, the type has to be registered with the database platform as well:

Add to \src\bootstrap.php
```php
...
$conn = $entityManager->getConnection();
$conn->getDatabasePlatform()->registerDoctrineTypeMapping('string', 'uuidtype');
$conn->getDatabasePlatform()->registerDoctrineTypeMapping('uuidtype', 'string'); //MaxL: must be added. Otherwise throws an error: unknown database type uuiidtype requested
```
  
Update Mapping file(s) (maxlzp.doctrine.models.household.MeterReading.dcm.xml):
```xml
...
        <id name="id" type="uuidtype">
        </id>
...        
```

Id-class must be used now in scripts instead of string.
src\create_meter.php:
```php
...
$householdId = $argv[1];
$household = $entityManager->find(Household::class, Id::create($householdId));
...
```

Similar changes in src\add_meter_reading.php etc. 
