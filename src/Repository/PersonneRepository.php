<?php

namespace App\Repository;

use App\Entity\Personne ;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Personne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personne[]    findAll()
 * @method Personne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personne::class);
    }

    public function findPersonByAgeInterval($ageMin,$ageMax)
    {
        $qd=$this->createQueryBuilder('p');  
                $this->addIntervalAge($qd,$ageMin,$ageMax);
                return $qd->getQuery()
                ->getResult();  
     }

     public function statPersonByAgeInterval($ageMin,$ageMax){
            $qd=$this->createQueryBuilder('p');
            $qd->select("avg(p.age) as ageMoyen,count(p.id) as nbrePersonne");
            $this->addIntervalAge($qd,$ageMin,$ageMax);

            return $qd->getQuery()->getScalarResult();
                    

     }

   private function addIntervalAge(QueryBuilder $qd,$ageMin,$ageMax){
           
            $qd->andWhere("p.age > :ageMin and p.age < :ageMax");
            $qd->setParameter('ageMin', $ageMin);
            $qd->setParameter('ageMax', $ageMax);
   }
   

    
    // public function findOneBySomeField($value): ?Personne
    // {
    //     return $this->createQueryBuilder('p')
    //         ->andWhere('p.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
  
}
