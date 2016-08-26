### Slider (form field type)

You can now use the slider in your forms.

The slider extend the [number field type](http://symfony.com/doc/current/reference/forms/types/number.html), so it has the same options.
The additional options are :
* start :
type: integer / default: 0
This specifies the starting point number.
* end :
type: integer / default: 100
This specifies the highest number in the range.
* step :
type: integer / default: 1
This specifies the cursor's incremental skip.
* vertical :
type: boolean / default: false
If true, displays the slider vertically instead of horizontally.

This is an example of the field :
```Php
$builder->add('My slider', 'slider', ['label' => 'Slider', 'start' => 10, 'end' => 20, 'step' => 2]);
```

### Switch (form field type)

You can now use the switch in your forms.

The switch extend the [choice field type](http://symfony.com/doc/current/reference/forms/types/number.html), so it have the same options. But you can't set the option "expanded" to false (cannot be a select).

This is an example of the field :
```Php
$builder->add('switch_radio', 'switch', ['label' => 'Switch (as radio)', 'choices' => [1 => 'Choice 1', 2 => 'Choice 2', 3 => 'Obi wan kenobi'], 'multiple' => false]);
```
