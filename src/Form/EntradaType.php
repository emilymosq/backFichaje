<?php

namespace App\Form;

use App\Entity\Entrada;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EntradaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('locacion', ChoiceType::class, [
                'choices'  => Entrada::TYPES
            ])
            ->add('comentario')
            ->add('foto', FileType::class, ['label' => 'Agrega un justificante (Opcional)', 'mapped' => false, 'required' => false])
            ->add('INICIAR', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entrada::class,
        ]);
    }
}
