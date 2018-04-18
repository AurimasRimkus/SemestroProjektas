<?php
namespace App\Form;

use App\Entity\Profile;

use function Sodium\add;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Name'
            ))
            ->add('secondName', TextType::class, array(
                'label' => 'Second name'
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email'
            ))
            ->add('phoneNumber', TextType::class, array(
                'label' => 'Phone Number'
            ))
            ->add('birthDate', DateType::class, array(
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')-100),
                'label' => 'Birth Date'
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Save changes'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Profile::class,
        ));
    }
}
