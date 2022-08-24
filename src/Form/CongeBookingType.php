<?php

namespace App\Form;

use App\Entity\Conge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class CongeBookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('debut',DateTimeType::class,
            ['required' => true,
            'widget' => 'single_text',
            'html5' => false,
            'attr' => [
                'class' => 'form-control',
                'data-td-target' => '#linkedPickers1',
                'data-format' => 'd/m/Y\, H:i',
            ],],)
            ->add('fin',DateTimeType::class,
            ['required' => true,
            'widget' => 'single_text',
            'html5' => false,
            'attr' => [
                'class' => 'form-control',
                'data-td-target' => '#linkedPickers1',
                'data-format' => 'd/m/Y\, H:i',
            ],],)
            ->add('employeInformation')
            ->add('signaler', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conge::class,
        ]);
    }
}
