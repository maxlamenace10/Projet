<?php

namespace App\Repository;

use App\Entity\TrainingStatistic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrainingStatistic>
 *
 * @method TrainingStatistic|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingStatistic|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingStatistic[]    findAll()
 * @method TrainingStatistic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingStatisticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingStatistic::class);
    }

//    /**
//     * @return TrainingStatistic[] Returns an array of TrainingStatistic objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TrainingStatistic
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
