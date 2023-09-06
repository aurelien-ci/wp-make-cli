## WP CLI make command for theme development

This is a work-in-progress version only working with our theme structure which will change soon.
This package will evolve to be useable by any WordPress theme developer.
This package is mostly inspired by Laravel built in php artisan make command.

## Supported commands

* `wp make:block bloc-name --nicename="Bloc name"` -- Create a php file in theme directory, a block.json file and a .scss file

## Installing

If you're using WP-CLI v0.23.0 or later, you can install this package with:

`wp package install https://gitlab.com/chantiers/wp-make-cli.git`