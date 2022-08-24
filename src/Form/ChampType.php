<?php

namespace App\Form;

use App\Entity\Champ;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ChampType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    "checkbox"  => "checkbox",
                    "texte"     => "texte",
                    "textarea"  => "textarea"
                ],
            ])
            ->add('ordre')
            ->add('questionnaire')
            ->add('sauverLeChamp', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Champ::class,
        ]);
    }
}
