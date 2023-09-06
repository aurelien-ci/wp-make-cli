<?php

if (!defined('WP_CLI') || !WP_CLI) {
      exit;
}

require_once dirname(__FILE__, 2) . '/Traits/MakeTrait.php';

class MakeBlock_Command
{
      /**
       * Create a block component in the /blocks theme directory and a scss file in /scss/blocks.
       *
       * ## OPTIONS
       *
       * <name>
       * : The name of the component.
       * 
       * [--nicename=<nicename>]
       * : The nicename of the component for wp-admin
       * 
       * [--js]
       * : create a javascript file
       * 
       * [--no-css]
       * : do NOT create a scss file
       *
       * ## EXAMPLES
       *
       *     wp make:block bloc-video
       *     wp make:block bloc-crosslink --nicename="Bloc Maillage interne" --js
       *
       * @when after_wp_load
       */

      use MakeTrait;

      protected string $type = 'block';

      public function __invoke($args, $assoc_args)
      {
            $this->createFiles($args, $assoc_args);
      }
}

WP_CLI::add_command('make:block', 'MakeBlock_Command');
