<?php
/**
 * User: MaxLZp
 * @link https://github.com/MaxLZp
 */

namespace maxlzp\doctrine\repositories\household;

use Doctrine\ORM\EntityRepository;
use maxlzp\doctrine\models\household\Id;
use maxlzp\doctrine\models\household\Meter;
use maxlzp\doctrine\models\household\MeterReading;

class MeterReadingRepository extends EntityRepository
{

    /**
     * @return mixed
     */
    public function getSomething(Id $meterId)
    {
        $dql = "SELECT mr, m  FROM " . MeterReading::class . " mr "
            . " JOIN mr.meter m "
            . " WHERE m.id = :meter_id";

        $query = $this->getEntityManager()
            ->createQuery($dql);
        $query->setParameter('meter_id', $meterId->getId());

        return $query->getResult();
    }
}