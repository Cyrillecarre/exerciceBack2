<?php

namespace App\Repository;

use App\Entity\DemandeCandidature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemandeCandidature>
 *
 * @method DemandeCandidature|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeCandidature|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeCandidature[]    findAll()
 * @method DemandeCandidature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeCandidatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeCandidature::class);
    }

//    /**
//     * @return DemandeCandidature[] Returns an array of DemandeCandidature objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DemandeCandidature
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
