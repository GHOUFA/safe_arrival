<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form\Type;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegistrationFormType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,
                array('label' => false,
                      'attr' => array(
                          'placeholder' => 'Email',
                          'class' => 'form-control m-input'
                      ),
                      'translation_domain' => 'FOSUserBundle'))
            ->add('username', null, array('label' => false,
                                          'attr' => array(
                                              'placeholder' => 'Username',
                                              'class' => 'form-control m-input'
                                          ),
                                          'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array(
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => array(
                        'autocomplete' => 'new-password',
                    ),
                ),
                'first_options' => array('label' => false,
                                         'attr' => array(
                                             'placeholder' => 'Password',
                                             'class' => 'form-control m-input'
                                         ),
                ),
                'second_options' => array('label' => false,
                                          'attr' => array(
                                              'placeholder' => 'Repeat password',
                                              'class' => 'form-control m-input'
                                          ),),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            /*->add('Groups',EntityType::class, array(
                'class' => 'App:Group',
                'label' => 'choose role',
                'multiple' => true,
                'expanded' => true,
                'data' => false
            ))*/

        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\User',
            'csrf_token_id' => 'registration',
        ));
    }

    // BC for SF < 3.0

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fos_user_registration';
    }

}
