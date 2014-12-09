<?php

namespace Flob\Bundle\FoundationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ButtonBarType
 *
 * Adds support for button_bars, groups of button_groups.
 *
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
class ButtonBarType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add all the child button groups
        foreach ($options['button_groups'] as $name => $config) {
            $builder->add($name, 'button_group', $config);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'button_groups' => array(),
                'options'       => array(),
                'mapped'        => false,
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'button_bar';
    }
}
