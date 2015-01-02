<?php

namespace Hospice\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('name')
            ->add('description')
            ->add('start', 'datetime', array(
                  'date_widget' => 'single_text',
                  'time_widget' => 'single_text',
                  'format' => 'yyyy-MM-dd',
                  'attr' => array(
                                  'class' => $this->getName() . "_start",
                                  'data-date-format' => 'yy-mm-dd',), ))
            ->add('end', 'datetime', array(
                  'date_widget' => 'single_text',
                  'time_widget' => 'single_text',
                  'format' => 'yyyy-MM-dd',
                  'attr' => array(
                                  'class' => $this->getName() . "end",
                                  'data-date-format' => 'yy-mm-dd',), ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hospice\SiteBundle\Entity\Event'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hospice_sitebundle_event';
    }
}
