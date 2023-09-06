<?php

if (!defined('WP_CLI') || !WP_CLI) {
	exit;
}

require_once dirname(__FILE__, 2) . '/Traits/MakeTrait.php';

class MakeTaxonomy_Command
{
	/**
	 * Create a taxonomy template in the theme directory ans a scss file in /scss/pages.
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
	 *     wp make:taxonomy book-tags
	 *     wp make:taxonomy news-cats --nicename="Catégorie d'actualité" --js
	 *
	 * @when after_wp_load
	 */

	use MakeTrait;

	protected string $type = 'taxonomy';

	public function __invoke($args, $assoc_args)
	{
		$this->createFiles($args, $assoc_args);
	}
}

WP_CLI::add_command('make:taxonomy', 'MakeTaxonomy_Command');
