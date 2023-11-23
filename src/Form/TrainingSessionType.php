<?php

namespace App\Form;

use DateTime;
use App\Entity\Team;
use App\Entity\TrainingSession;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class TrainingSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sessionNumber')
            // je veux pouvoir chosir l'heure dans le formulaire dans la date
            ->add('date', DateTimeType::class, [
                'widget' => 'choice',
                'data' => new DateTime('now'), // Définit la date par défaut à la date actuelle
                'html5' => false,
                'format' => 'yyyy-MM-dd',
            ])
            ->add('team', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'teamName',
            ])        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TrainingSession::class,
        ]);
    }
}
