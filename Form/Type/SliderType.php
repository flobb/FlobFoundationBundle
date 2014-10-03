<?php

namespace FlorianBelhomme\Bundle\FoundationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SliderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        foreach (array('start', 'end', 'step') as $o) {

            if (!isset($options[$o])) {
                throw new LogicException('The option "'.$o.'" must be set.');
            }

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
        foreach (array('start', 'end', 'step') as $o) {
            $view->vars[$o] = $options[$o];
        }

        if ($options['vertical']) {
            $view->vars['vertical'] = 1;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'start'    => 0,
            'end'      => 100,
            'step'     => 1,
            'vertical' => false
        ));
    }

    public function getParent()
    {
        return 'number';
    }

    public function getName()
    {
        return 'slider';
    }
}
