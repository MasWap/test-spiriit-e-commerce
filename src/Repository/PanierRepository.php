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

    # Récupérer les articles du panier par ID de session
    public function findBySessionId(string $sessionId): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.sessionId = :sessionId')
            ->setParameter('sessionId', $sessionId)
            ->orderBy('p.dateAjout', 'DESC')
            ->getQuery()
            ->getResult();
    }

    # Récupérer un article du panier par ID de session et ID de produit
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

    # Récupérer le total du panier par ID de session
    public function getTotalBySession(string $sessionId): float
    {
        $items = $this->findBySessionId($sessionId);
        $total = 0;
        
        foreach ($items as $item) {
            $total += $item->getSousTotal();
        }
        
        return $total;
    }

    # Récupérer le nombre d'articles dans le panier par ID de session
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