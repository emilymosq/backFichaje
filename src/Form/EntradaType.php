<?php

namespace App\Form;

use App\Entity\Entrada;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;

class EntradaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comentario')
            ->add('locacion', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'Elige una opción',
                'choices'  => [
                    'Talent Garden - Madrid' => 'Madrid',
                    'Barcelona' => 'Barcelona',
                    'Teletrabajo' => 'Teletrabajo'
                ],
            ])
            ->add('INICIAR', SubmitType::class);

        $builder->get('locacion')
            ->addModelTransformer(new CallbackTransformer(
                function ($locacionArray) {
                    // transform the array to a string
                    return count($locacionArray) ? $locacionArray[0] : null;
                },
                function ($locacionString) {
                    // transform the string back to an array
                    return [$locacionString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entrada::class,
        ]);
    }
}
