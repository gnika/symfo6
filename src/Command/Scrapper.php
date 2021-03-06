<?php
namespace App\Command;
use App\Entity\CategorySite;
use App\Entity\Parse1;
use App\Entity\Parse2;
use App\Entity\Site;
use App\Repository\CategorySiteRepository;
use App\Repository\Parse1Repository;
use App\Repository\Parse2Repository;
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
    //scrapper:leboncoin details    ====> scrapper les pages details voitures
    //scrapper:leboncoin -c2        ====> scrapper les pages liste immobilier
    //scrapper:leboncoin details -c2
    protected static $defaultDescription = 'Scrapper';
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var SiteRepository */
    private $siteRepository;
    /** @var CategorySiteRepository */
    private $categoryRepository;
    public function __construct(EntityManagerInterface $entityManager,
                                SiteRepository $siteRepository,
                                Parse1Repository $parse1Repository,
                                Parse2Repository $parse2Repository,
                                CategorySiteRepository $categoryRepository)
    {
        $this->entityManager = $entityManager;
        $this->siteRepository = $siteRepository;
        $this->categoryRepository = $categoryRepository;
        $this->parse1Repository = $parse1Repository;
        $this->parse2Repository = $parse2Repository;
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addOption('site', 's',
                InputOption::VALUE_REQUIRED, 'site ?? parser', 'leboncoin')
            ->addOption('category', 'c',
                InputOption::VALUE_REQUIRED, 'category ?? parser', 1)
            ->addOption('reset', 'r',
                InputOption::VALUE_REQUIRED, 'Remettre les compteurs ?? 0', 0)
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

            $io->success('remise ?? zero du parsage de la categorie '.$categoryId);

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


            /*
            //get list of proxy :
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $proxies = array();
            $start_count = 1;
            $end_count = 10;

            for( $i = $start_count; $i <= $end_count; $i++){
                curl_setopt($curl, CURLOPT_URL, "https://www.my-proxy.com/free-proxy-list-$i.html");
                $result = curl_exec($curl);

                preg_match_all("!\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3}:\d{2,4}!", $result, $matches);

                $proxies = array_merge($proxies, $matches[0]);

            }

            curl_close($curl);
            print_r($proxies);

            */


                $ch = curl_init();
                $timeout = 5; // set to zero for no timeout
                curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                curl_setopt ($ch, CURLOPT_URL, "https://www.google.com");
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_PROXY, "172.252.1.161"); //your proxy url
                curl_setopt($ch, CURLOPT_PROXYPORT, "3128"); // your proxy port number
                $file_contents = curl_exec($ch);
                curl_close($ch);


            $url = 'http://dynupdate.no-ip.com/ip.php';
            $proxy = '142.252.223.20';


            $url = 'https://google.com';
            $proxyPort = '3128';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
//proxy suport
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
            curl_setopt($ch, CURLOPT_PROXYPORT, $proxyPort);
//curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
            curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
//https
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML,like Gecko) Chrome/27.0.1453.94 Safari/537.36");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 100);

            $output = curl_exec($ch);

            if(curl_exec($ch) === false)
            {
                echo 'Curl error: ' . curl_error($ch);
            }
            else
            {
                echo 'Operation completed without any errors';
            }

            echo $output;

            curl_close($ch);

            die();

            for( $i = 0; $i <= 50; $i++) {

                if ($category->getParseList() == 0)
                    $urlFinal = $urlSite . $categoryFinal;
                else
                    $urlFinal = $urlSite . $categoryFinal . '/p-' . $category->getParseList();

                $ch = curl_init();echo $urlFinal;
                curl_setopt($ch, CURLOPT_URL, 'https://api.proxycrawl.com/?token=b5EzeICBK1os1ZSr_hTDAw&url=' . $urlFinal);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);
                curl_close($ch);

                $response = explode('<div class="styles_classifiedColumn__FvVg5">', $response);
                if( !isset($response[1])) {
                    echo "datadome\n";
                    continue;
                }

                $response = '<div class="styles_classifiedColumn__FvVg5">' . $response[1];
                $response = explode('<div class="styles_sideColumn__MyCwB">', $response);
                $response = $response[0];

                if( $categoryId == 1 ) {

                    $urls = explode('href="/'.$categoryName.'/', $response);
                    //echo '<pre>';print_r($urls);die();
                    foreach ($urls as $url) {
                        $url = explode('"', $url);
                        if (strpos($url[0], '.') !== false) {

                            if( $categoryId == 1) {

                                $parse = new Parse1();
                                $dejaEnBase = $this->parse1Repository->findOneBy(['urlOffre' => $url[0]]);
                            }

                            if ($dejaEnBase == '') {

                                $myfile = fopen("parses/parse".$categoryId."/" . $url[0], "w");
                                fwrite($myfile, $urlSite . "/".$categoryName."/" . $url[0]);
                                fclose($myfile);


                                $parse->setCategorySite($category);
                                $parse->setDetails(0);
                                $parse->setTitre($categoryId);//titre non permanent
                                $parse->setCreatedAt(new \DateTimeImmutable());
                                $parse->setUrlOffre($url[0]);
                                $this->entityManager->persist($parse);
                                $this->entityManager->flush();


                            }

                        }
                    }
                }
                if( $categoryId == 2 ) {

                    $urls = explode('.htm', $response);
                    //echo '<pre>';print_r($urls);die();
                    foreach ($urls as $url) {
                        $url = basename($url);
                        
                        if( is_numeric($url)){
                            $url = $url.'.htm';
                            if ($categoryId == 2) {

                                $parse = new Parse2();
                                $dejaEnBase = $this->parse2Repository->findOneBy(['urlOffre' => $url]);
                            }

                            if ($dejaEnBase == '') {

                                $myfile = fopen("parses/parse" . $categoryId . "/" . $url, "w");
                                fwrite($myfile, $urlSite . "/" . $categoryName . "/" . $url);
                                fclose($myfile);


                                $parse->setCategorySite($category);
                                $parse->setDetails(0);
                                $parse->setTitre($categoryId);//titre non permanent
                                $parse->setCreatedAt(new \DateTimeImmutable());
                                $parse->setUrlOffre($url);
                                $this->entityManager->persist($parse);
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

            if( $categoryId == 1 )
                $annonces = $this->parse1Repository->findBy(['titre' => $categoryId]);
            if( $categoryId == 2 )
                $annonces = $this->parse2Repository->findBy(['titre' => $categoryId]);

            foreach( $annonces as $annonce ) {

// dd($annonce);
                $urlFinal = $urlSite . '/' . $category->getName() . '/' . $annonce->getUrlOffre();
                //A CHECKER MAIS IL SEMBLE QUE LE DATADOME SOIT PRESENT BEAUCOUP PLUS SUR L IMMOBILIER - ON FORCE
                //DONC L'URL AUX VOITURES
                $urlFinal = $urlSite.'/voitures/'.$annonce->getUrlOffre();
                //$urlFinal = "https://www.leboncoin.fr/voitures/2153468090.htm";
				// echo $urlFinal;die();
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.proxycrawl.com/?token=b5EzeICBK1os1ZSr_hTDAw&url=' . $urlFinal);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);
                curl_close($ch);


                 //$myfile = fopen("wouat.html", "w");
                 //fwrite($myfile, $response);
                 //fclose($myfile);

//die();
                if ($categoryId == 2) {

                    $json = explode('<script id="__NEXT_DATA__" type="application/json" crossorigin="anonymous">', $response);
                    if( !isset($json[1])) {

                        $pos = strpos($response, 'img.datadome.co');
                        if ($pos === false) {
                            $this->entityManager->remove($annonce);
                            $this->entityManager->flush();

                            $this->removeFile($categoryId, $annonce->getUrlOffre());
                        }
                        continue;
                    }
                    $json = explode('</script>', $json[1]);

                    $json = json_decode($json[0]);



                    if( !isset( $json->props->pageProps->ad )) {

                        $this->removeFile($categoryId, $annonce->getUrlOffre());
                        $this->entityManager->remove($annonce);
                        $this->entityManager->flush();
                        continue;
                    }
                    $ad = $json->props->pageProps->ad;
                    $publication_date = $ad->first_publication_date;
                    $titre            = $ad->subject;
                    $description      = $ad->body;
                    if( !isset($ad->price[0])){
                        $this->entityManager->remove($annonce);
                        $this->entityManager->flush();

                        $this->removeFile($categoryId, $annonce->getUrlOffre());
                        continue;
                    }

                    $price            = $ad->price[0];
                    $images           = '';
                    if( isset( $ad->images->urls )) {
                        $images = $ad->images->urls;
                        $images = json_encode($images);
                    }

                    $attributes       = $ad->attributes;

                    /*
                    echo '<pre>';
                    print_r($attributes);
                    die();
                    */

                    $possibleAttrs    = [
                        'type_real_estate_sale', 'real_estate_type', 'square', 'land_plot_surface', 'rooms', 'energy_rate',
                        'ges','lease_type','floor_number', 'nb_floors_building', 'nb_parkings', 'charges_included', 'furnished',
                        'custom_ref', 'fai_included', 'bedrooms'
                    ];

                    $attEnBase = [];
                    foreach( $attributes as $attr){
                        $key = array_search($attr->key, $possibleAttrs);
                        if( $key !== false )
                            $attEnBase[$attr->key] = $attr->value_label;
                    }

                    foreach($attEnBase as $key => $att){
                        switch ($key) {
                            case 'bedrooms':
                                $annonce->setChambres($att);
                                break;
                            case 'type_real_estate_sale':
                                $annonce->setTypeDeBien($att);
                                break;
                            case 'real_estate_type':
                                $annonce->setTypeDeVente($att);
                                break;
                            case 'square':
                                $annonce->setSurface($att);
                                break;
                            case 'land_plot_surface':
                                $annonce->setSurfaceDuTerrain($att);
                                break;
                            case 'rooms':
                                $annonce->setPieces($att);
                                break;
                            case 'energy_rate':
                                $annonce->setEnergie($att);
                                break;
                            case 'ges':
                                $annonce->setGes($att);
                                break;
                            case 'lease_type':
                                $annonce->setVente($att);
                                break;
                            case 'floor_number':
                                $annonce->setEtage($att);
                                break;
                            case 'nb_floors_building':
                                $annonce->setEtages($att);
                                break;
                            case 'nb_parkings':
                                    $annonce->setParking($att);
                                break;
                            case 'charges_included':
                                $annonce->setCharges($att);
                                break;
                            case 'furnished':
                                $annonce->setMeuble($att);
                                break;
                            case 'custom_ref':
                                $annonce->setReference($att);
                                break;
                            case 'fai_included':
                                $annonce->setHonoraires($att);
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
                    if( isset($location->city) )
                        $ville            = $location->city;
                    else
                        $ville            = '';
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
                    $annonce->setCreatedAt(new \DateTimeImmutable());
                    $this->entityManager->flush();



                }


                if ($categoryId == 1) {

                    $json = explode('<script id="__NEXT_DATA__" type="application/json" crossorigin="anonymous">', $response);
                    if( !isset($json[1])) {
                        $this->entityManager->remove($annonce);
                        $this->entityManager->flush();

                        $this->removeFile($categoryId, $annonce->getUrlOffre());
                        continue;
                    }
                    $json = explode('</script>', $json[1]);

                    $json = json_decode($json[0]);

                    if( !isset( $json->props->pageProps->ad )) {

                        $this->removeFile($categoryId, $annonce->getUrlOffre());
                        $this->entityManager->remove($annonce);
                        $this->entityManager->flush();
                        continue;
                    }
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
                    $annonce->setCreatedAt(new \DateTimeImmutable());
                    $this->entityManager->flush();



                }
            }

        }

        $io->success('urls pars??es');
        return Command::SUCCESS;
    }

    public function removeFile($categoryId, $annonce){
        $file = 'parses/parse'.$categoryId.'/'.$annonce;
        if( is_file($file)) {
            unlink($file);
        }

        $file = explode('.', $annonce);
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
}