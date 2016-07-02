<?php

namespace oeuvresBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TypesmusiquesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TypesmusiquesRepository extends EntityRepository
{
	
	public function ChargeListe()
	{
		
		
		$query = $this->getEntityManager()
		->createQuery(
				'SELECT
				t.id,
				t.active,
				t.libelle,
				t.datecreateAt
				FROM oeuvresBundle:Typesmusiques t
				WHERE t.active=1'
		);
		
		// $query->andWhere('o.actif = ?', array(1));
		
		try {
			//return $query->getSingleResult();
				
			return $query->getResult();
		} catch (\Doctrine\ORM\NoResultException $e) {
			return null;
		}
		
		
	}
}
