<?php

namespace App\Form;

use App\Entity\Materiel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AjoutOutilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' =>"Entrez le nom de l'outil" 
                          ]           
                    ] )
            ->add('categorie')

            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' =>"Entrez la description de l'outil" 
                          ]           
                    ] )

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
            'data_class' => Materiel::class,
        ]);
    }
}
