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
use Doctrine\Common\Collections\Criteria;
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


class Parsehtml extends Command
{
    protected static $defaultName = 'scrapper:html'; //recréer les html dans le dossier parses/parse1

    //scrapper:png -c2        ====> recréer les html dans le dossier parses/parse2

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

            ->addOption('category', 'c',
                InputOption::VALUE_REQUIRED, 'category à parser', 1)



        ;
    }
    protected function execute(InputInterface $input,
                               OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $categoryId = $input->getOption('category');

        if( $categoryId == 1 ) {
            $annonces = $this->parse1Repository->findPhone();
        }

        if( $categoryId == 2 )
            $annonces = $this->parse2Repository->findPhone();



            foreach( $annonces as $annonce ) {

                $myfile = fopen("parses/parse".$categoryId."/" . $annonce->getUrlOffre(), "w");
                fwrite($myfile, "parses/parse".$categoryId."/" . $annonce->getUrlOffre());
                fclose($myfile);

            }


        $io->success('urls parsées');
        return Command::SUCCESS;
    }

}