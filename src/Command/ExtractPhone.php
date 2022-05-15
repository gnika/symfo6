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
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use thiagoalessio\TesseractOCR\TesseractOCR;

class ExtractPhone extends Command
{
    protected static $defaultName = 'extract:phone';
    protected static $defaultDescription = 'extract phone from image';
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
            ->addOption('category', 'c',
                InputOption::VALUE_REQUIRED, 'category à parser', 1)
        ;
    }
    protected function execute(InputInterface $input,
                               OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $categoryId = $input->getOption('category');


        $mydir = 'parses/parse'.$categoryId.'pngcrop';

        $myfiles = array_diff(scandir($mydir), array('.', '..'));

        foreach($myfiles as $myfile){
            $num = new TesseractOCR('parses/parse'.$categoryId.'pngcrop/'.$myfile);

            //echo $num->run().' : '.$myfile."\n";
            preg_match_all('!\d+!', $num->run(), $matches);
            $tel = implode(',', $matches[0]);
            $tel = str_replace(',', '', $tel);


            $url      = explode('.', $myfile);
            $nameFile = $url[0];

            if( strlen( $tel ) > 3 ){
                //update
                $ff = str_replace('-b', '', $nameFile);
                $annonce = $this->parse1Repository->findOneBy(['urlOffre' => $ff.'.htm']);
                $annonce->setTelephone($tel);
                $this->entityManager->flush();

                //supprime les fichiers pour eviter d'autres parsages
                $file = 'parses/parse'.$categoryId.'/'.$nameFile.'.htm';

                if( is_file($file)) {
                    unlink($file);
                    $file = 'parses/parse'.$categoryId.'png/'.$nameFile.'.png';
                    if( is_file($file) )
                        unlink($file);

                    $file = 'parses/parse'.$categoryId.'pngcrop/'.$nameFile.'.png';
                    if( is_file($file) )
                        unlink($file);

                    $file = 'parses/parse'.$categoryId.'pngcrop/'.$nameFile.'-b.png';
                    if( is_file($file) )
                        unlink($file);
                }

            }




        }

        $myfiles = array_diff(scandir($mydir), array('.', '..'));
        foreach( $myfiles as $myfile){
            $url      = explode('.', $myfile);
            $nameFile = $url[0];
            //supprime les fichiers pour eviter d'autres parsages
            $file = 'parses/parse'.$categoryId.'/'.$nameFile.'.htm';

            if( is_file($file)) {
                unlink($file);
                $file = 'parses/parse'.$categoryId.'png/'.$nameFile.'.png';
                if( is_file($file) )
                    unlink($file);

                $file = 'parses/parse'.$categoryId.'pngcrop/'.$nameFile.'.png';
                if( is_file($file) )
                    unlink($file);

                $file = 'parses/parse'.$categoryId.'pngcrop/'.$nameFile.'-b.png';
                if( is_file($file) )
                    unlink($file);
            }
        }

        $io->success('téléphones rentrés');
        return Command::SUCCESS;
    }
}