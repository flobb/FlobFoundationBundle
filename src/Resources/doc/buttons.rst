### Button Group (form field type)

You can now use [button groups](http://foundation.zurb.com/docs/components/button_groups.html) in your forms.

Button groups are button, grouped together by Foundation. This way they are rendered on the same line, instead of all on a different row.

This is an example of the field :
```Php
$builder->add(
    'buttons',
    'button_group',
    [
        'label' => 'Buttons group',
        'buttons' => [
            'back' => [
                'type'    => 'button',
                'options' => [
                    'label' => 'Cancel',
                    'attr' => [
                        'class' => 'secondary',
                    ],
                ],
            ],
            'save' => [
                'type'    => 'submit',
                'options' => [
                    'label' => 'Submit',
                ],
            ],
        ],
        'attr' => [
            'class' => 'right',
        ],
    ]
);
```

In the `buttons` array, you define the buttons that need to be rendered. All the buttons should be of FormType `ButtonType`.
For the `ButtonType`, you cannot specify behavior in [Symfony](http://symfony.com/doc/current/reference/forms/types/button.html).
You can change the type to `reset` , to render a button with `type="reset"`, (a `ResetType`) but cannot add links.

However, you have various options:
* add an `onClick` tag to the `attr` array
* add a class `link`, a tag `data-url` to the `attr` array and let JavaScript handle it

### Button Bar (form field type)

A button bar is a group of button groups, perfect for situations where you want groups of actions that are all related to a similar element or page.

This is an (long :D) example of the field :
```Php
$builder->add(
    'button_bar',
    'button_bar',
    [
        'button_groups' => [
            'button_group_first' => [
                'label' => 'Buttons group',
                'buttons' => [
                    'one' => [
                        'type'    => 'submit',
                        'options' => [
                            'label' => 'one',
                        ],
                    ],
                    'two' => [
                        'type'    => 'button',
                        'options' => [
                            'label' => 'two',
                            'attr' => [
                                'class' => 'success',
                            ],
                        ],
                    ],
                    'three' => [
                        'type'    => 'button',
                        'options' => [
                            'label' => 'three',
                            'attr' => [
                                'class' => 'alert',
                            ],
                        ],
                    ],
                ],
                'attr' => [
                    'class' => 'round',
                ],
            ],
            'button_group_second' => [
                'label' => 'Buttons group',
                'buttons' => [
                    'four' => [
                        'type'    => 'button',
                        'options' => [
                            'label' => 'four',
                            'attr' => [
                                'class' => 'disabled',
                            ],
                        ],
                    ],
                    'five' => [
                        'type'    => 'button',
                        'options' => [
                            'label' => 'five',
                            'attr' => [
                                'class' => 'secondary',
                            ],
                        ],
                    ],
                    'six' => [
                        'type'    => 'button',
                        'options' => [
                            'label' => 'six',
                            'attr' => [
                                'class' => 'secondary',
                            ],
                        ],
                    ],
                ],
                'attr' => [
                    'class' => 'radius',
                ],
            ],
        ],
    );
```
