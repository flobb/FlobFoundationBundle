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

        if (!isset($options['start'])) {
            throw new LogicException('The option "start" must be set.');
        }

        if (!is_numeric($options['start'])) {
            throw new LogicException('The option "start" must be numeric.');
        }

        if (!isset($options['end'])) {
            throw new LogicException('The option "end" must be set.');
        }

        if (!is_numeric($options['end'])) {
            throw new LogicException('The option "end" must be numeric.');
        }

        if (!isset($options['step'])) {
            throw new LogicException('The option "step" must be set.');
        }

        if (!is_numeric($options['step'])) {
            throw new LogicException('The option "step" must be numeric.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['start'] = $options['start'];
        $view->vars['end'] = $options['end'];
        $view->vars['step'] = $options['step'];
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'start' => 0,
            'end'   => 100,
            'step'  => 1
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