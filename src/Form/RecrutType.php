<?php

namespace App\Form;

use App\Entity\Recrut;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RecrutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('poste', TextType::class, 
            [
                'constraints' => 
                [
                    new NotBlank(["message" => "vous n'avez pas saisi le nom du poste"]),
                    new Length(
                        [
                            'min' => 4, 'max' => 500,
                            'minMessage' => "Ce champs doit comporter {{ limit }} caractères minimum",
                            'maxMessage' => "Ce champs doit comporter {{ limit }} caractères maximum"
                        ])
                ]
            ])
            ->add('description', TextareaType::class, 
            [
                'constraints' => 
                [
                    new NotBlank(["message" => "vous n'avez pas saisi la déscription"])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recrut::class,
        ]);
    }
}
