<?php

namespace Flob\Bundle\FoundationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SliderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        foreach (['start', 'end', 'step'] as $o) {
            if (!is_numeric($options[$o])) {
                throw new LogicException('The option "'.$o.'" must be numeric.');
            }
        }

        if (!is_bool($options['vertical'])) {
            throw new LogicException('The option "vertical" must be a boolean.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        foreach (['start', 'end', 'step'] as $o) {
            $view->vars[$o] = $options[$o];
        }

        if ($options['vertical']) {
            $view->vars['vertical'] = 1;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'start',
            'end',
            'step',
            'vertical',
        ]);
        $resolver->setDefaults([
            'start' => 0,
            'end' => 100,
            'step' => 1,
            'vertical' => false,
        ]);
    }

    public function getParent()
    {
        return NumberType::class;
    }
}
