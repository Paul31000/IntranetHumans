<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Questionnaire;
use App\Entity\Champ;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class QuestionnaireFinalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('pseudo',TextType::class,['label'    => 'pseudo']);
        
        for ($i=0;$i<=count($options['questionnaire']->getChamps());$i++){

            foreach( $options['questionnaire']->getChamps() as $champ){
                if($champ->getOrdre()==$i){
                    if ($champ->getType()==="checkbox"){
                        $builder
                        ->add($champ->getNomTechnique(), ChoiceType::class, 
                        ['label'    => $champ->getLibelle(),
                        'required' => true,
                        'choices'  => [
                            'Oui' => true,
                            'Non' => false,
                        ],
                        'data' => 'Oui']);
                    }
                    
                    elseif ($champ->getType()==="texte"){
                        $builder
                        ->add($champ->getNomTechnique(), TextType::class,['label'    => $champ->getLibelle(),'required' => true,]);
                    }
                    
                    elseif ($champ->getType()==="textarea"){
                        $builder
                        ->add($champ->getNomTechnique(), TextareaType::class, ['attr' => array('cols' => '35', 'rows' => '5'),
                        'required' => true,'label'    => $champ->getLibelle()]);
                    }
                }
            }
        }
        
        $builder->add('sauverLesReponses', SubmitType::class);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Questionnaire::class,
            'questionnaire' => null,
        ]);
    }
}
