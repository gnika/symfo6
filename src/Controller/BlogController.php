<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Tag;
use App\Form\PostType;
use App\Form\TagType;
use App\Repository\PostRepository;
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
* @Route("/blog")
*/
class BlogController extends AbstractController
{

    private $em;

    public function __construct(ManagerRegistry $registry)
    {
        $this->em = $registry;
    }

  /**
	* @Route("/{id}",
	name="post_show",
	methods={"GET"},
	requirements={"id"="\d+"})
	*/
	public function show( Request $request, int $id=6): Response
	{
        $id_request = $request->get('id');
        $post    = $this->em->getRepository(Post::class);
        $thePost = $post->find($id);
		

        return $this->render('blog/show.html.twig', [
            'post' => $thePost,
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
	public function posts( Request $request): Response
	{

        $post    = $this->em->getRepository(Post::class);
        $posts	 = $post->findAll();

        return $this->render('blog/posts.html.twig', [
            'posts' => $posts,
        ]);
	}

    /**
     * @Route("/new", name="post_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        //dd(t('help.app_description', [], 'messages+intl'));

        //dd($request);
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);


        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('imageFile')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $post->setImageFile($brochureFileName);
            }

            $entityManager = $this->em->getManager();

            $entityManager->persist($post);

            $entityManager->flush();


            $this->addFlash(
                'success',
                'post.created_successfully'
            );

        }

        return $this->render('blog/new.html.twig', [
            'post' => $post,
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

        return $this->render('blog/new_tag.html.twig', [
            'tag' => $tag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="post_edit",
    methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post, FileUploader $fileUploader):Response
    {

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			
			// dd($post);
			if($form->get('imageFile')->getData() != null){
				/** @var UploadedFile $brochureFile */
				$brochureFile = $form->get('imageFile')->getData();
				if ($brochureFile) {
					$brochureFileName = $fileUploader->upload($brochureFile);
					$post->setImageFile($brochureFileName);
				}
			}
            $this->em->getManager()->flush();


            $this->addFlash(
                'success',
                'post.created_successfully'
            );


            return $this->redirectToRoute('listing');
        }

		if( $post->getImageFile() != '' )
            $post->setImageFile(new File($this->getParameter('brochures_directory').'/'.$post->getImageFile()));
		
        return $this->render('blog/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_delete", methods={"POST"})
     */
    public function delete(Request $request, Post $post):
    Response
    {
        $entityManager = $this->em->getManager();
        $entityManager->remove($post);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'post.deleted_successfully'
        );

        return $this->redirectToRoute('listing');
    }




}
