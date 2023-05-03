<?php

namespace App\Repository;

use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Room>
 *
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

    public function save(Room $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Room $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
     * Recherche des entités Room par critères.
     *
     * @param array $criteria Les critères de recherche
     *
     * @return Room[] Les entités Room correspondant aux critères
     */
    public function findByCriteria(array $criteria)
    {
        // Création d'un QueryBuilder pour l'entité Room
        $queryBuilder = $this->createQueryBuilder('r');

        // Jointure sur l'entité Material
        $queryBuilder->join('r.material', 'm');

        // Jointure sur l'entité Software
        $queryBuilder->join('r.software', 's');

        // Jointure sur l'entité Ergonomics
        $queryBuilder->join('r.ergonomics', 'e');

        // Ajout d'une condition sur la capacité minimal de la salle
        if (isset($criteria['capacity'])) {
            $queryBuilder->andWhere('r.capacity >= :capacity')
                ->setParameter('capacity', $criteria['capacity']);
        }
        
        // Ajout d'une condition sur l'ID du Material
        foreach($criteria['material'] as $material){
            $queryBuilder->andWhere('m IN (:material)')
                ->setParameter('material', $material);
        }

        // Ajout d'une condition sur l'ID du Software
        foreach($criteria['software'] as $software){
            $queryBuilder->andWhere('s IN (:software)')
                ->setParameter('software', $software);
        }

        // Ajout d'une condition sur l'ID du Ergonomics
        foreach($criteria['ergonomics'] as $ergonomic){
            $queryBuilder->andWhere('e IN (:ergonomics)')
                ->setParameter('ergonomics', $ergonomic);
        }

        // Exécution de la requête et retour des résultats
        return $queryBuilder->getQuery()->getResult();
    }
}