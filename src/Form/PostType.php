<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PostType extends AbstractType
{
    private $slugger;
    private $security;

    // Form types are services, so you can inject other services in them if needed
    public function __construct(SluggerInterface $slugger, Security $security)
    {
        $this->slugger = $slugger;
        $this->security = $security->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $post = $event->getData();
                $form = $event->getForm();

                // check if the Post object is "new"
                // If no data is passed to the form, the data is "null".
                // This should be considered a new "Post"
                if (!$post || null === $post->getId()) {
                    $form->add('save',SubmitType::class,
                        ['label' => 'New Post']);
                }
            })
            ->add('name', TextType::class)

            ->add('price', IntegerType::class)

            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'name',
                'expanded'  => true,
                'multiple'  => true,
                'by_reference' => false
            ])
			->add('imageFile', FileType::class, [
                'label' => 'Image',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Post details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '10024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => "name",
            ])
            ->add('publishedAt', DateTimeType::class, [
                'label' => 'label.published_at',
                'help' => 'help.post_publication',
                'widget' => 'single_text',
            ])
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                /** @var Post */
                $post = $event->getData();
                if (null !== $postTitle = $post->getName()) {
                    $post->setSlug($this->slugger->slug($postTitle)->lower());
                    //si le user est attaché au produit, utiliser le security passé en paramètre
                }
            })
            ->add('save',SubmitType::class,
                ['label' => 'Edit Post']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }

}
