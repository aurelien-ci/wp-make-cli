<?php

if (!defined('WP_CLI') || !WP_CLI) {
      exit;
}

require_once dirname(__FILE__, 2) . '/Traits/MakeTrait.php';

class MakePartial_Command
{
      /**
       * Create a partial template in the /partials theme directory ans a scss file in /scss/components.
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
       *     wp make:partial header-nav
       *     wp make:partial news-item --nicename="Dalle actualité" --js
       *
       * @when after_wp_load
       */

      use MakeTrait;

      protected string $type = 'partial';

      public function __invoke($args, $assoc_args)
      {
            $this->createFiles($args, $assoc_args);
      }
}

WP_CLI::add_command('make:partial', 'MakePartial_Command');
