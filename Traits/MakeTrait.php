<?php

if ( !defined( 'WP_CLI' ) || !WP_CLI ) {
	exit;
}

trait MakeTrait
{
	protected string $src_path = '../src/theme/';

    private function camelize($input, $separator = '_') : string
    {
        return lcfirst(str_replace($separator, '', ucwords($input, $separator)));
    }

	private function isWpTemplate( string $type ) : bool
	{
		return in_array($type, ['single', 'archive', 'page', 'taxonomy']);
	}

	//Open stub file
    private function getStubContents(string $stub_name, string $name, string $nicename) : string
    {
        $stub_filename = realpath(dirname(__FILE__, 2)) . '/Stubs/'.$stub_name.'.stub';

        if(!file_exists($stub_filename)) {
            WP_CLI::error( sprintf( 'Impossible d\'ouvrir le template à écrire dans le nouveau fichier.', $name ) );
        }

        $stub = fopen($stub_filename, 'r');
        $stub_contents = fread($stub, filesize($stub_filename));
        fclose($stub);

        $stub_contents = str_replace('%name%', $name, $stub_contents);
        $stub_contents = str_replace('%nicename%', $nicename, $stub_contents);

        $stub_contents = str_replace('%%', '@@', $stub_contents);

        return $stub_contents;
    }

	//Create a scss file with top class in camel case
	private function createStyleFile(string $type, string $name) : void
    {
        if( $this->isWpTemplate( $type ) ) {
            $name = $type . ucfirst($name);
        }

        $scss_path = $this->src_path . 'sass' . $this->getStyleDirectory( $type ) . '/_' . $name . '.scss';

        if(file_exists($scss_path)) {
            WP_CLI::warning( sprintf( 'La feuille de style _%s.scss existe déjà !', $name ) );
        }

        $scss_file = fopen($scss_path, 'w') or die('Unable to create file!');
        fwrite(
            $scss_file, 
            sprintf('.%s { ' . PHP_EOL . '    ' . PHP_EOL . '}', $name)
        );
        fclose($scss_file);

		WP_CLI::line( WP_CLI::colorize( "%YMake%n file %C_{$name}.scss%n" ) );
    }

	//Create a javascript file with basic export declaration
    private function createScriptFile(string $type, string $name) : void
    {
		if( $this->isWpTemplate( $type ) ) {
            $name = $type . ucfirst($name);
        }

        $js_path = $this->src_path . 'js/src/' . $name . '.js';

        if(file_exists($js_path)) {
            WP_CLI::warning( sprintf( 'Le script %s.js existe déjà !', $name ) );
        }

        $js_file = fopen($js_path, 'w') or die('Unable to create file!');
        $text = sprintf('\'use strict\';' . PHP_EOL . PHP_EOL . 'const %1$s = () => {' . PHP_EOL . PHP_EOL . '    ' . PHP_EOL . PHP_EOL . '}' . PHP_EOL . PHP_EOL . 'export default %1$s', $name);
        fwrite(
            $js_file, 
            $text
        );
        fclose($js_file);

		WP_CLI::line( WP_CLI::colorize( "%YMake%n file %C{$name}.js%n" ) );
    }

	//create folder if not exists
    private function createTemplateFolder(string $folder) : void
    {
        $folder_path = $this->src_path . 'wp_files/' . $folder;

        if(!is_dir($folder_path)) {
            mkdir($folder_path);
        }
    }

	//Get directory for template
    private function getTemplateDirectory(string $type, string $name = '') : string
    {
		switch ($type) {

			case 'partial':
				return '/partials';
				break;

			case 'block':
				return '/blocks/' . $name;
				break;

			default:
				return '';
				break;
		}
    }

	//Get directory for scss file
    private function getStyleDirectory(string $type) : string
    {
		switch ($type) {

			case 'partial':
				return '/components';
				break;

			case 'single':
			case 'archive':
			case 'taxonomy':
			case 'page':
				return '/pages';
				break;

			case 'block':
				return '/blocks';
				break;

		}
    }

	//Create PHP file
	private function createTemplateFile(string $type, string $name, string $nicename, string $folder ) : void
	{
		$filename = ( $this->isWpTemplate( $type ) ? $type . '-' . $name : $name );

		$php_path = $this->src_path . 'wp_files' . $folder . '/' . $filename . '.php';

        if(file_exists($php_path)) {
            WP_CLI::warning( sprintf( 'Le composant %s.php existe déjà !', $filename ) );
            return;
        }

        $php_file = fopen($php_path, 'w') or die('Unable to create file!');

		if( $this->isWpTemplate( $type ) ) {
			$stub_contents = $this->getStubContents($type, $name, $nicename);
			fwrite($php_file, $stub_contents);
		}

        fclose($php_file);

		WP_CLI::line( WP_CLI::colorize( "%YMake%n file %C{$filename}.php%n" ) );
	}

	private function createBlockJson(string $name, string $nicename, string $folder) : void
    {
        $json_path = $this->src_path . 'wp_files' . $folder . '/block.json';
        if(file_exists($json_path)) {
            WP_CLI::warning( 'Le fichier block.json existe déjà !' );
            return;
        }

        $json_file = fopen($json_path, 'w') or die('Unable to create file!');

        $stub_contents = $this->getStubContents('block-json', $name, $nicename);
        fwrite($json_file, $stub_contents);

        fclose($json_file);

		WP_CLI::line( WP_CLI::colorize( "%YMake%n file %Cblock.json%n" ) );
    }

	private function getSuccessMessage(string $type, string $name) : string
	{
		switch($type) {
			case 'block':
				$template = 'Block';
				break;

			case 'partial':
				$template = 'Partial';
				break;

			case 'page':
				$template = 'Custom page template';
				break;

			case 'single':
				$template = 'Custom post template';
				break;

			case 'archive':
				$template = 'Custom post type archive';
				break;

			case 'taxonomy':
				$template = 'Custom taxonomy archive';
				break;
		}

		return sprintf('%1$s %2$s created with success.', $template, $name);
	}

	private function createFiles(mixed $args, mixed $assoc_args) : void
	{
		list( $name ) = $args;

		//Nicename
        $nicename = $assoc_args['nicename'] ?? $name;

        $template_folder = $this->getTemplateDirectory( $this->type, $name );

        $camel_name = $this->camelize($name, '-');

		if( $this->type == 'block') {
			$this->createTemplateFolder( $template_folder );
		}
        
		$this->createTemplateFile( $this->type, $name, $nicename, $template_folder );

		if( $this->type == 'block') {
        	$this->createBlockJson( $name, $nicename, $template_folder );
		}

		if($assoc_args['css'] ?? true) {
			$this->createStyleFile( $this->type, $camel_name );
		}

		if($assoc_args['js'] ?? false) {
            $this->createScriptFile($this->type, $camel_name );
        }

		WP_CLI::success( $this->getSuccessMessage( $this->type, $name ) );
	}
}