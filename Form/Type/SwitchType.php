<?php

namespace Flob\Bundle\FoundationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SwitchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        if (!$options['expanded']) {
            throw new LogicException('The option "expanded" cannot the set to false, use the choice field instead.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'expanded' => true,
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'switch';
    }
}
