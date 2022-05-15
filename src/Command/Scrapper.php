<?php
namespace App\Command;
use App\Entity\CategorySite;
use App\Entity\Parse1;
use App\Entity\Site;
use App\Repository\CategoryRepository;
use App\Repository\CategorySiteRepository;
use App\Repository\Parse1Repository;
use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use simplehtmldom_1_5\simple_html_dom;
use Sunra\PhpSimple\HtmlDomParser;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class Scrapper extends Command
{
    protected static $defaultName = 'scrapper:leboncoin';
    //scrapper:leboncoin            ====> scrapper les pages liste
    //scrapper:leboncoin -r 1       ====> faire un reset
    //scrapper:leboncoin details    ====> scrapper les pages details
    protected static $defaultDescription = 'Scrapper';
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var SiteRepository */
    private $siteRepository;
    /** @var CategoryRepository */
    private $categoryRepository;
    public function __construct(EntityManagerInterface $entityManager,
                                SiteRepository $siteRepository,
                                Parse1Repository $parse1Repository,
                                CategorySiteRepository $categoryRepository)
    {
        $this->entityManager = $entityManager;
        $this->siteRepository = $siteRepository;
        $this->categoryRepository = $categoryRepository;
        $this->parse1Repository = $parse1Repository;
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addOption('site', 's',
                InputOption::VALUE_REQUIRED, 'site à parser', 'leboncoin')
            ->addOption('category', 'c',
                InputOption::VALUE_REQUIRED, 'category à parser', 1)
            ->addOption('reset', 'r',
                InputOption::VALUE_REQUIRED, 'Remettre les compteurs à 0', 0)
            ->addArgument('modele_parse', InputArgument::OPTIONAL,
                'liste/details', 'liste')


        ;
    }
    protected function execute(InputInterface $input,
                               OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $modele_parse = $input->getArgument('modele_parse');
        $siteName = $input->getOption('site');
        $categoryId = $input->getOption('category');
        $reset = $input->getOption('reset');

        if( $reset == 1 ){
            $files = glob('parses/parse'.$categoryId.'/*');

            // Deleting all the files in the list
            foreach($files as $file) {

                if(is_file($file))

                    // Delete the given file
                    unlink($file);
            }

            $io->success('remise à zero du parsage de la categorie '.$categoryId);

            $category = $this->categoryRepository->find($categoryId);
            $category->setParseList(1);
            $this->entityManager->flush();

            return Command::SUCCESS;
            die();
        }


        $site = $this->siteRepository->findOneBy(['name' => $siteName]);
        $category = $this->categoryRepository->find($categoryId);

        $urlSite = $site->getUrl();
        $categoryFinal = $category->getUrlCategorie();
        $categoryName = $category->getName();

        if( $modele_parse == 'liste' ) {


            for( $i = 0; $i <= 50; $i++) {

                if ($category->getParseList() == 0)
                    $urlFinal = $urlSite . $categoryFinal;
                else
                    $urlFinal = $urlSite . $categoryFinal . '/p-' . $category->getParseList();

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.proxycrawl.com/?token=b5EzeICBK1os1ZSr_hTDAw&url=' . $urlFinal);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);
                curl_close($ch);


                $response = explode('<div class="styles_classifiedColumn__FvVg5">', $response);
                if( !isset($response[1]))
                    continue;

                $response = '<div class="styles_classifiedColumn__FvVg5">' . $response[1];
                $response = explode('<div class="styles_sideColumn__MyCwB">', $response);
                $response = $response[0];

                $urls = explode('href="/'.$categoryName.'/', $response);
                foreach ($urls as $url) {
                    $url = explode('"', $url);
                    if (strpos($url[0], '.') !== false) {

                        $dejaEnBase = $this->parse1Repository->findOneBy(['urlOffre' => $url[0]]);

                        if ($dejaEnBase == '') {

                            $myfile = fopen("parses/parse".$categoryId."/" . $url[0], "w");
                            fwrite($myfile, $urlSite . "/".$categoryName."/" . $url[0]);
                            fclose($myfile);

                            if( $categoryId == 1 ) {

                                $parse1 = new Parse1();
                                $parse1->setCategorySite($category);
                                $parse1->setDetails(0);
                                $parse1->setTitre($categoryId);//titre non permanent
                                $parse1->setCreatedAt(new \DateTimeImmutable());
                                $parse1->setUrlOffre($url[0]);
                                $this->entityManager->persist($parse1);
                                $this->entityManager->flush();

                            }
                        }

                    }
                }

                $category->setParseList($category->getParseList() + 1);
                $this->entityManager->flush();

            }
        }else{
            //DETAILS


            $annonces = $this->parse1Repository->findBy(['titre' => $categoryId]);
            foreach( $annonces as $annonce ) {


                $urlFinal = $urlSite . '/' . $category->getName() . '/' . $annonce->getUrlOffre();
                //$urlFinal = 'https://www.leboncoin.fr/voitures/2120660619.htm';

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.proxycrawl.com/?token=b5EzeICBK1os1ZSr_hTDAw&url=' . $urlFinal);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);
                curl_close($ch);


                 //$myfile = fopen("wouat.html", "w");
                 //fwrite($myfile, $response);
                 //fclose($myfile);


                if ($categoryId == 1) {

                    $json = explode('<script id="__NEXT_DATA__" type="application/json" crossorigin="anonymous">', $response);
                    if( !isset($json[1]))
                        continue;
                    $json = explode('</script>', $json[1]);

                    $json = json_decode($json[0]);

                    if( !isset( $json->props->pageProps->ad ))
                        continue;
                    $ad = $json->props->pageProps->ad;
                    $publication_date = $ad->first_publication_date;
                    $titre            = $ad->subject;
                    $description      = $ad->body;
                    $price            = $ad->price[0];
                    $images           = '';
                    if( isset( $ad->images->urls )) {
                        $images = $ad->images->urls;
                        $images = json_encode($images);
                    }

                    $attributes       = $ad->attributes;

//print_r($attributes);die();
                    $possibleAttrs    = [
                        'brand', 'model', 'regdate', 'issuance_date', 'mileage', 'fuel', 'gearbox', 'vehicle_vsp', 'vehicle_type',
                        'vehicule_color', 'doors', 'seats', 'horsepower', 'horse_power_din', 'vehicle_svp',
                        'car_contract', 'recent_used_vehicle', 'is_import', 'car_rotation_delay', 'spare_parts_availability'
                    ];

                    $attEnBase = [];
                    foreach( $attributes as $attr){
                        $key = array_search($attr->key, $possibleAttrs);
                        if( $key !== false )
                            $attEnBase[$attr->key] = $attr->value_label;
                    }

                    foreach($attEnBase as $key => $att){
                        switch ($key) {
                            case 'brand':
                                $annonce->setMarque($att);
                                break;
                            case 'model':
                                $annonce->setModele($att);
                                break;
                            case 'regdate':
                                $annonce->setAnneeModele($att);
                                break;
                            case 'mileage':
                                $att = str_replace(' km', '', $att);
                                $annonce->setKilometrage($att);
                                break;
                            case 'fuel':
                                $annonce->setCarburant($att);
                                break;
                            case 'gearbox':
                                $annonce->setBoiteVitesse($att);
                                break;
                            case 'vehicle_vsp':

                                if ($att == 'Avec permis')
                                    $att = 1;
                                else
                                    $att = 0;

                                $annonce->setPermis($att);
                                break;
                            case 'vehicle_type':
                                $annonce->setVehiculeType($att);
                                break;
                            case 'vehicule_color':
                                $annonce->setCouleur($att);
                                break;
                            case 'doors':
                                $annonce->setPortes($att);
                                break;
                            case 'seats':
                                if( !is_numeric($att) )
                                    $att = $att[0];

                                if( is_numeric($att))
                                    $annonce->setPlaces($att);
                                break;
                            case 'horsepower':
                                $annonce->setPuissanceFiscale($att);
                                break;
                            case 'horse_power_din':
                                $annonce->setPuissanceDIN($att);
                                break;
                            case 'car_contract':

                                if ($att == 'Non')
                                    $att = 0;
                                else
                                    $att = 1;
                                $annonce->setLOALLD($att);
                                break;
                            case 'spare_parts_availability':
                                $annonce->setPiecesDetachees($att);
                                break;
                            case 'issuance_date':

                                $att = explode('/', $att);
                                $att = $att[1].'-'.$att[0];

                                $annonce->setDateCirculation(new \DateTime($att));
                                break;
                        }
                    }


                    $annonce->setDatePublication(new \DateTime($publication_date));
                    $annonce->setDescription($description);

                    $location         = $ad->location;
                    $region           = $location->region_name;
                    $departement      = '';
                    if( isset( $location->department_name ) )
                        $departement      = $location->department_name;
                    $ville            = $location->city;
                    $telephone        = $ad->has_phone;

                    if ( $telephone != 1 ) {
                        $telephone = -1;
                        $urlOffre = $annonce->getUrlOffre();//2156947292.htm

                        $file = 'parses/parse'.$categoryId.'/'.$urlOffre;

                        if( is_file($file)) {
                            unlink($file);
                            $file = explode('.', $annonce->getUrlOffre());
                            $file = $file[0];
                            $file = 'parses/parse'.$categoryId.'png/'.$file.'.png';
                            if( is_file($file) )
                                unlink($file);

                            $file = 'parses/parse'.$categoryId.'pngcrop/'.$file.'.png';
                            if( is_file($file) )
                                unlink($file);

                            $file = 'parses/parse'.$categoryId.'pngcrop/'.$file.'-b.png';
                            if( is_file($file) )
                                unlink($file);
                        }
                    }else
                        $telephone = 1;

                    $annonce->setDetails(1);
                    $annonce->setTitre($titre);
                    $annonce->setRegion($region);
                    $annonce->setDepartement($departement);
                    $annonce->setVille($ville);
                    $annonce->setPrix($price);
                    $annonce->setImages($images);
                    $annonce->setTelephone($telephone);
                    $this->entityManager->flush();



                }
            }

        }

        $io->success('urls parsées');
        return Command::SUCCESS;
    }
}