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
     * @var string
     */
    private $id;

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
    public function __construct($title, $id = null)
    {
        $this->id = (null === $id) ? Uuid::uuid4() : $id;
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
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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