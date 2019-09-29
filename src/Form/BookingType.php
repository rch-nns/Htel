<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\BookingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateType::class, ["widget" => "single_text", "label" => "Date de prise en charge"])
            ->add('endDate', DateType::class, ["widget" => "single_text", "label" => "Date de restitution"])
            ->add('comment', TextareaType::class, ["label" => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
