<?php

namespace TestBundle\Form;

use Doctrine\DBAL\Types\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')
            ->add('text',TextareaType::class , [                'attr' => ['class' => 'tinymce'],
            ])
            ->add('imageart',FileType::class,array('data_class' => null,'required' => false))
            ->add('approve',HiddenType::class)
            ->add('nbrvue',HiddenType::class)
            ->add('dateajout',HiddenType::class)
            ->add('nbrrec',HiddenType::class)
            ->add('idtag', EntityType::class, array(
                'class'=> 'TestBundle\Entity\Tags',
                'choice_label'=> 'nomtag','data_class' => null,


                'multiple' => false

            ))
        // ->setMethod("GET");
        ->getForm();

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TestBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'testbundle_article';
    }


}
