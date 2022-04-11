<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Tag;
use App\Form\ProductType;
use App\Form\TagType;
use App\Repository\ProductRepository;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;
use function Symfony\Component\Translation\t;

/**
* @Route("/product")
*/
class ProductController extends AbstractController
{

    private $em;

    public function __construct(ManagerRegistry $registry)
    {
        $this->em = $registry;
    }

  /**
	* @Route("/{id}",
	name="product_show",
	methods={"GET"},
	requirements={"id"="\d+"})
	*/
	public function show( Request $request, int $id=6): Response
	{
        $id_request = $request->get('id');
        $product    = $this->em->getRepository(Product::class);
        $theProduct = $product->find($id);

        return $this->render('product/show.html.twig', [
            'product' => $theProduct,
        ]);


        //$products   = $product->findAllGreaterThanPrice(30);
        /*
            foreach( $products as $prod ){
                echo $prod->getName().'<br/>';
                echo $prod->getCategory()->getName().'<br/>';
        }
        $category   = $this->em->getRepository(Category::class);
        $categ      = $category->find(10);
        $products   = $categ->getProducts();
        foreach( $products as $pp ){
            echo $pp->getName().'<br>';
        }
         */
	}

  /**
	* @Route("/list",
	name="listing",
	methods={"GET"})
	*/
	public function products( Request $request): Response
	{

        $product    = $this->em->getRepository(Product::class);
        $products = $product->findAll();

        return $this->render('product/products.html.twig', [
            'products' => $products,
        ]);
	}

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        //dd(t('help.app_description', [], 'messages+intl'));

        //dd($request);
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);


        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('imageFile')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $product->setImageFile($brochureFileName);
            }

            $entityManager = $this->em->getManager();

            $entityManager->persist($product);

            $entityManager->flush();


            $this->addFlash(
                'success',
                'post.created_successfully'
            );

        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new/tag", name="tag_new", methods={"GET","POST"})
     */
    public function newtag(Request $request): Response
    {

        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);


        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->em->getManager();
            $entityManager->persist($tag);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'tag.created_successfully'
            );

        }

        return $this->render('product/new_tag.html.twig', [
            'tag' => $tag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit",
    methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product, FileUploader $fileUploader):Response
    {

        if( $product->getImageFile() != '' )
            $product->setImageFile(new File($this->getParameter('brochures_directory').'/'.$product->getImageFile()));

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('imageFile')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $product->setImageFile($brochureFileName);
            }
            $this->em->getManager()->flush();


            $this->addFlash(
                'success',
                'post.created_successfully'
            );


            return $this->redirectToRoute('listing');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product):
    Response
    {
        $entityManager = $this->em->getManager();
        $entityManager->remove($product);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'post.deleted_successfully'
        );

        return $this->redirectToRoute('listing');
    }




}
