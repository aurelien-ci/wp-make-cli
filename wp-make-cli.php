<?php

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    require_once dirname( __FILE__ ) . '/Commands/block.php';
    require_once dirname( __FILE__ ) . '/Commands/page.php';
    require_once dirname( __FILE__ ) . '/Commands/archive.php';
    require_once dirname( __FILE__ ) . '/Commands/single.php';
    require_once dirname( __FILE__ ) . '/Commands/partial.php';
    require_once dirname( __FILE__ ) . '/Commands/taxonomy.php';
}