<?php defined( 'ABSPATH' ) or die( "No script kiddies please!" );
/***************************************************************************
 Plugin Name: Plura 인증 연동
 Description: Plura cookie 정보를 forum에서 연동하여 사용
 Author: joy
 Author URI:
 */

/*
defined
*/

//plugin dir
if( !defined( 'FORUM_PLUGIN_DIR' ) ) {
	define( 'FORUM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

//auth domain name
if( !defined( 'PLURA_AUTH_DOMAIN' ) ) {
	define( 'PLURA_AUTH_DOMAIN', '##domain.com##' );
}

//auth cookie name
if( !defined( 'PLURA_AUTH_COOKIE' ) ) {
	define( 'PLURA_AUTH_COOKIE', '##auth_cookie_name##' );
}

//plura auth url
if( !defined( 'PLURA_AUTH_URL' ) ) {
	define( 'PLURA_AUTH_URL', '##https://auth_url/##' );
}

//plura cookie validation decrypt
if( !defined( 'PLURA_AUTH_DECRYPT_URL' ) ) {
	define( 'PLURA_AUTH_DECRYPT_URL', PLURA_AUTH_URL.'##api_path##' );
}

//include
include_once( FORUM_PLUGIN_DIR.'class/class_plura_auth_validate.php' );
include_once( FORUM_PLUGIN_DIR.'class/class_plura_auth_main.php' );


new Plura_auth_main();
?>