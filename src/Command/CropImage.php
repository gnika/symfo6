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
class CropImage extends Command
{
    protected static $defaultName = 'crop:image';
    protected static $defaultDescription = 'cropper les images pour récupérer les numéros de téléphone';
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

            ->addOption('path', 'p',
                InputOption::VALUE_REQUIRED, 'chemin du dossier des images', 'parse1png')



        ;
    }
    protected function execute(InputInterface $input,
                               OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $path = $input->getOption('path');


        $mydir = 'parses/'.$path;


        //$im = imagecreatefrompng($mydir."/2121226359.png");
        //$rgb = imagecolorat($im, 1198, 546);//546 à 591 = 45 de hauteur et $r = 214
        //$r = ($rgb >> 16) & 0xFF;



        $myfiles = array_diff(scandir($mydir), array('.', '..'));

        foreach($myfiles as $myfile){
            $im = imagecreatefrompng($mydir.'/'.$myfile);

            //DEUX CAS POSSIBLES
            $im2 = imagecrop($im, ['x' => 1250, 'y' => 546, 'width' => 280, 'height' => 55]);
            $im2b = imagecrop($im, ['x' => 1198, 'y' => 590, 'width' => 280, 'height' => 55]);

            if ($im2 !== FALSE) {
                imagepng($im2, $mydir.'crop/'.$myfile);
                imagedestroy($im2);
                $file2 = str_replace('.', '-b.', $myfile);
                imagepng($im2b, $mydir.'crop/'.$file2);
                imagedestroy($im2b);
            }
            imagedestroy($im);
        }






        $io->success('images croppées');
        return Command::SUCCESS;
    }
}