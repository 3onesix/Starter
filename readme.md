# Templates
Found in assets/site/templates, each template consists of two (2) files: the template and the template config. If the template is named `homepage.php`, the matching config should be `homepage.config.php`.

# Template Config

```php
<?php

$template = array();

$template['name'] = 'Homepage'; //readable name for page
$template['modules'] = array('blog'); //required modules for page
$template['variables'] = array(); //template variables (see below)
```

# Template Config: Variables
## String
Simple, one line editor field (text input)

**Example Code**

```php
<?php
$template['variables'] = array(
    array(
        'type' => 'string',
        'name' => 'headline',
        'label' => 'Headline',
        'default' => 'Lorem Ipsum'
    )
);
?>
```

String variables also allow options, giving the user a dropdown to select from.

**Example Code**

```php
<?php
$template['variables'] = array(
    array(
        'type' => 'string',
        'name' => 'background_color',
        'label' => 'Background Color',
        'options' => array('blue', 'red', 'green')
    )
);
?>
```

## Binary
Multi-line editor field (textarea)

**Example Code**

```php
<?php
$template['variables'] = array(
    array(
        'type' => 'binary',
        'name' => 'copy',
        'label' => 'Body Copy',
        'default' => 'Donec id elit non mi porta gravida at eget metus. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.'
    )
);
?>
```

## HTML
Multi-line rich text field (WYSIWYG)

**Example Code**

```php
<?php
$template['variables'] = array(
    array(
        'type' => 'html',
        'name' => 'copy',
        'label' => 'Body Copy',
        'default' => '<strong>Donec id elit non</strong> mi porta gravida at eget metus. Duis mollis, est non commodo luctus, <em>nisi erat</em> porttitor ligula, eget lacinia odio sem nec elit.'
    )
);
?>
```

## Array
Can contain any of the above, produces a repeatable set of field.

**Example Code**

```php
<?php
$template['variables'] = array(
    array(
        'type' => 'array',
        'name' => 'contacts',
        'label' => 'Contacts',
        'limit' => 20,
        'variables' => array(
            array(
                'type'  => 'string',
                'name'  => 'title',
                'label' => 'Title',
                'options' => array('Mr.', 'Mrs.', 'Ms.')
            ),
            array(
                'type'  => 'string',
                'name'  => 'name',
                'label' => 'Name'
            )
        )
    )
);
?>
```

# The Template
```php
<!doctype html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>My Wonderful Website</title>
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
    </head>
    <body lang="en" style="background-color: <?=$background_color?>;">
        
        <!-- the magic //-->
        <h1><?=$headline?></h1>
        <p><?=$copy?></p>
        
    </body>
</html>
```

# Template Partials
Template partials are great for repeated content across a site, such as a header or footer. To create one, prefix the name with an underscore (eg. `_header.php`). This will prevent it from being stored in the database, and will waive the requirement for a template config file.