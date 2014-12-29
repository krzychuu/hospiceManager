<?php

namespace Hospice\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VolunteerType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pesel')
            ->add('name')
            ->add('lastname')
            ->add('birth_date')
            ->add('street')
            ->add('city')
            ->add('mail')
            ->add('phone')
            ->add('type')
            ->add('patients')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hospice\SiteBundle\Entity\Volunteer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hospice_sitebundle_volunteer';
    }
}
