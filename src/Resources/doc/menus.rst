### Top bar

To create a top bar, just create your KNP Menu, add a route to the root element and set extra options:

```php
$menu = $this->factory->createItem(
    'My website',
    [
        'route' => 'homepage',
        'extras' => ['menu_type' => 'topbar']
    ]
);
```

ADD USUALL

ADD SIDEBAR
ADD SIDEBAR WITH NESTED


### Menu entries with icons

You can add an icon before, after or instead of the label. By default the icon will be added before the label.
The icon must be the name of one of Font-Awesome, example : "fa-bell-o".

```php
$menu->addChild(
    "Entry",
    [
        'route' => 'route_entry',
        'extras' => [
            'icon' => 'fa-bell-o',
            'icon_position' => 'no-label' # can be 'before', 'after' or 'no-label'
        ]
    ]
);
```

### Breadcrumb

If you want a breadcrumb generated from a KNP Menu add this code in your template :

```Twig
{{ flob_foundation_breadcrumb_render('yourknpmenu') }}
```

If you want a specific template :

```Twig
{{ flob_foundation_breadcrumb_render('yourknpmenu', {'template' : 'YourBundle:YourFolder:breadcrumbtemplate.html.twig') }}
```
