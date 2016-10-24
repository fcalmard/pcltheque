<?php

namespace oeuvresBundle\Repository;

use Doctrine\ORM\EntityRepository;
use oeuvresBundle\Entity\Compositeurs;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * CompositeursRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CompositeursRepository extends EntityRepository
{

	public function ChargeListe()
	{
		
			$query = $this->getEntityManager()
			->createQuery(
					'SELECT
					t.id,
					t.active,
					t.prenom,
					t.nom,
					t.nationalite,
					t.datenaiss,
					t.datedeces,
					t.datecreateAt
					FROM oeuvresBundle:Compositeurs t
					WHERE t.active=1 order by t.nom,t.prenom'
			);
			
			try {
				return $query->getResult();
			} catch (\Doctrine\ORM\NoResultException $e) {
				return null;
			}
		
	}
	
	public function ChargeListeIds($sNom)
	{
		
		$sListeIds="";
		
		$s=sprintf("%s",$sNom);
		
		$sql="SELECT
				t.id from oeuvresBundle:Compositeurs t
				WHERE t.active=1 and t.nom like '%".$s."%'";
		
		$sql.=" or t.prenom like '%".$s."%'";
		//echo "<br/>ChargeListeIds >".$sql."<";
		
		$query = $this->getEntityManager()
		->createQuery(
				$sql
		);
			
		try {
			$aIds=$query->getResult();
			if(is_array($aIds) && count($aIds)>0)
			{
				foreach ($aIds as $kid=>$id)
				{
					$sListeIds.=($sListeIds!="") ? "," : "";
										
					$sListeIds.=$id['id'];
				}
			}
		} catch (\Doctrine\ORM\NoResultException $e) {
			$sListeIds="";
		}
		return $sListeIds;
		
	}
	
	/**
	 * 
	 * @param string $sNom
	 * @param string $sPrenom
	 * @return number
	 */
	public function rechercheCompositeur($sNom,$sPrenom)
	{
		$idcompo=0;
		$sListeIds="";
		$s=sprintf("%s",$sNom);
		$sPrenom=sprintf("%s",$sPrenom);
		
		$sql="SELECT
				t.id from oeuvresBundle:Compositeurs t
				WHERE t.nom = '".$s."'";
		
		$sql="SELECT
				t.id from oeuvresBundle:Compositeurs t
				WHERE t.nom = '".$s."' and t.prenom= '".$sPrenom."'";
		
		$query = $this->getEntityManager()
		->createQuery(
				$sql
				);
			
		try {
			$aIds=$query->getResult();
			
				//var_dump($aIds);
			
			if(is_array($aIds) && count($aIds)>0)
			{
				foreach ($aIds as $kid=>$id)
				{
					$idcompo=$id['id'];
					$sListeIds.=$idcompo;
				}
			}
		} catch (\Doctrine\ORM\NoResultException $e) {
			$idcompo=0;
		}
		
		
		return $idcompo;
	}
	
	/**
	 * 
	 */
	public function insertionCompositeur($sNom,$sPrenom)
	{

		$idcree=0;
		
		$conn=$this->getEntityManager()->getConnection();
		
		$dataArray=array('nom'=>$sNom,'prenom'=>$sPrenom,'active'=>1);
		
		try {
			$bOk=$conn->insert('Compositeurs', $dataArray);
				
		} catch (\Doctrine\ORM\NoResultException $e) {
			die("Erreur ".$e->getMessage());
		}
				
		$idcree=$conn->lastInsertId();
				
		return $idcree;
		
	}
}
