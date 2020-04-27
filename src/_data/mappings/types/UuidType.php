<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

namespace maxlzp\doctrine\_data\mappings\types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use maxlzp\doctrine\models\household\Id;

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
        return 'ID';
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