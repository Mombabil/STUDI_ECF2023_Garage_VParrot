<?php

namespace App\Repository;

use App\Entity\Cars;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cars>
 *
 * @method Cars|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cars|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cars[]    findAll()
 * @method Cars[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cars::class);
    }

    public function save(Cars $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cars $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Returns all Annonces per page
     * @return void 
     */
    public function getCars($mileageFilter = null, $priceFilter = null, $yearFilter = null)
    {
        $query = $this->createQueryBuilder('cars')
            ->addOrderBy('cars.id', Criteria::DESC)
            ->where('cars.isValidated = 1');

        // On filtre les données
        if ($mileageFilter !== null || $priceFilter !== null || $yearFilter !== null) {
            $query
                ->andWhere('cars.mileage <= :mileage')
                ->andWhere('cars.price <= :price')
                ->andWhere('cars.year <= :year')
                ->setParameters([
                    'mileage' => $mileageFilter,
                    'price' => $priceFilter,
                    'year' => $yearFilter
                ]);
        }
        return $query->getQuery()->getResult();
    }
}
