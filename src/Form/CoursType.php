<?php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['attr' => ['class' => "p-2 my-2 bg-gray-200 rounded border-solid border-2 border-gray-400"]])
            ->add('description', TextType::class, ['attr' => ['class' => "p-2 my-2 bg-gray-200 rounded border-solid border-2 border-gray-400"]])
            ->add('contenu', TextType::class, ['attr' => ['class' => "p-2 my-2 bg-gray-200 rounded border-solid border-2 border-gray-400"]])
            ->add('categorie')
            ->add('Ajouter', SubmitType::class, array('attr' => array('class' => 'ml-6 p-2 px-5 bg-gray-200 rounded hover:bg-gray-400')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
