<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

namespace maxlzp\doctrine\models\household;

/**
 * Class Household
 * @package maxlzp\doctrine\models\household
 */
class Household
{
    /**
     * @var Id
     */
    private $id;

    /**
     * @var
     */
    private $meters;

    /**
     * @var string
     */
    private $title;

    /**
     * Household constructor.
     * @param string $title
     * @param null $id
     */
    public function __construct(string $title, $id = null)
    {
        $this->id = Id::create($id);
        $this->title = $title;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
       return $this->id;
    }

    /**
     *
     */
    public function getMeters()
    {
       return $this->meters;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}