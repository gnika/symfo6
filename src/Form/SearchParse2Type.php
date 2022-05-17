<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form\Type;

use App\Entity\Parse2;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Defines the custom form field type used to change user's password.
 *
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
class SearchParse2Type extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // ...,
            'typeDeBien' => false,
            'typeDeVente' => false,
            'pieces' => false,
            'energie' => false,
            'ges' => false,
            'vente' => false,
            'etages' => false,
            'etage' => false,
            'parking' => false,
            'charges' => false,
            'meuble' => false,
            'region' => false,
            'departement' => false,
            'chambres' => false,
        ]);

    }


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('avecNumeroDeTelephone', ChoiceType::class, [
                'choices'  => [''=>'', 'Oui' => '1'],
            ])
            ->add('region', ChoiceType::class, [
                'placeholder' => 'label.region',
                'choices'  => $options['region'],
            ])
            ->add('departement', ChoiceType::class, [
                'placeholder' => 'label.departement',
                'choices'  => $options['departement'],
            ])
            ->add('typeDeBien', ChoiceType::class, [
                'placeholder' => 'label.typeDeBien',
                'choices'  => $options['typeDeBien'],
            ])
            ->add('typeDeVente', ChoiceType::class, [
                'placeholder' => 'label.typeDeVente',
                'choices'  => $options['typeDeVente'],
            ])
            ->add('pieces', ChoiceType::class, [
                'placeholder' => 'label.pieces',
                'choices'  => $options['pieces'],
            ])
            ->add('chambres', ChoiceType::class, [
                'placeholder' => 'label.chambres',
                'choices'  => $options['chambres'],
            ])
            ->add('energie', ChoiceType::class, [
                'placeholder' => 'label.energie',
                'choices'  => $options['energie'],
            ])
            ->add('ges', ChoiceType::class, [
                'placeholder' => 'label.ges',
                'choices'  => $options['ges'],
            ])
            ->add('vente', ChoiceType::class, [
                'placeholder' => 'label.vente',
                'choices'  => $options['vente'],
            ])
            ->add('etages', ChoiceType::class, [
                'placeholder' => 'label.etages',
                'choices'  => $options['etages'],
            ])
            ->add('etage', ChoiceType::class, [
                'placeholder' => 'label.etage',
                'choices'  => $options['etage'],
            ])
            ->add('parking', ChoiceType::class, [
                'placeholder' => 'label.parking',
                'choices'  => $options['parking'],
            ])
            ->add('charges', ChoiceType::class, [
                'placeholder' => 'label.charges',
                'choices'  => $options['charges'],
            ])
            ->add('meuble', ChoiceType::class, [
                'placeholder' => 'label.meuble',
                'choices'  => $options['meuble'],
            ])
            ->add('DateDeRecuperation', DateType::class, [
                'placeholder' => 'label.createdAt',
                'widget' => 'single_text',
            ])
            ->add('titre', TextType::class, [
            ])
            ->add('prixMax', TextType::class, [
            ])
            ->add('ville', TextType::class, [
            ])
            ->add('SoumettreLaRecherche', SubmitType::class, [
            ])
            ->add('ExporterLaRecherche', SubmitType::class, [
                'attr' => ['class' => 'btn btn-danger']
            ]);
    }
}
