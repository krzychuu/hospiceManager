<?php

namespace Hospice\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventRecurType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('interval')
            ->add('intervalFlags')
            ->add('end', 'datetime', array(
                  'date_widget' => 'single_text',
                  'time_widget' => 'single_text',
                  'format' => 'yyyy-MM-dd',
                  'attr' => array(
                                  'class' => $this->getName() . "end",
                                  'data-date-format' => 'yy-mm-dd',), ))
//            ->add('event')
            ->add('frequency')
            ->add('parent')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hospice\SiteBundle\Entity\EventRecur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hospice_sitebundle_eventrecur';
    }
}
