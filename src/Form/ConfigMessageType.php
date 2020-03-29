<?php

namespace App\Form;

use App\Entity\ConfigMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ConfigMessageType extends AbstractType
{
    private $trans;

    /**
     * ConfigMessageType constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface               $em
     * @param \Symfony\Component\Translation\TranslatorInterface $trans
     */
    public function __construct(EntityManagerInterface $em, TranslatorInterface $trans)
    {
        $this->em    = $em;
        $this->trans = $trans;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'language',
                ChoiceType::class,
                [
                    'choices'     => [
                        ''                      => '',
                        'message.form.label.Fr' => 0,
                        'message.form.label.Ar' => 1,
                        'message.form.label.En' => 2,
                    ],
                    'attr'        => [
                        "class" => "form-control select2-no-search col-sm-6",
                    ],
                    'label'       => 'message.form.label.language',
                    'placeholder' => '-- Choisissez la langue --',
                    'required'    => true,
                    'constraints' => [
                        new NotBlank(['message' => $this->trans->trans('config_message.form.validation.empty')]),
                    ],
                ]
            )
            ->add('isDefault')
            ->add(
                'body',
                TextType::class,
                [
                    'attr'        => [
                        "class" => "form-control input-sm",
                        'maxlength' => '160'
                    ],
                    'required'    => true,
                    'constraints' => [
                        new NotBlank(['message' => $this->trans->trans('config_message.form.validation.empty')]),
                        new Length(['min' => 2, 'max' => 160]),
//                        new Regex(
//                            [
//                                'pattern' => '/^[\p{Arabic}\s]+$/u',
//                                'match'   => true,
//                                'message' => $this->trans->trans('candidature.form.validation.alpha'),
//                            ]
//                        ),
                    ],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => ConfigMessage::class,
            ]
        );
    }
}
