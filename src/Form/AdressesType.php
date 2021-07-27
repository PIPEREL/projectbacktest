<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Adresses;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AdressesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pays',TextType::class, ['label' => "pays", 'attr'=>["placeholder"=> "max 100 char"]])
            ->add('ville',TextType::class, ['label' => "ville", 'attr'=>["placeholder"=> "max 100 char"]])
            ->add('rue',TextType::class, ['label' => "rue", 'attr'=>["placeholder"=> "max 100 char"]])
            ->add('code_postal', IntegerType::class, ['label' => "code postal", 'attr'=>["placeholder"=> "max 100 char"]])
            ->add('titre',TextType::class, ['label' => "titre", 'attr'=>["placeholder"=> "max 100 char"]])
            ->add('user',EntityType::class,['label'=>"utilisateur", 'class'=>User::class, 'choice_label' =>"email"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adresses::class,
        ]);
    }
}
