<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

namespace maxlzp\doctrine\models\persons;


class Manager extends Person
{

    private $occupation = 'Manager';

    /**
     * @return string
     */
    public function getReport(): string
    {
        return $this->getName()
            . ' created a report at '
            . (new \DateTimeImmutable())->format('Y.m.d h:m:s');
    }

    /**
     * @return string
     */
    public function getOccupation(): string
    {
        return $this->occupation;
    }
}