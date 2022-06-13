<?php

namespace App\Form;

use App\Entity\Schedule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dayOfWeek', ChoiceType::class, [
                'choices' => [
                    'Понедельник' => 'Понедельник',
                    'Вторник' => 'Вторник',
                    'Среда' => 'Среда',
                    'Четверг' => 'Четверг',
                    'Пятница' => 'Пятница',
                    'Суббота' => 'Суббота',
                ],
                'label' => 'День недели'
            ])
            ->add('class', ChoiceType::class, [
                'choices' => [
                    '1 пара' => '1',
                    '2 пара' => '2',
                    '3 пара' => '3',
                    '4 пара' => '4',
                    '5 пара' => '5',
                    '6 пара' => '6',
                ],
                'label' => 'Пара'
            ])
            ->add('studentGroup', options: [
                'label' => 'Группа',
            ])
            ->add('subject', options: [
                'label' => 'Предмет'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Schedule::class,
        ]);
    }
}
