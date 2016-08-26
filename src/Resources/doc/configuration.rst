### Configuration

**This bundle does not theme any elements by default**, in case you want to use Foundation on a specific form or bundle.

To automatically theme forms or other elements by default, go into the `app/config/config.yml` and add at the end:

```YAML
flob_foundation:
    theme: { form: true, knp_menu: true, knp_paginator: true, pagerfanta: true }
```

If you want to do specific HTML markup that extends templates of this bundle:
* create your template in your bundle
* add `{% extends 'FlobFoundationBundle:Form:foundation_form_div_layout.html.twig' %}` at the top (the form template, for example)
* edit the `app/config/config.yml`:

```YAML
flob_foundation:
    theme: { form: true, knp_menu: true, knp_paginator: true, pagerfanta: true }
    template:
        form: 'YourBundle:YourFolder:formtemplate.html.twig'
        breadcrumb: 'YourBundle:YourFolder:breadcrumbtemplate.html.twig'
        knp_menu: 'YourBundle:YourFolder:menutemplate.html.twig'
        knp_paginator: 'YourBundle:YourFolder:paginatortemplate.html.twig'
        pagerfanta: 'YourPagerFantaTemplate'
```

However instead of setting it in the configuration, you can theme specific elements using one of these methods:

```Twig
{# Form #}
{% form_theme yourform 'FlobFoundationBundle:Form:foundation_form_div_layout.html.twig' %}

{# Menu #}
{{ knp_menu_render('yourmenu', {'template' : 'FlobFoundationBundle:Menu:foundation_knp_menu.html.twig'}) }}

{# Pagination with KNP paginator #}
{{ knp_pagination_render(yourpagination, 'FlobFoundationBundle:Pagination:foundation_sliding.html.twig') }}

{# Pagination with PagerFanta (through WhiteOctober bundle) #}
{{ pagerfanta(paginationFanta, 'foundation') }}
