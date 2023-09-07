## WP CLI make command for theme development

This is a work-in-progress version only working with Concept Image agency theme structure which will change soon.
This package will evolve to be useable by any WordPress theme developer.
This package is mostly inspired by Laravel built in php artisan make command.

## Supported commands

* `wp make:block bloc-name --nicename=<nicename> --js=<true|false>" --no-css=<false|true>` -- Create a block folder with php file and block.json file in theme blocks/ directory, a .scss file and a js file if the flag --js is present
* `wp make:page name --nicename=<nicename> --js=<true|false>" --no-css=<false|true>` -- Create a page-<name>.php file in theme directory, a .scss file and a js file if the flag --js is present
* `wp make:partial name --nicename=<nicename> --js=<true|false>" --no-css=<false|true>` -- Create a php partial file in theme partials/ directory, a .scss file and a js file if the flag --js is present
* `wp make:archive post-type-name --nicename=<nicename> --js=<true|false>" --no-css=<false|true>` -- Create a php archive-<post-type>.php file for given post type in theme  directory, a .scss file and a js file if the flag --js is present, also launch the make:single command unless the flag --no-single is present
* `wp make:single post-type-name --nicename=<nicename> --js=<true|false>" --no-css=<false|true>` -- Create a single-<post-type>.php file for given post type in theme  directory, a .scss file and a js file if the flag --js is present
* `wp make:taxonomy term-name --nicename=<nicename> --js=<true|false>" --no-css=<false|true>` -- Create a taxonomy-<term-name>.php file for given taxonomy in theme  directory, a .scss file and a js file if the flag --js is present

## Examples

* `wp make:archive book --nicename="Livre"`
* `wp make:block block-crosslink --nicename="Bloc maillage interne" --js`

## Installing

If you're using WP-CLI v0.23.0 or later, you can install this package with:

`wp package install https://github.com/aurelien-ci/wp-make-cli.git`