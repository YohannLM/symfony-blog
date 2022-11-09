<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Property>
 *
 * @method Property|null find( $id, $lockMode = NULL, $lockVersion = NULL )
 * @method Property|null findOneBy( array $criteria, array $orderBy = NULL )
 * @method Property[]    findAll()
 * @method Property[]    findBy( array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL )
 */
class PropertyRepository extends ServiceEntityRepository {
	
	public function __construct( ManagerRegistry $registry ) {
		parent::__construct( $registry, Property::class );
	}
	
	public function save( Property $entity, bool $flush = FALSE ): void {
		$this->getEntityManager()->persist( $entity );
		
		if ( $flush ) {
			$this->getEntityManager()->flush();
		}
	}
	
	public function remove( Property $entity, bool $flush = FALSE ): void {
		$this->getEntityManager()->remove( $entity );
		
		if ( $flush ) {
			$this->getEntityManager()->flush();
		}
	}

	
	/**
	 * @return Query[]
	 */
	public function findAllVisibleQuery(PropertySearch $search): Query {
		$query = $this->findVisibleQuery();
		
		if ($search->getMaxPrice()) {
			$query->andWhere('p.price <= :maxprice' )
				->setParameter('maxprice', $search->getMaxPrice());
		}
		if ($search->getMinSurface()) {
			$query->andWhere('p.surface >= :minsurface' )
			      ->setParameter('minsurface', $search->getMinSurface());
		}
		return $query->getQuery();
	}
	
	/**
	 * @return Property[]
	 */
	public function findLatest(): array {
		return $this->findVisibleQuery()
		            ->setMaxResults( 4 )
		            ->getQuery()
		            ->getResult();
	}
	
	
	private function findVisibleQuery(): QueryBuilder {
		return $this->createQueryBuilder( 'p' )
		            ->where( 'p.sold = false' );
	}
}
