<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void  //va permettre de creer le formulaire que l'on va récuperer en html
    {
        $builder // va créer des champs de formulaire
            ->add('title', TextType::class, [
                'label' => ' Titre de l\'article',
        ])
            ->add('content', TextareaType::class,[
                'label' => ' Contenu de l\'article',
            ])
            //->add('createdAt',)
            ->add('isPublished', ChoiceType::class, [
                'label' => 'Afficher',
                'choices' => ['Oui' => 1, 'Non' => 0]
            ])

            ->add('category', EntityType::class,[ //  va afficher les entitée/table de catégorie en base de donnée
                'class'=>Category::class ,
                'choice_label' => 'name',
            ])
            ->add('valider', SubmitType::class, [
                'label'=>'Ajouter...'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
