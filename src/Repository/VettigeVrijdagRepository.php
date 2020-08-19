<?php

namespace App\Repository;

use App\Entity\VettigeVrijdag;
use App\ValueObject\Status;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VettigeVrijdagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VettigeVrijdag::class);
    }

    public function create(VettigeVrijdag $vettigeVrijdag): void
    {
        $this->getEntityManager()->persist($vettigeVrijdag);
        $this->getEntityManager()->flush();
    }

    public function update(VettigeVrijdag $vettigeVrijdag): void
    {
        $this->getEntityManager()->flush();
    }

    public function getCurrentVettigeVrijdag(): ?VettigeVrijdag
    {
        $queryBuilder = $this->createQueryBuilder('v');

        return $this->createQueryBuilder('v')
            ->where(
                $queryBuilder->expr()->eq(
                    'v.status',
                    ':open',
                ),
            )
            ->setParameter(
                'open',
                Status::OPEN
            )
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getPreviousVettigeVrijdags(): array
    {
        $queryBuilder = $this->createQueryBuilder('v');

        return $this->createQueryBuilder('v')
            ->where(
                $queryBuilder->expr()->eq(
                    'v.status',
                    ':closed',
                ),
            )
            ->setParameter(
                'closed',
                Status::CLOSED,
            )
            ->getQuery()
            ->getResult();
    }
}
