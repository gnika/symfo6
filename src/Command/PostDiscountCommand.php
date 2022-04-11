<?php
namespace App\Command;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
class PostDiscountCommand extends Command
{
    protected static $defaultName = 'post:discount';
    protected static $defaultDescription = 'Set a discount to our
posts';
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var PostRepository */
    private $postRepository;
    /** @var CategoryRepository */
    private $categoryRepository;
    public function __construct(EntityManagerInterface $entityManager,
                                PostRepository $postRepository,
                                CategoryRepository $categoryRepository)
    {
        $this->entityManager = $entityManager;
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('percent', InputArgument::OPTIONAL,
                'discount percentage', 10)
            ->addOption('category', 'c',
                InputOption::VALUE_REQUIRED, 'post\s category name')
        ;
    }
    protected function execute(InputInterface $input,
                               OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $percent = (int)$input->getArgument('percent');
        if ($category_name = $input->getOption('category')) {
            $category = $this->categoryRepository->findOneBy(['name'
            => $category_name]);
            $posts = $category->getPosts();
        }else{
            $posts = $this->postRepository->findAll();

        }

        if($posts->isEmpty()){
            $io->caution('There\'s no posts here');
            return Command::INVALID;
        }
        foreach ($posts as $post) {
            $post->setPrice($post->getPrice() -
                $post->getPrice() * $percent / 100);
            $this->entityManager->persist($post);
        }
        $this->entityManager->flush();
        $io->success('Discounts persisted : '.$percent.'%');
        return Command::SUCCESS;
    }
}