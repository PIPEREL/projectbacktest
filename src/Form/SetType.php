<?php

namespace App\Form;

use App\Entity\Set;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['attr'=>['placeholder' => "Nom du paquet"]])
            ->add('description', TextareaType::class, ['attr'=> ['maxLength' => 500,'minLength' => 15,'placeholder' =>'500 char max']])
            ->add('libelle', TextType::class, ['attr'=>['placeholder' => "ex : PHRA"]])
            ->add('date_parution')
            ->add('img',FileType::class, ['mapped' => false, 'help' => 'png,jpeg - 2 Mo max', 'constraints' =>
            [new File(['maxSize'=>'2048k', 'mimeTypes'=>['image/png','image/jpg','image/jpeg','image/jp2'], 'mimeTypesMessage'=>'Merci de selectionner un fichier au format png/jpg/jpeg/jp2 '])]]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Set::class,
        ]);
    }
}
