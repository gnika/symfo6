<?php

namespace App\Repository;

use App\Entity\Parse2Example;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Parse2Example>
 *
 * @method Parse2Example|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parse2Example|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parse2Example[]    findAll()
 * @method Parse2Example[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Parse2ExampleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parse2Example::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Parse2Example $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Parse2Example $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    public function findAllwithout2($data): array
    {

        $request     = '';
        $parameters  = [];
        $entityManager = $this->getEntityManager();
        if( $data != null) {
            if ($data['avecNumeroDeTelephone'] != '') {
                $request .= ' and p.telephone <> 1 and p.telephone <> -1 and p.telephone <> 0 and p.telephone is not null';
            }
            if ($data['titre'] != '') {
                $request .= ' and p.titre = :titre';
                $parameters[] = 'titre';
            }
            if ($data['typeDeBien'] != '') {
                $request .= ' and p.typeDeBien = :typeDeBien';
                $parameters[] = 'typeDeBien';
            }
            if ($data['typeDeVente'] != '') {
                $request .= ' and p.typeDeVente = :typeDeVente';
                $parameters[] = 'typeDeVente';
            }
            if ($data['pieces'] != '') {
                $request .= ' and p.pieces = :pieces';
                $parameters[] = 'pieces';
            }
            if ($data['energie'] != '') {
                $request .= ' and p.energie = :energie';
                $parameters[] = 'energie';
            }
            if ($data['ges'] != '') {
                $request .= ' and p.ges = :ges';
                $parameters[] = 'ges';
            }
            if ($data['chambres'] != '') {
                $request .= ' and p.chambres = :chambres';
                $parameters[] = 'chambres';
            }
            if ($data['vente'] != '') {
                $request .= ' and p.vente = :vente';
                $parameters[] = 'vente';
            }
            if ($data['etages'] != '') {
                $request .= ' and p.etages = :etages';
                $parameters[] = 'etages';
            }
            if ($data['etage'] != '') {
                $request .= ' and p.etage = :etage';
                $parameters[] = 'etage';
            }
            if ($data['parking'] != '') {
                $request .= ' and p.parking = :parking';
                $parameters[] = 'parking';
            }
            if ($data['charges'] != '') {
                $request .= ' and p.charges = :charges';
                $parameters[] = 'charges';
            }
            if ($data['meuble'] != '') {
                $request .= ' and p.meuble = :meuble';
                $parameters[] = 'meuble';
            }
            if ($data['prixMax'] != '') {
                $request .= ' and p.prix <= :prixMax';
                $parameters[] = 'prixMax';
            }
            if ($data['DateDeRecuperation'] != '') {
                $request .= ' and p.created_at >= :DateDeRecuperation';
                $parameters[] = 'DateDeRecuperation';
            }
            if ($data['region'] != '') {
                $request .= ' and p.region = :region';
                $parameters[] = 'region';
            }
            if ($data['departement'] != '') {
                $request .= ' and p.departement = :departement';
                $parameters[] = 'departement';
            }
            if ($data['ville'] != '') {
                $request .= ' and p.ville = :ville';
                $parameters[] = 'ville';
            }
        }

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Parse2Example p
            WHERE p.titre <> 2'.$request
        );

        foreach ( $parameters as $parameter ) {
            $query->setParameter($parameter, $data[$parameter]);
        }
        // returns an array of Product objects
        return $query->getResult();
    }

    public function findAllwithout2Prix($data): array
    {
        $request     = '';
        $parameters  = [];
        $entityManager = $this->getEntityManager();
        if( $data != null) {
            if ($data['avecNumeroDeTelephone'] != '') {
                $request .= ' and p.telephone <> 1 and p.telephone <> -1 and p.telephone <> 0 and p.telephone is not null';
            }

            if ($data['titre'] != '') {
                $request .= ' and p.titre = :titre';
                $parameters[] = 'titre';
            }
            if ($data['typeDeBien'] != '') {
                $request .= ' and p.typeDeBien = :typeDeBien';
                $parameters[] = 'typeDeBien';
            }
            if ($data['typeDeVente'] != '') {
                $request .= ' and p.typeDeVente = :typeDeVente';
                $parameters[] = 'typeDeVente';
            }
            if ($data['pieces'] != '') {
                $request .= ' and p.pieces = :pieces';
                $parameters[] = 'pieces';
            }
            if ($data['energie'] != '') {
                $request .= ' and p.energie = :energie';
                $parameters[] = 'energie';
            }
            if ($data['ges'] != '') {
                $request .= ' and p.ges = :ges';
                $parameters[] = 'ges';
            }
            if ($data['vente'] != '') {
                $request .= ' and p.vente = :vente';
                $parameters[] = 'vente';
            }
            if ($data['chambres'] != '') {
                $request .= ' and p.chambres = :chambres';
                $parameters[] = 'chambres';
            }
            if ($data['etages'] != '') {
                $request .= ' and p.etages = :etages';
                $parameters[] = 'etages';
            }
            if ($data['etage'] != '') {
                $request .= ' and p.etage = :etage';
                $parameters[] = 'etage';
            }
            if ($data['parking'] != '') {
                $request .= ' and p.parking = :parking';
                $parameters[] = 'parking';
            }
            if ($data['charges'] != '') {
                $request .= ' and p.charges = :charges';
                $parameters[] = 'charges';
            }
            if ($data['meuble'] != '') {
                $request .= ' and p.meuble = :meuble';
                $parameters[] = 'meuble';
            }
            if ($data['prixMax'] != '') {
                $request .= ' and p.prix <= :prixMax';
                $parameters[] = 'prixMax';
            }
            if ($data['DateDeRecuperation'] != '') {
                $request .= ' and p.created_at >= :DateDeRecuperation';
                $parameters[] = 'DateDeRecuperation';
            }
            if ($data['region'] != '') {
                $request .= ' and p.region = :region';
                $parameters[] = 'region';
            }
            if ($data['departement'] != '') {
                $request .= ' and p.departement = :departement';
                $parameters[] = 'departement';
            }
            if ($data['ville'] != '') {
                $request .= ' and p.ville = :ville';
                $parameters[] = 'ville';
            }
        }

        $query = $entityManager->createQuery(
            'SELECT AVG(p.prix)
            FROM App\Entity\Parse2Example p
            WHERE p.titre <> 2'.$request
        );
        foreach ( $parameters as $parameter ) {
            $query->setParameter($parameter, $data[$parameter]);
        }


        // returns an array of Product objects
        return $query->getResult();
    }

    public function findAllField($field): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT distinct p.'.$field.'
            FROM App\Entity\Parse2Example p
            WHERE p.'.$field.' is not null order by p.'.$field
        );

        // returns an array of Product objects
        $result =  $query->getScalarResult();
        $result = array_column($result, $field);
        $result = array_combine($result,$result);

        return $result;
    }

    // /**
    //  * @return Parse2Example[] Returns an array of Parse2Example objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Parse2Example
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
