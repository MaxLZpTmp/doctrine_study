<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

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