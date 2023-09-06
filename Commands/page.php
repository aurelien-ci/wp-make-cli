<?php

if (!defined('WP_CLI') || !WP_CLI) {
      exit;
}

require_once dirname(__FILE__, 2) . '/Traits/MakeTrait.php';

class MakePage_Command
{
      /**
       * Create a page template in the theme directory ans a scss file in /scss/pages.
       *
       * ## OPTIONS
       *
       * <name>
       * : The name of the template.
       * 
       * [--nicename=<nicename>]
       * : The nicename of the template for wp-admin
       * 
       * [--js]
       * : create a javascript file
       * 
       * [--no-css]
       * : do NOT create a scss file
       *
       * ## EXAMPLES
       *
       *     wp make:page agency
       *     wp make:page about-us --nicename="Page à propos" --js
       *
       * @when after_wp_load
       */

      use MakeTrait;

      protected string $type = 'page';

      public function __invoke($args, $assoc_args)
      {
            $this->createFiles($args, $assoc_args);
      }
}

WP_CLI::add_command('make:page', 'MakePage_Command');
