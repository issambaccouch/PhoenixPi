<?php

namespace ForumBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use ForumBundle\Form\Type\Model\AbstractTopicType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
class TopicType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', CKEditorType::class,
                array(
                    'label'  => 'forum.post',
                    'mapped' => false
                )
            )
        ;
    }
  
    public function getParent()
    {
        return AbstractTopicType::class;
    }
}
