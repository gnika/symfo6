<?php

namespace App\Controller;

use App\Entity\CategorySite;
use App\Entity\Parse1;
use App\Entity\Parse1Example;
use App\Entity\Site;
use App\Form\Type\SearchParse1Type;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;
use function Symfony\Component\Translation\t;

/**
* @Route("/example")
*/
class ExampleController extends AbstractController
{

    private $em;

    public function __construct(ManagerRegistry $registry)
    {
        $this->em = $registry;
    }

  /**
	* @Route("/listexample",
	name="listingSiteexample",
	methods={"GET"})
	*/
	public function sites( Request $request): Response
	{

        $site   = $this->em->getRepository(Site::class);
        return $this->render('siteexample/sites.html.twig', [
            'sites' => $site->findAll(),
        ]);
	
	}

  /**
	* @Route("/detailsexample/{id}",
	name="request_siteexample",
	methods={"GET"}),
  requirements={"id"="\d+"})
	*/
	public function site( Request $request): Response
	{

        $user = $this->getUser();
        $id_request = $request->get('id');
        $site   = $this->em->getRepository(Site::class);
        $siteC   = $site->find($id_request);





        return $this->render('siteexample/site.html.twig', [
            'categs' => $siteC->getCategories(),
            'site' => $siteC->getName(),
        ]);

	}

  /**
	* @Route("/categexample/{id}",
	name="request_categexample",
	methods={"GET", "POST"}),
  requirements={"id"="\d+"})
	*/
	public function categ( Request $request, CategorySite $categorySite, PaginatorInterface $paginator): Response
	{

        $type = 'Parse'.$categorySite->getId().'Example';

        if( $categorySite->getId() == 1 ) {

            $parse1 = $this->em->getRepository(Parse1Example::class);

            $data = $request->get('search_parse1');



            $donnees                 = $parse1->findAllwithout1($data);
            $donneesPrix             = $parse1->findAllwithout1Prix($data);
            $modeles                 = $parse1->findAllField('modele');
            $anneeModele             = $parse1->findAllField('anneeModele');
            $marque                  = $parse1->findAllField('marque');
            $carburant               = $parse1->findAllField('carburant');
            $vehiculeType            = $parse1->findAllField('vehiculeType');
            $couleur                 = $parse1->findAllField('couleur');
            $places                  = $parse1->findAllField('places');
            $portes                  = $parse1->findAllField('portes');
            $puissanceFiscale        = $parse1->findAllField('puissanceFiscale');
            $puissanceDin            = $parse1->findAllField('puissanceDIN');
            $piecesDetachees         = $parse1->findAllField('piecesDetachees');
            $region                  = $parse1->findAllField('region');
            $departement             = $parse1->findAllField('departement');


            $form = $this->createForm(SearchParse1Type::class, null,
                [
                    'marque'              => $marque,
                    'modeles'             => $modeles,
                    'anneeModele'         => $anneeModele,
                    'carburant'           => $carburant,
                    'vehiculeType'        => $vehiculeType,
                    'couleur'             => $couleur,
                    'places'              => $places,
                    'portes'              => $portes,
                    'puissanceFiscale'    => $puissanceFiscale,
                    'puissanceDin'        => $puissanceDin,
                    'piecesDetachees'     => $piecesDetachees,
                    'region'              => $region,
                    'departement'         => $departement,

                ]);

            if( isset($data['date_circulation_max']) && $data['date_circulation_max'] == '' )
                unset($data['date_circulation_max']);
            if( isset($data['date_circulation_max']) && $data['date_circulation_max'] != '' )
                $data['date_circulation_max'] = new \DateTime($data['date_circulation_max']);
            $form->setData($data);

            //GENERATION CSV
            if( isset( $data['ExporterLaRecherche'] ) ) {
                $content = 'ID;TITRE;VILLE;MARQUE;MODELE;ANNEE MODELE;DATE CIRCULATION;KILOMETRAGE;CARBURANT;BOITE DE VITESSE;TYPE DE VEHICULE;COULEUR;PORTES;PLACE;PUISSANCE FISCALE;PUISSANCE DIN;PERMIS;LOA LLD;PIECES DETACHES;DESCRIPTION;TELEPHONE;URL LEBONCOIN;DATE DE RECUPERATION DE L\'ANNONCE;REGION;DEPARTEMENT;DATE DE PUBLICATION DE L\'ANNONCE;PRIX;IMAGES';
                $content.= "\n";
                foreach ($donnees as $donnee) {
                    if( $donnee->getDateCirculation() != NULL)
                        $dateCircu = $donnee->getDateCirculation()->format('Y-m-d H:i:s');
                    else
                        $dateCircu = '';
                    if( $donnee->getDatePublication() != NULL)
                        $datePublication = $donnee->getDatePublication()->format('Y-m-d H:i:s');
                    else
                        $datePublication = '';
                    if( $donnee->getCreatedAt() != NULL)
                        $createdAt = $donnee->getCreatedAt()->format('Y-m-d H:i:s');
                    else
                        $createdAt = '';
                    $description = str_replace(';', '-', $donnee->getDescription());
                    $description = str_replace("\n", ' /// ', $description);
                    $content.=$donnee->getId().';'.$donnee->getTitre().';'.$donnee->getVille().';'.$donnee->getMarque().';'.
                        $donnee->getModele().';'.$donnee->getAnneeModele().';'.$dateCircu.';'.$donnee->getKilometrage().';'.
                        $donnee->getCarburant().';'.$donnee->getBoiteVitesse().';'.$donnee->getVehiculeType().';'.$donnee->getCouleur().';'.
                        $donnee->getPortes().';'.$donnee->getPlaces().';'.$donnee->getPuissanceFiscale().';'.$donnee->getPuissanceDIN().';'.
                        $donnee->getPermis().';'.$donnee->getLOALLD().';'.$donnee->getPiecesDetachees().';'.$description.';'.
                        $donnee->getTelephone().';'.$donnee->getUrlOffre().';'.$createdAt.';'.$donnee->getRegion().';'.
                        $donnee->getDepartement().';'.$datePublication.';'.$donnee->getPrix().';'.$donnee->getImages().';'."\n";

                }

                $response = new Response($content);
                $response->headers->set('Content-Type', 'text/csv');

                return $response;
            }
        }

        $pagination = $paginator->paginate(
            $donnees, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('siteExample/parse1.html.twig', [
            'donnees' => $donnees,
            'donneesPrix' => $donneesPrix[0][1],
            'categorie' => $categorySite,
            'pagination' => $pagination,
            'form'      => $form->createView()

        ]);

	}


}
