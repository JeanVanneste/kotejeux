<?php

namespace App\Form;

use App\Entity\Jeu;
use App\Entity\Editeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class JeuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('auteur')
            ->add('category')
            ->add('gameDuration')
            ->add('playerMin')
            ->add('playerMax')
            ->add('description')
            ->add('boxPicture')
            ->add('interiorPicture')
            ->add('editeur', EntityType::class, array(
                'class' => Editeur::class,
                'choice_label' => 'name',
                ))
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Jeu::class,
        ]);
    }
}
