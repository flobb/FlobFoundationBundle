# [Foundation Bundle](https://github.com/florianbelhomme/FoundationBundle)

By [Florian Belhomme](http://florianbelhomme.com)

## About

This bundle integrates the functionnalities of the responsive framework Foundation, from Zurb (thanks guys), into Symfony2 by providing templates, Twig extensions, services and commands.
You can quickly setup a responsive theme for a frontend, or backend, interface for your projet on top of it. It will have the "look'n'feel" and the simplicity of Foundation.

**BE AWARE : THIS BUNDLE WILL NOT ADD FOUNDATION FRAMEWORK BUT FUNCTIONNALITIES TO SYMFONY TO WORK WITH**

To include Foundation & Modernizer you can use the [CloudFlare CDN](http://cdnjs.com/libraries/foundation/).
This bundle use icon from Font Awesome, to add it you can use the [bootstrapcdn](http://www.bootstrapcdn.com).

## Requirements

- [Symfony 2.3+](http://symfony.com).
- [Foundation 5+](http://foundation.zurb.com/) and advanced reponsive frontend.
- [Font Awesome 4.0+](http://fontawesome.io/) which comes with 369+ icons.

## Recommended

- the [KnpMenuBundle](https://github.com/KnpLabs/KnpMenuBundle) for menus, this bundle theme them for you.
- the [KpnPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle) for pagination, this bundle theme them for you.

## Installation and configuration

First, edit your `composer.json` and add :

```JSON
{
    ...
    "require": {
        ...
        "florianbelhomme/foundation-bundle" : "1.0"
        ...
    }
    ...
}
```

Now run a `composer update` on your project. It will get you all needed files.

Secondly, edit your `app/AppKernel.php` and add :

```PHP
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            ...
            new FlorianBelhomme\Bundle\FoundationBundle\FlorianBelhommeFoundationBundle();
            ...
        );
    }
}
```

You know need to add Foundation and Font Awesome to your project.
There the easy way to do it (but there is other way to do so) :

```HTML
<html>
    <head>
        ...
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.0.2/css/normalize.min.css" type="text/css" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.0.2/css/foundation.min.css" type="text/css" />
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" type="text/css" />
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.min.js"></script>
        ...
    </head>
    <body>
        ...
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.0.2/js/foundation.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $(document).foundation();
            });
        </script>
    </body>
</html>
```

Your project is ready!

## Configuration & Usage

**The bundle does not theme elements by default** in case of you want to use Foundation on specific form or bundle.

To automatically theme form or other elements by defaut, go in the `app/config/config.yml` and add at the end :

```YAML
fb_foundation:
    theme: { form: true, knp_menu: true, knp_paginator: true }
```

If you want to do specifics HTML markup that extends templates of this bundle :
* create your template in your bundle
* add `{% extends 'FlorianBelhommeFoundationBundle:Form:foundation_form_div_layout.html.twig' %}` at the top (for the form template by exemple)
* edit the  `app/config/config.yml` :

```YAML
fb_foundation:
    theme: { form: true, knp_menu: true, knp_paginator: true }
    template: { form: 'YourBundle:YourFolder:formtemplate.html.twig', knp_menu: 'YourBundle:YourFolder:menutemplate.html.twig', knp_paginator: 'YourBundle:YourFolder:paginatortemplate.html.twig' }
```

But you can theme specific elements using those way :
```Twig

{% form_theme yourform 'FlorianBelhommeFoundationBundle:Form:foundation_form_div_layout.html.twig' %}
{{ knp_menu_render('yourmenu', {'template' : 'FlorianBelhommeFoundationBundle:Menu:foundation_knp_menu.html.twig'}) }}
{{ knp_pagination_render(yourpagination, 'FlorianBelhommeFoundationBundle:Pagination:foundation_sliding.html.twig') }}
```

## Feedback

**Please provide feedback!**
We want to make this bundle useful in as many projects as possible.

Actively maintained by [Florian Belhomme](http://florianbelhomme.com).

## License

- This project is licensed under the [MIT License](http://opensource.org/licenses/MIT)
- Foundation is licensed under the [MIT License](http://opensource.org/licenses/MIT)
- The Font Awesome, by Dave Gandy, is licensed by [SIL OFL 1.1 Licence](http://scripts.sil.org/OFL) and his sources files by the [MIT License](http://opensource.org/licenses/mit-license.html)

