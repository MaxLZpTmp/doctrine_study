<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

namespace maxlzp\doctrine\models\household;

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

    /**
     * @var \DateTimeImmutable
     */
    private $date;

    /**
     * @var
     */
    private $value;


    /**
     * @var Meter
     */
    private $meter;


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

    /**
     * @return Meter
     */
    public function getMeter(): Meter
    {
        return $this->meter;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     *
     * @throws \InvalidArgumentException
     */
    private function guardNonNumericValue($value)
    {
        if (is_numeric($value)) return;
        throw new \InvalidArgumentException();
    }
}