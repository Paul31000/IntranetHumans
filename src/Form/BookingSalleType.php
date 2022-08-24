<?php

namespace App\Form;

use App\Entity\OccupationSalle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class BookingSalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('creneau',DateTimeType::class,
            ['required' => true,
            'widget' => 'single_text',
            'html5' => false,
            'attr' => [
                'class' => 'form-control',
                'data-td-target' => '#linkedPickers1',
                'data-format' => 'd/m/Y\, H:i',
            ],],)
            ->add('finCreneau',DateTimeType::class,
            ['required' => true,
            'widget' => 'single_text',
            'html5' => false,
            'attr' => [
                'class' => 'form-control',
                'data-td-target' => '#linkedPickers2',
                'data-format' => 'd/m/Y\, H:i',
            ],],)
            ->add('employeOccupant',null,['required' => true])
            ->add('salle',null,['required' => true])
            ->add('reserver', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OccupationSalle::class,
        ]);
    }
}
