<?php

namespace App\Repository;

use App\Entity\Panier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Panier>
 */
class PanierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Panier::class);
    }

    public function findBySessionId(string $sessionId): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.sessionId = :sessionId')
            ->setParameter('sessionId', $sessionId)
            ->orderBy('p.dateAjout', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findItemBySessionAndProduct(string $sessionId, int $produitId): ?Panier
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.sessionId = :sessionId')
            ->andWhere('p.produit = :produitId')
            ->setParameter('sessionId', $sessionId)
            ->setParameter('produitId', $produitId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getTotalBySession(string $sessionId): float
    {
        $items = $this->findBySessionId($sessionId);
        $total = 0;
        
        foreach ($items as $item) {
            $total += $item->getSousTotal();
        }
        
        return $total;
    }

    public function getCountBySession(string $sessionId): int
    {
        return $this->createQueryBuilder('p')
            ->select('SUM(p.quantite)')
            ->andWhere('p.sessionId = :sessionId')
            ->setParameter('sessionId', $sessionId)
            ->getQuery()
            ->getSingleScalarResult() ?? 0;
    }
}