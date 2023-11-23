<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\TrainingStatistic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingStatisticType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $builder
                ->add('actualDelay')
                ->add('actualPresence')
                ->add('actualAbsence');
        } else {
            $builder
                ->add('expectedDelay')
                ->add('expectedAbsence')
                ->add('expectedPresence');
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TrainingStatistic::class,
        ]);
    }
}
