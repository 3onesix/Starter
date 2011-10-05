# Starter

## Templates
Found in assets/site/templates, each template consists of two (2) files: the template and the template config. If the template is named `homepage.php`, the matching config should be `homepage.config.php`.

### Template Variables
#### Types
##### String
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

##### Binary
Multi-line editor field (textarea)

**Example Code**
```php
<?php
$template['variables'] = array(
    array(
        'type' => 'binary',
        'name' => 'headline',
        'label' => 'Headline',
        'default' => 'Donec id elit non mi porta gravida at eget metus. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.'
    )
);
?>
```

##### HTML
Multi-line rich text field (WYSIWYG)

**Example Code**
```php
<?php
$template['variables'] = array(
    array(
        'type' => 'html',
        'name' => 'headline',
        'label' => 'Headline',
        'default' => '<strong>Donec id elit non</strong> mi porta gravida at eget metus. Duis mollis, est non commodo luctus, <em>nisi erat</em> porttitor ligula, eget lacinia odio sem nec elit.'
    )
);
?>
```

##### Array
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

### Template Partials
Template partials are great for repeated content across a site, such as a header or footer. To create one, prefix the name with an underscore (eg. `_header.php`). This will prevent it from being stored in the database, and will waive the requirement for a template config file.