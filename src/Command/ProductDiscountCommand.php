<?php
namespace App\Command;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
class ProductDiscountCommand extends Command
{
    protected static $defaultName = 'product:discount';
    protected static $defaultDescription = 'Set a discount to our
products';
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var ProductRepository */
    private $productRepository;
    /** @var CategoryRepository */
    private $categoryRepository;
    public function __construct(EntityManagerInterface $entityManager,
                                ProductRepository $productRepository,
                                CategoryRepository $categoryRepository)
    {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('percent', InputArgument::OPTIONAL,
                'discount percentage', 10)
            ->addOption('category', 'c',
                InputOption::VALUE_REQUIRED, 'product\s category name')
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
            $products = $category->getProducts();
        }else{
            $products = $this->productRepository->findAll();

        }

        if($products->isEmpty()){
            $io->caution('There\'s no products here');
            return Command::INVALID;
        }
        foreach ($products as $product) {
            $product->setPrice($product->getPrice() -
                $product->getPrice() * $percent / 100);
            $this->entityManager->persist($product);
        }
        $this->entityManager->flush();
        $io->success('Discounts persisted : '.$percent.'%');
        return Command::SUCCESS;
    }
}