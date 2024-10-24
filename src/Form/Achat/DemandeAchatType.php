<?php

namespace App\Form\Achat;

use App\Entity\Achat\DemandeAchat;
use App\Entity\Tiers\Tiers;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeAchatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('motif', TextareaType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label']
            ])
            ->add('fournisseur', EntityType::class, [
                'class' => Tiers::class,
                'choice_label' => 'id',
                'attr' => ['class' => 'form-select'],
                'label_attr' => ['class' => 'form-label']
            ])
            ->add('detailsDemandeAchats', CollectionType::class, [
                'entry_type' => DetailsDemandeAchatType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'attr' => ['class' => 'details-collection'],
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DemandeAchat::class,
        ]);
    }
}
