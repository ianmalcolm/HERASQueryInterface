<?php

add_action( 'wp_enqueue_scripts', 'add_my_script' );
add_action( 'wp_head','my_head_js');

function add_my_script() {
    wp_enqueue_script(
        'funtions', // name your script so that you can attach other scripts and de-register, etc.
        get_stylesheet_directory_uri() . '/js/functions.js', // this is the location of your script file
        array('jquery') // this array lists the scripts upon which your script depends
    );
}

function my_head_js() {
	echo '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.js"></script>';
	echo '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip-utils/0.0.2/jszip-utils.js"></script>';
	echo '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.js"></script>';
}

function console_log( $data ){
	echo '<script>';
	echo 'console.log('. json_encode( $data ) .')';
	echo '</script>';
}
?>
