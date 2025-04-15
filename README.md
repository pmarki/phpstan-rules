# PHPStan Rules
Set of additional PHPStan rules

*For legacy codebase*
- check if property and constant shouldn't be set as protected (when is not inherited or class is not abstract)
- check if property name starts with underscore
- check if constant name is uppercase

*PHPMD rules*
- check for boolean argument flag
- more coming soon ...

## Installation

Run `composer require --dev pmarki/phpstan-rules`

Edit your phpstan configuration file and add 

```
includes:
    - vendor/pmarki/phpstan-rules/extension.neon
```