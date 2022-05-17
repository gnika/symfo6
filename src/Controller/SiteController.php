<?php

namespace App\Controller;

use App\Entity\CategorySite;
use App\Entity\Parse1;
use App\Entity\Parse2;
use App\Entity\Site;
use App\Form\Type\SearchParse1Type;
use App\Form\Type\SearchParse2Type;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;
use function Symfony\Component\Translation\t;

/**
 * @Route("/site")
 */
class SiteController extends AbstractController
{

    private $em;

    public function __construct(ManagerRegistry $registry)
    {
        $this->em = $registry;
    }

    /**
     * @Route("/list",
    name="listingSite",
    methods={"GET"})
     */
    public function sites( Request $request): Response
    {
        $user = $this->getUser();
        return $this->render('site/sites.html.twig', [
            'sites' => $user->getSites(),
        ]);

    }
    public function homepage( Request $request): Response
    {
        $site    = $this->em->getRepository(Site::class);
        $donnees =$site->getDonneesDuMois();

        return $this->render('default/homepage.html.twig', [
            'donnees' => $donnees,
        ]);

    }

    /**
     * @Route("/details/{id}",
    name="request_site",
    methods={"GET"}),
    requirements={"id"="\d+"})
     */
    public function site( Request $request): Response
    {

        $user = $this->getUser();
        $id_request = $request->get('id');
        $site   = $this->em->getRepository(Site::class);
        $siteC   = $site->find($id_request);

        $this->denyAccessUnlessGranted('view', $siteC);




        return $this->render('site/site.html.twig', [
            'categs' => $siteC->getCategories(),
            'site' => $siteC->getName(),
        ]);

    }

    /**
     * @Route("/categ/{id}",
    name="request_categ",
    methods={"GET", "POST"}),
    requirements={"id"="\d+"})
     */
    public function categ( Request $request, CategorySite $categorySite, PaginatorInterface $paginator): Response
    {

        $this->denyAccessUnlessGranted('view', $categorySite->getSite());

        $type = 'Parse'.$categorySite->getId();

        if( $categorySite->getId() == 1 ) {


            $page = 'parse1';
            $parse1 = $this->em->getRepository(Parse1::class);

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

            if( isset($data['DateDeRecuperation']) && $data['DateDeRecuperation'] == '' )
                unset($data['DateDeRecuperation']);
            if( isset($data['DateDeRecuperation']) && $data['DateDeRecuperation'] != '' )
                $data['DateDeRecuperation'] = new \DateTime($data['DateDeRecuperation']);
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

        if( $categorySite->getId() == 2 ) {

            $parse2 = $this->em->getRepository(Parse2::class);

            $data = $request->get('search_parse2');



            $donnees                 = $parse2->findAllwithout2($data);
            $donneesPrix             = $parse2->findAllwithout2Prix($data);
            $typeDeBien              = $parse2->findAllField('typeDeBien');
            $typeDeVente             = $parse2->findAllField('typeDeVente');
            $pieces                  = $parse2->findAllField('pieces');
            $chambres                = $parse2->findAllField('chambres');
            $energie                 = $parse2->findAllField('energie');
            $ges                     = $parse2->findAllField('ges');
            $vente                   = $parse2->findAllField('vente');
            $etages                  = $parse2->findAllField('etages');
            $etage                   = $parse2->findAllField('etage');
            $parking                 = $parse2->findAllField('parking');
            $charges                 = $parse2->findAllField('charges');
            $meuble                  = $parse2->findAllField('meuble');
            $region                  = $parse2->findAllField('region');
            $departement             = $parse2->findAllField('departement');


            $form = $this->createForm(SearchParse2Type::class, null,
                [
                    'typeDeBien'      => $typeDeBien,
                    'typeDeVente'      => $typeDeVente,
                    'pieces'          => $pieces,
                    'energie'         => $energie,
                    'ges'             => $ges,
                    'vente'           => $vente,
                    'etages'          => $etages,
                    'etage'           => $etage,
                    'parking'         => $parking,
                    'charges'         => $charges,
                    'meuble'          => $meuble,
                    'region'          => $region,
                    'departement'     => $departement,
                    'chambres'        => $chambres,

                ]);

            if( isset($data['DateDeRecuperation']) && $data['DateDeRecuperation'] == '' )
                unset($data['DateDeRecuperation']);
            if( isset($data['DateDeRecuperation']) && $data['DateDeRecuperation'] != '' )
                $data['DateDeRecuperation'] = new \DateTime($data['DateDeRecuperation']);
            $form->setData($data);

            //GENERATION CSV
            if( isset( $data['ExporterLaRecherche'] ) ) {
                $content = 'ID;TITRE;VILLE;TYPE DE BIEN;TYPE DE VENTE;PIECES;ENERGIE;GES;VENTE;ETAGES DE L\'IMMEUBLE;ETAGE DE L\'APPARTEMENT;PARKING;CHARGES;MEUBLES;REFERENCE;SURFACE;SURFACE DU TERRAIN;DESCRIPTION;TELEPHONE;URL LEBONCOIN;DATE DE RECUPERATION DE L\'ANNONCE;REGION;DEPARTEMENT;DATE DE PUBLICATION DE L\'ANNONCE;PRIX;IMAGES';
                $content.= "\n";
                foreach ($donnees as $donnee) {

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
                    $content.=$donnee->getId().';'.$donnee->getTitre().';'.$donnee->getVille().';'.$donnee->getTypeDeBien().';'.$donnee->getTypeDeVente().';'.
                        $donnee->getPieces().';'.$donnee->getEnergie().';'.$donnees->getGes().';'.$donnee->getVente().';'.
                        $donnee->getEtages().';'.$donnee->getEtage().';'.$donnee->getParking().';'.$donnee->getCharges().';'.
                        $donnee->getMeuble().';'.$donnee->getReference().';'.$donnee->getSurface().';'.$donnee->getSurfaceDuTerrain().';'.$description.';'.
                        $donnee->getTelephone().';'.$donnee->getUrlOffre().';'.$createdAt.';'.$donnee->getRegion().';'.
                        $donnee->getDepartement().';'.$datePublication.';'.$donnee->getPrix().';'.$donnee->getImages().';'."\n";

                }

                $response = new Response($content);
                $response->headers->set('Content-Type', 'text/csv');

                return $response;
            }

            $page = 'parse2';
        }

        $pagination = $paginator->paginate(
            $donnees, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('site/'.$page.'.html.twig', [
            'donnees' => $donnees,
            'donneesPrix' => $donneesPrix[0][1],
            'categorie' => $categorySite,
            'pagination' => $pagination,
            'form'      => $form->createView()

        ]);

    }


}
