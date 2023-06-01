<?php

namespace App\Repository;

use App\Entity\CongeExceptionnel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CongeExceptionnel>
 *
 * @method CongeExceptionnel|null find($id, $lockMode = null, $lockVersion = null)
 * @method CongeExceptionnel|null findOneBy(array $criteria, array $orderBy = null)
 * @method CongeExceptionnel[]    findAll()
 * @method CongeExceptionnel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CongeExceptionnelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CongeExceptionnel::class);
    }

    public function save(CongeExceptionnel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CongeExceptionnel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CongeExceptionnel[] Returns an array of CongeExceptionnel objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CongeExceptionnel
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
