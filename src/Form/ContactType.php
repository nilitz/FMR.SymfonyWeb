<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Prénom',
                )
            ])
            ->add('lastName', TextType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Nom',
                )
            ])
            ->add('phone', TextType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Numéro de Téléphone',
                )
            ])
            ->add('email', TextType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'E-Mail',
                )
            ])
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Titre du message',
                )
            ])
            ->add('message', TextareaType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Votre message',
                )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}