<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

namespace maxlzp\doctrine\models;

/**
 * Class Product
 * @package maxlzp\doctrine\models
 */
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

