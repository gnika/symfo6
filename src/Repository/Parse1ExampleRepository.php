<?php

namespace App\Repository;

use App\Entity\Parse1Example;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Parse1Example>
 *
 * @method Parse1Example|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parse1Example|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parse1Example[]    findAll()
 * @method Parse1Example[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Parse1ExampleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parse1Example::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Parse1Example $entity, bool $flush = true): void
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
    public function remove(Parse1Example $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findAllwithout1($data): array
    {

        $request     = '';
        $parameters  = [];
        $entityManager = $this->getEntityManager();
        if( $data != null) {
            if ($data['avecNumeroDeTelephone'] != '') {
                $request .= ' and p.telephone <> 1 and p.telephone <> -1 and p.telephone <> 0 and p.telephone is not null';
            }
            if ($data['couleur'] != '') {
                $request .= ' and p.couleur = :couleur';
                $parameters[] = 'couleur';
            }
            if ($data['portes'] != '') {
                $request .= ' and p.portes = :portes';
                $parameters[] = 'portes';
            }
            if ($data['places'] != '') {
                $request .= ' and p.places = :places';
                $parameters[] = 'places';
            }
            if ($data['marque'] != '') {
                $request .= ' and p.marque = :marque';
                $parameters[] = 'marque';
            }
            if ($data['modele'] != '') {
                $request .= ' and p.modele = :modele';
                $parameters[] = 'modele';
            }
            if ($data['AnneeModele'] != '') {
                $request .= ' and p.anneeModele = :AnneeModele';
                $parameters[] = 'AnneeModele';
            }
            if ($data['vehiculeType'] != '') {
                $request .= ' and p.vehiculeType = :vehiculeType';
                $parameters[] = 'vehiculeType';
            }
            if ($data['carburant'] != '') {
                $request .= ' and p.carburant = :carburant';
                $parameters[] = 'carburant';
            }
            if ($data['puissanceDin'] != '') {
                $request .= ' and p.puissanceDIN = :puissanceDin';
                $parameters[] = 'puissanceDin';
            }
            if ($data['avecPermis'] != '') {
                $request .= ' and p.permis = :avecPermis';
                $parameters[] = 'avecPermis';
            }
            if ($data['SoumisALoaLld'] != '') {
                $request .= ' and p.LOALLD = :SoumisALoaLld';
                $parameters[] = 'SoumisALoaLld';
            }
            if ($data['puissanceFiscale'] != '') {
                $request .= ' and p.puissanceFiscale = :puissanceFiscale';
                $parameters[] = 'puissanceFiscale';
            }
            if ($data['piecesDetachees'] != '') {
                $request .= ' and p.piecesDetachees = :piecesDetachees';
                $parameters[] = 'piecesDetachees';
            }
            if ($data['BoiteDeVitesse'] != '') {
                $request .= ' and p.boiteVitesse = :BoiteDeVitesse';
                $parameters[] = 'BoiteDeVitesse';
            }
            if ($data['kilometrageMax'] != '') {
                $request .= ' and p.kilometrage <= :kilometrageMax';
                $parameters[] = 'kilometrageMax';
            }
            if ($data['prixMax'] != '') {
                $request .= ' and p.prix <= :prixMax';
                $parameters[] = 'prixMax';
            }
            if ($data['date_circulation_max'] != '') {
                $request .= ' and p.dateCirculation >= :date_circulation_max';
                $parameters[] = 'date_circulation_max';
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
            FROM App\Entity\Parse1Example p
            WHERE p.titre <> 1'.$request
        );

        foreach ( $parameters as $parameter ) {
            $query->setParameter($parameter, $data[$parameter]);
        }
        // returns an array of Product objects
        return $query->getResult();
    }

    public function findAllwithout1Prix($data): array
    {
        $request     = '';
        $parameters  = [];
        $entityManager = $this->getEntityManager();
        if( $data != null) {
            if ($data['avecNumeroDeTelephone'] != '') {
                $request .= ' and p.telephone <> 1 and p.telephone <> -1 and p.telephone <> 0 and p.telephone is not null';
            }
            if ($data['couleur'] != '') {
                $request .= ' and p.couleur = :couleur';
                $parameters[] = 'couleur';
            }
            if ($data['portes'] != '') {
                $request .= ' and p.portes = :portes';
                $parameters[] = 'portes';
            }
            if ($data['places'] != '') {
                $request .= ' and p.places = :places';
                $parameters[] = 'places';
            }
            if ($data['marque'] != '') {
                $request .= ' and p.marque = :marque';
                $parameters[] = 'marque';
            }
            if ($data['modele'] != '') {
                $request .= ' and p.modele = :modele';
                $parameters[] = 'modele';
            }
            if ($data['AnneeModele'] != '') {
                $request .= ' and p.anneeModele = :AnneeModele';
                $parameters[] = 'AnneeModele';
            }
            if ($data['vehiculeType'] != '') {
                $request .= ' and p.vehiculeType = :vehiculeType';
                $parameters[] = 'vehiculeType';
            }
            if ($data['carburant'] != '') {
                $request .= ' and p.carburant = :carburant';
                $parameters[] = 'carburant';
            }
            if ($data['puissanceDin'] != '') {
                $request .= ' and p.puissanceDIN = :puissanceDin';
                $parameters[] = 'puissanceDin';
            }
            if ($data['avecPermis'] != '') {
                $request .= ' and p.permis = :avecPermis';
                $parameters[] = 'avecPermis';
            }
            if ($data['SoumisALoaLld'] != '') {
                $request .= ' and p.LOALLD = :SoumisALoaLld';
                $parameters[] = 'SoumisALoaLld';
            }
            if ($data['puissanceFiscale'] != '') {
                $request .= ' and p.puissanceFiscale = :puissanceFiscale';
                $parameters[] = 'puissanceFiscale';
            }
            if ($data['piecesDetachees'] != '') {
                $request .= ' and p.piecesDetachees = :piecesDetachees';
                $parameters[] = 'piecesDetachees';
            }
            if ($data['BoiteDeVitesse'] != '') {
                $request .= ' and p.boiteVitesse = :BoiteDeVitesse';
                $parameters[] = 'BoiteDeVitesse';
            }
            if ($data['kilometrageMax'] != '') {
                $request .= ' and p.kilometrage <= :kilometrageMax';
                $parameters[] = 'kilometrageMax';
            }
            if ($data['prixMax'] != '') {
                $request .= ' and p.prix <= :prixMax';
                $parameters[] = 'prixMax';
            }
            if ($data['date_circulation_max'] != '') {
                $request .= ' and p.dateCirculation >= :date_circulation_max';
                $parameters[] = 'date_circulation_max';
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
            FROM App\Entity\Parse1Example p
            WHERE p.titre <> 1'.$request
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
            FROM App\Entity\Parse1Example p
            WHERE p.'.$field.' is not null order by p.'.$field
        );

        // returns an array of Product objects
        $result =  $query->getScalarResult();
        $result = array_column($result, $field);
        $result = array_combine($result,$result);

        return $result;
    }

    // /**
    //  * @return Parse1[] Returns an array of Parse1Example objects
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
    public function findOneBySomeField($value): ?Parse1
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
