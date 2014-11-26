# [Flob Foundation Bundle](https://github.com/florianbelhomme/FlobFoundationBundle)

By [Florian Belhomme](http://florianbelhomme.com)

[![Total Downloads](https://poser.pugx.org/florianbelhomme/flob-foundation-bundle/downloads.svg)](https://packagist.org/packages/florianbelhomme/flob-foundation-bundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/4ffe439b-5a0c-4caa-914e-005d21591c3d/mini.png)](https://insight.sensiolabs.com/projects/4ffe439b-5a0c-4caa-914e-005d21591c3d)

## About

This bundle integrates the functionalities of the responsive framework Foundation, from ZURB (thanks guys), into Symfony by providing templates, Twig extensions, services and commands. You can quickly setup a responsive theme for an interface for your project. It will have the "look'n'feel", the responsiveness and the simplicity of Foundation.

**BE AWARE: THIS BUNDLE WILL NOT ADD THE FOUNDATION FRAMEWORK BUT RATHER FUNCTIONALITIES FOR SYMFONY TO WORK WITH IT**

To include all the libraries you can use a CDN like [CloudFlare CDN](http://cdnjs.com/).

## Requirements

- [Symfony 2.3+](http://symfony.com).
- [jQuery 2+](http://jquery.com/) a JavaScript library.
- [Foundation 5+](http://foundation.zurb.com/) an advanced responsive framework.
- [Font Awesome 4+](http://fontawesome.io/) which comes with 369+ icons.

## Recommended

- the [KnpMenuBundle](https://github.com/KnpLabs/KnpMenuBundle) for menus, this bundle can theme them for you.
- the [KpnPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle) for pagination, this bundle can theme them for you.

## Installation and configuration

First, edit your `composer.json` and add :

```JSON
{
    ...
    "require": {
        ...
        "florianbelhomme/flob-foundation-bundle" : "~2.0"
        ...
    }
    ...
}
```

Now run a `composer update` on your project. It will get all the necessary files for you.

Secondly, edit your `app/AppKernel.php` and add:

```PHP
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            ...
            new Flob\Bundle\FoundationBundle\FlobFoundationBundle(),
            ...
        );
    }
}
```

You now need to add the libraries to your project.

The easy way to do it (but there are other ways to do so):

```HTML
<html>
    <head>
        ...
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.4.5/css/normalize.min.css" type="text/css" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.4.5/css/foundation.min.css" type="text/css" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" />
        <link rel="stylesheet" href="{{ asset('bundles/flobfoundation/css/foundationtosymfony.css') }}" type="text/css" />
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
        ...
    </head>
    <body>
        ...
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.4.5/js/foundation.min.js"></script>
        <script type="text/javascript" src="{{ asset('bundles/flobfoundation/js/foundationtosymfony.js') }}"></script>
    </body>
</html>
```

Your project is ready!

## Configuration

**This bundle does not theme any elements by default**, in case you want to use Foundation on a specific form or bundle.

To automatically theme forms or other elements by default, go into the `app/config/config.yml` and add at the end:

```YAML
flob_foundation:
    theme: { form: true, knp_menu: true, knp_paginator: true }
```

If you want to do specific HTML markup that extends templates of this bundle:
* create your template in your bundle
* add `{% extends 'FlobFoundationBundle:Form:foundation_form_div_layout.html.twig' %}` at the top (the form template, for example)
* edit the `app/config/config.yml`:

```YAML
flob_foundation:
    theme: { form: true, knp_menu: true, knp_paginator: true }
    template: { form: 'YourBundle:YourFolder:formtemplate.html.twig', breadcrumb: 'YourBundle:YourFolder:breadcrumbtemplate.html.twig', knp_menu: 'YourBundle:YourFolder:menutemplate.html.twig', knp_paginator: 'YourBundle:YourFolder:paginatortemplate.html.twig' }
```
## Usage

### Theme

However instead of setting it in the configuration, you can theme specific elements using one of these methods:

```Twig
{# Form #}
{% form_theme yourform 'FlobFoundationBundle:Form:foundation_form_div_layout.html.twig' %}

{# Menu #}
{{ knp_menu_render('yourmenu', {'template' : 'FlobFoundationBundle:Menu:foundation_knp_menu.html.twig'}) }}

{# Pagination #}
{{ knp_pagination_render(yourpagination, 'FlobFoundationBundle:Pagination:foundation_sliding.html.twig') }}
```

### Breadcrumb

If you want a breadcrumb generated from a KNP Menu :

* Make sure that your menu builder get the current URI by adding this :

```Php
public function createMyMenu(Request $request)
{
    $menu = $this->factory->createItem('Home', array('route' => 'homepage')));

    // ... Add entries here ...

    $menu->setCurrentUri($request->getBaseUrl().$request->getPathInfo());

    return $menu;
}
```

* Then add this code in your template :

```Twig
{{ flob_foundation_breadcrumb_render('yourknpmenu') }}
```

If you want a specific template :

```Twig
{{ flob_foundation_breadcrumb_render('yourknpmenu', {'template' : 'YourBundle:YourFolder:breadcrumbtemplate.html.twig') }}
```

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
$builder->add('My slider', 'slider', array('label' => 'Slider', 'start' => 10, 'end' => 20, 'step' => 2));
```

### Switch (form field type)

You can now use the switch in your forms.

The switch extend the [choice field type](http://symfony.com/doc/current/reference/forms/types/number.html), so it have the same options. But you can't set the option "expanded" to false (cannot be a select).

This is an example of the field :
```Php
$builder->add('switch_radio', 'switch', array('label' => 'Switch (as radio)', 'choices' => array(1 => 'Choice 1', 2 => 'Choice 2', 3 => 'Obi wan kenobi'), 'multiple' => false));
```

### Button Groups (form field type)

You can now use button groups in your forms.

Button groups are button, grouped together by [Foundation](http://foundation.zurb.com/docs/components/button_groups.html). This way they are rendered on the same line, instead of all on a different row.

This is an example of the field :
```Php
$builder->add(
    'buttons',
    'button_group',
    array(
        'buttons' => array(
            'save' => array(
                'type'    => 'submit',
                'options' => array(
                    'label' => 'Submit',
                ),
            ),
            'back' => array(
                'type'    => 'button',
                'options' => array(
                    'label' => 'Cancel',
                    'attr' => array(
                        'class' => 'secondary',
                    ),
                ),
            ),
        ),
        options => array(
            'class' => 'radius',
        ),
    )
);
```

In the `buttons` array, you define the buttons that need to be rendered. All the button should be of FormType `ButtonType`.


## Changelog

v2
- namespace renaming
- rework the twig form template

## TODO

- [ ] better file upload fields
- [ ] be abide validation compliant
- [ ] buttonmania
- [ ] alerts (via embed)
- [ ] tabs (via ... that a good question)
- [ ] equalizer
- [ ] thumbnails

Maybe :
- [ ] progress bar
- [ ] clearing lightbox
- [ ] be aria compliant

## Feedback

**Please provide feedback!**
We want to make this bundle useful in as many projects as possible.

Maintained by [Florian Belhomme](http://florianbelhomme.com).

## License

- This bundle is licensed under the [MIT License](http://opensource.org/licenses/MIT)
