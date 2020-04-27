<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

namespace maxlzp\doctrine\models\household;

use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;

/**
 * Class Meter
 * @package maxlzp\doctrine\models\household
 */
class Meter
{
    /**
     * @var Id
     */
    private $id;

    /**
     * @var Household
     */
    private $household;

    /**
     * @var string
     */
    private $title;

    /**
     * @var
     */
    private $readings;

    /**
     * Meter constructor.
     * @param $title
     */
    public function __construct($household, $title, $id = null)
    {
        $this->id = Id::create($id);
        $this->household = $household;
        $this->title = $title;
        $this->readings = new ArrayCollection();
    }

    /**
     * @param \DateTimeImmutable $date
     * @param $value
     */
    public function addReading(\DateTimeImmutable $date, $value)
    {
        $this->readings->add(new MeterReading($this, $date, $value));
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return Household
     */
    public function getHousehold(): Household
    {
        return $this->household;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getReadings()
    {
        return $this->readings;
    }

}