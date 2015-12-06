<?php

namespace Flob\Bundle\FoundationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            $builder->add($name, ButtonGroupType::class, $config);
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
}
