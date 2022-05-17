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

use App\Entity\Parse1;
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
class SearchParse1Type extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // ...,
            'modeles' => false,
            'anneeModele' => false,
            'marque' => false,
            'carburant' => false,
            'vehiculeType' => false,
            'couleur' => false,
            'places' => false,
            'portes' => false,
            'puissanceFiscale' => false,
            'puissanceDin' => false,
            'piecesDetachees' => false,
            'region' => false,
            'departement' => false,
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
            ->add('marque', ChoiceType::class, [
                'placeholder' => 'label.marque',
                'choices'  => $options['marque'],
            ])
            ->add('modele', ChoiceType::class, [
                'placeholder' => 'label.modele',
                'choices'  => $options['modeles'],
            ])
            ->add('AnneeModele', ChoiceType::class, [
                'placeholder' => 'label.anneeModele',
                'choices'  => $options['anneeModele'],
            ])
            ->add('vehiculeType', ChoiceType::class, [
                'placeholder' => 'label.vehiculeType',
                'choices'  => $options['vehiculeType'],
            ])
            ->add('carburant', ChoiceType::class, [
                'placeholder' => 'label.carburant',
                'choices'  => $options['carburant'],
            ])
            ->add('couleur', ChoiceType::class, [
                'placeholder' => 'label.couleur',
                'choices'  => $options['couleur'],
            ])
            ->add('places', ChoiceType::class, [
                'placeholder' => 'label.places',
                'choices'  => $options['places'],
            ])
            ->add('portes', ChoiceType::class, [
                'placeholder' => 'label.portes',
                'choices'  => $options['portes'],
            ])
            ->add('puissanceDin', ChoiceType::class, [
                'placeholder' => 'label.din',
                'choices'  => $options['puissanceDin'],
            ])
            ->add('avecPermis', ChoiceType::class, [
                'placeholder' => 'label.permis',
                'choices'  => [
                    'Oui' => 1,
                    'Non' => 0
                ],
            ])
            ->add('SoumisALoaLld', ChoiceType::class, [
                'placeholder' => 'label.LOA',
                'choices'  => [
                    'Oui' => 1,
                    'Non' => 0
                ],
            ])
            ->add('puissanceFiscale', ChoiceType::class, [
                'placeholder' => 'label.puissanceFiscale',
                'choices'  => $options['puissanceFiscale'],
            ])
            ->add('piecesDetachees', ChoiceType::class, [
                'placeholder' => 'label.piecesDetachees',
                'choices'  => $options['piecesDetachees'],
            ])
            ->add('BoiteDeVitesse', ChoiceType::class, [
                'placeholder' => 'label.boiteVitesse',
                'choices'  => [
                    'Manuelle' => 'Manuelle',
                    'Automatique' => 'Automatique'
                ],
            ])
            ->add('kilometrageMax', TextType::class, [
            ])
            ->add('date_circulation_max', DateType::class, [
                'placeholder' => 'label.date_circulation',
                'widget' => 'single_text',
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
