<?php

namespace App\Repository;

use App\Entity\AmadeusAuth;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AmadeusAuth|null find($id, $lockMode = null, $lockVersion = null)
 * @method AmadeusAuth|null findOneBy(array $criteria, array $orderBy = null)
 * @method AmadeusAuth[]    findAll()
 * @method AmadeusAuth[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmadeusAuthRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AmadeusAuth::class);
    }

    /**
     * @param $untilDate
     * @return AmadeusAuth|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findActiveAccessToken($untilDate): ?AmadeusAuth
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.createDate < :createDate')
            ->setParameter('createDate', $untilDate)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;
    }

    /**
     * @param AmadeusAuth $amadeusAuth
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(AmadeusAuth $amadeusAuth)
    {
        $this->getEntityManager()->persist($amadeusAuth);
        $this->getEntityManager()->flush();
    }
}
