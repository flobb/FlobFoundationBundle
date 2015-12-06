<?php

namespace Flob\Bundle\FoundationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Button;
use Symfony\Component\Form\ButtonBuilder;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ButtonGroupType extends AbstractType
{
    private $allowedTypes = [
        ButtonType::class,
        SubmitType::class,
    ];

    /**
     * Pull all buttons into the form.
     *
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['buttons'] as $name => $config) {
            $this->addButton($builder, $name, $config);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if ($form->count() === 0) {
            return;
        }

        array_map([$this, 'validateButton'], $form->all());
    }

    /**
     * Adds a button.
     *
     * @param FormBuilderInterface $builder
     * @param $name
     * @param $config
     *
     * @throws \InvalidArgumentException
     *
     * @return ButtonBuilder
     */
    protected function addButton($builder, $name, $config)
    {
        $options = isset($config['options']) ? $config['options'] : [];

        if (!in_array($config['type'], $this->allowedTypes)) {
            throw new \LogicException(sprintf(
                'Allowed button types : "%s", given "%s".',
                implode('", "', $this->allowedTypes),
                $config['type']
            ));
        }

        return $builder->add($name, $config['type'], $options);
    }

    /**
     * Validates if child is a Button.
     *
     * @param FormInterface $field
     *
     * @throws \InvalidArgumentException
     */
    protected function validateButton(FormInterface $field)
    {
        if (!$field instanceof Button) {
            throw new \InvalidArgumentException('Children of ButtonGroupType must be instances of the Button class');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'buttons' => [],
                'options' => [],
                'mapped' => false,
            ]
        );
    }
}
