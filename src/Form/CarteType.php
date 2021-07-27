<?php

namespace App\Form;

use App\Entity\Set;
use App\Entity\Carte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CarteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('type')
            ->add('attribut')
            ->add('niveau')
            ->add('archetype')
            ->add('rarete')
            ->add('stock')
            ->add('prix')
            ->add('img',FileType::class, ['mapped' => false, 'help' => 'png,jpeg - 2 Mo max', 'constraints' =>
            [new File(['maxSize'=>'2048k', 'mimeTypes'=>['image/png','image/jpg','image/jpeg','image/jp2'], 'mimeTypesMessage'=>'Merci de selectionner un fichier au format png/jpg/jpeg/jp2 '])]]) 
            ->add('set_id', EntityType::class,['label'=>"set", 'class'=>Set::class, 'choice_label' => "nom"])
            ->add('libelle')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Carte::class,
        ]);
    }
}
