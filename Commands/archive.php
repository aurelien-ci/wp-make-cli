<?php

if (!defined('WP_CLI') || !WP_CLI) {
	exit;
}

require_once dirname(__FILE__, 2) . '/Traits/MakeTrait.php';

class MakeArchive_Command
{
	/**
	 * Create both archive AND single template in the theme directory and a scss file in /scss/pages.
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
	 * [--no-single]
	 * : create only archive file
	 *
	 * ## EXAMPLES
	 *
	 *     wp make:archive books
	 *     wp make:archive news --nicename="Archive des actualités" --js
	 *
	 * @when after_wp_load
	 */

	use MakeTrait;

	protected string $type = 'archive';

	public function __invoke($args, $assoc_args)
	{
		$this->createFiles($args, $assoc_args);

		if ($assoc_args['single'] ?? true) {
			list($name) = $args;

			$nicename = $assoc_args['nicename'] ?? false;

			$js = $assoc_args['js'] ?? false;

			WP_CLI::runcommand(
				sprintf(
					'make:single %1$s%2$s%3$s',
					$name,
					($nicename ? ' --nicename="' . $nicename . '"' : ''),
					($js ? ' --js' : '')
				)
			);
		}
	}
}

WP_CLI::add_command('make:archive', 'MakeArchive_Command');
