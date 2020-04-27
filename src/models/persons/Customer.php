<?php
/**
 * User: maxlzp
 * @link https://github.com/MaxLZp
 */

namespace maxlzp\doctrine\models\persons;


class Customer extends Person
{
    /**
     * @return string
     */
    public function makeOrder(): string
    {
        return $this->getName() .
            ' made an order at '
            . (new \DateTimeImmutable())->format('Y.m.d h:m:s');
    }
}