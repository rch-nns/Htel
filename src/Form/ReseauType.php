<?php

namespace App\Form;

use App\Entity\Reseau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReseauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('soustitre')
            ->add('texte')
            ->add('imageFile', VichImageType::class,
            [
                'download_label' => "Parcourir",
                'download_uri' => false,
                'delete_label' => "supprimer l'image"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reseau::class,
        ]);
    }
}
