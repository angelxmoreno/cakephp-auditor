# Auditor plugin for CakePHP

## Requirements

    * CakePHP 3.4.0+
    * PHP 5.6+

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```bash
composer require angelxmoreno/cakephp-auditor
```

Then you need to apply two behaviors:

1. One on your UsersTable ( the Auditors )
```php
$this->addBehavior('Auditor.Auditor');
```

2. Another on your tables you with to track
```php
$this->addBehavior('Auditor.Audit');
```

## Options

For the AuditBehavior you have the following default options:

```php
[
    'attach'      => true,
    'reverse'     => false,
    'skip_fields' => [],
]
```

### attach: Boolean ( default true)
Whether or not the behavior should attach the given table to the AuditsTable as a HasMany association 

### reverse: Boolean ( default false)
Whether or not the behavior should attach the AuditsTable to the given table as a belongsTo association 


### skip_fields: Array ( default empty array)
The fields that should be ignored when saving the diff of the `previous` and `current` fields.

[ It is recommended to add your `created` and `modified` fields] 

## Extras

I personally use a BaseTable and extend all my Table classes from that. It makes it easier to add traits, methods and other
goodies to all my Table classes. I created a convenience method to conditionally add the Audit behavior when the Table class
is not the AuditsTable. You can make use of it like so:

```php
\Auditor\Model\Behavior\AuditBehavior::makeAuditable($this, [
    'attach'      => false,
    'skip_fields' => ['modified', 'created'],
]);
```

# License

Copyright 2018 Angel S. Moreno (angelxmoreno). All rights reserved.

Licensed under the [MIT](http://www.opensource.org/licenses/mit-license.php) License. Redistributions of the source code included in this repository must retain the copyright notice found in each file.
