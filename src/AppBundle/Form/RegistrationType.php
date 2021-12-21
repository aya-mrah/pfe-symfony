<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
                ->add('prenom')
                ->add('cin')
                ->add('adresse')
                ->add('telephone')
                ->add('datenaissance',BirthdayType::class, array(
                'placeholder' => array(
                'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                )))
                ->add('path',FileType::class,['label' => 'path'])
                ->add('profession')
                ->add('sexe',ChoiceType::class,array('choices'=>array('Homme'=>'Homme','Femme'=>'Femme')));
                
                
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getNom()
    {
        return $this->getBlockPrefix();
    }
    
}