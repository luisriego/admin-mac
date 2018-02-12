<?php

namespace AppBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstacaoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('qtd', TextType::class, array(
                'label'         => 'Quantidade',
                'attr' => array(
                    'class' => 'input_fields_wrap control-group span3',
                ),
            ))
            ->add('tipo', EntityType::class, array(
                'class' => 'AppBundle\Entity\TipoEstacao',
                'property'      => 'nome',
                'choice_label'  => 'nome',
                'required'      => false,
                'multiple'      => false,
                'attr' => array(
                    'class' => 'input_fields_wrap control-group span8',
                ),
            ))
            ->add('cliente', EntityType::class, array(
                'class' => 'AppBundle\Entity\Cliente',
                'property'      => 'nome',
                'choice_label'  => 'nome',
                'required'      => true,
                'multiple'      => false,
//                'attr' => array(
//                    'class' => 'hidden',
//                ),
            ))
//            ->add('cliente', HiddenType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Estacao'
        ));
    }
}