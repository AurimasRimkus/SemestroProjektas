<?php
namespace App\Form;
use App\Entity\User;
use function Sodium\add;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', PasswordType::class)
            ->add('newPassword', RepeatedType::class, array(
                'type'=>PasswordType::class,
                'first_options' => array('label' => 'New password'),
                'second_options' => array('label' => 'Repeat new password'),
                'invalid_message' => 'New password fields must match.',
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Change password'
            ))
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}
