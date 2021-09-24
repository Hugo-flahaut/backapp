<?php

namespace App\Repository;

use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Room|null find($id, $lockMode = null, $lockVersion = null)
 * @method Room|null findOneBy(array $criteria, array $orderBy = null)
 * @method Room[]    findAll()
 * @method Room[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Room::class);
    }

    /**
      * @return Room[] Returns an array of Room objects
      */
    /**
     *  $entityManager = $this->getEntityManager();
     *  $query = $entityManager->createQuery(
     * 'SELECT DISTINCT r.id,r.price,b.date_start,b.end_date from `room` As r 
     * LEFT JOIN booking_room as br ON r.id = br.room_id
     * LEFT JOIN booking as b ON b.id = br.booking_id 
     * where r.type = "type1" 
     * AND b.date_start IS NULL OR "2021-09-23" NOT BETWEEN b.date_start AND b.end_date 
     * AND "2021-09-24" NOT BETWEEN b.date_start AND b.end_date ORDER BY r.id DESC LIMIT 7 '
     * );
     *   $result = $query->getResult();
     */
    public function findNotBookingRoomsId($date1,$date2,$type)
    {
        $qb = $this
        ->createQueryBuilder('r')
        ->select('r.id,r.price,r.type')
        ->groupBy('r.id')
        ->leftJoin('r.bookings', 'br')
        ->where('r.type = :val2')
        ->andWhere('r.id = :book  OR :dateS NOT BETWEEN br.dateStart 
        AND br.endDate AND :dateE NOT BETWEEN br.dateStart AND br.endDate')
        ->setParameter('val2', $type)
        ->setParameter('book',  Null)
        ->setParameter('dateS',  $date1)
        ->setParameter('dateE', $date2);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    

    /*
    public function findOneBySomeField($value): ?Room
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
