<?php

namespace ForumBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use ForumBundle\Form\Type\Model\AbstractTopicType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TopicEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('forum', EntityType::class, array(
                'label'        => 'forum.choice',
                'class'        => 'ForumBundle:Forum',
                'choice_label' => 'name',
            ))
        ;
    }

    public function getParent()
    {
        return AbstractTopicType::class;
    }
}
