<?php
namespace ForumBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'forum.forum.form.name'))
            ->add('description', TextType::class, array('label' => 'forum.forum.form.description'))
            ->add('image', UrlType::class, array(
                'required' => false
            ))
            ->add('category', EntityType::class, array(
                'label'        => 'forum.forum.form.category',
                'class'        => 'ForumBundle:Category',
                'choice_label' => 'name',
            ))
            ->add('position')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ForumBundle\Entity\Forum',
            'roles' => null
        ));
    }
}
