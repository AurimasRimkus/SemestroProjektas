<?php
namespace App\Form;

use App\Entity\Car;

use function Sodium\add;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numberPlate', TextType::class, array(
                'label' => 'Number Plate'
            ))
            ->add('model', TextType::class, array(
                'label' => 'Model'
            ))
            ->add('engineType', ChoiceType::class, array(
                'choices' => array(
                    'Petrol' => 'Petrol',
                    'Diesel' => 'Diesel'),
                'label' => 'Engine Type'
            ))
            ->add('transmission', ChoiceType::class, array(
                'choices' => array(
                    'Automatic' => 'Automatic',
                    'Manual' => 'Manual'),
                'label' => 'Transmission'
            ))
            ->add('power', IntegerType::class, array(
                'label' => 'Power kW'
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Save car'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Car::class,
        ));
    }
}
