<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

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