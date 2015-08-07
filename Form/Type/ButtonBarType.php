<?php

namespace Flob\Bundle\FoundationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ButtonBarType.
 *
 * Adds support for button_bars, groups of button_groups.
 *
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
class ButtonBarType extends AbstractType
{
    /**
     * Pull all group of button into the form.
     *
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['button_groups'] as $name => $config) {
            $builder->add($name, 'button_group', $config);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'button_groups' => [],
                'options' => [],
                'mapped' => false,
            ]
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
