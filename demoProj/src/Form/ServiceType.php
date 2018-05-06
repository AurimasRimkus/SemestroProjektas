<?php
namespace App\Form;

use App\Entity\Service;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use function Sodium\add;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('cost', IntegerType::class)
            ->add('duration', IntegerType::class)
            ->add('isActive',ChoiceType::class, array(
                'choices' => array(
                    'Yes' => true,
                    'No' => false),
                'label' => 'Is service type active',
                'multiple'=>false,
                'expanded'=>true))
            ->add('submit', SubmitType::class, array(
                'label' => 'Submit service type'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Service::class,
        ));
    }
}