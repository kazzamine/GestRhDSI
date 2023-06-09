<?php

namespace App\Repository;

use App\Entity\Absence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Absence>
 *
 * @method Absence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Absence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Absence[]    findAll()
 * @method Absence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbsenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Absence::class);
    }

    public function save(Absence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Absence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByDate_absence(\DateTimeInterface $startDate, \DateTimeInterface $endDate):int
    {
        $qb=$this->createQueryBuilder('absences');
        $qb->select('COUNT(absences)')
            ->where($qb->expr()->between('absences.date_absence', ':start_date', ':end_date'))
            ->setParameter('start_date', $startDate)
            ->setParameter('end_date', $endDate);


        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findByEmployeAbse($empID)
    {
        $queryBuilder = $this->createQueryBuilder('absence');

        $queryBuilder->select('count(absence)')
            ->from(Absence::class, 'a')
            ->join('a.employe_abse', 'p')
            ->where('p.id = :empID')
            ->setParameter('empID', $empID);

        $query = $queryBuilder->getQuery();

        return $query->getSingleScalarResult();
    }


    public function updateJustification($empId,$startdate,$enddate,$justification)
    {

        $queryBuilder = $this->createQueryBuilder('a');
        $queryBuilder
            ->update(Absence::class, 'a')
            ->set('a.justification', ':newValue')
            ->where('a.date_absence >= :startDate')
            ->andWhere('a.date_absence <= :endDate')
            ->andWhere('a.employe_abse = :empid')
            ->setParameter('newValue', $justification)
            ->setParameter('startDate', $startdate)
            ->setParameter('endDate', $enddate)
            ->setParameter('empid',$empId);

        $query = $queryBuilder->getQuery();
        $affectedRows = $query->execute();

        return $affectedRows;
    }
//    /**
//     * @return Absence[] Returns an array of Absence objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Absence
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
