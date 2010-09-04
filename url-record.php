<?php
/*
Plugin Name: URL Record (Raw Log)
Plugin URI: http://www.noeonline.info/
Description: This plugin will create an URL Record (Raw Log) on your blog and will write all activity on your blog. The file report will found on <code>/wp-content/url-record/data/</code> you can analize it for prevent your blog from hacker or attacker. This plugin is recomended for use if your hosting not use cpanel or not have an error log. Manage your URL Record <a href="tools.php?page=url-record.php">here</a>.
Author: Imanuel Novian (nick: noe, wp: noeprivacy)
Version: 1.1
Author URI: http://www.noeonline.info/
*/

if ( !defined( 'WP_CONTENT_DIR' ) ) {
define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
}

define( 'URL_DATA_DIR', WP_CONTENT_DIR . '/url-record/data' );

function url_checker() {

if ( !file_exists( WP_CONTENT_DIR . '/url-record' ) ) {
mkdir( WP_CONTENT_DIR . '/url-record', 0777 );
}

if ( !file_exists( URL_DATA_DIR ) ) {
mkdir( URL_DATA_DIR, 0777 );
}

if ( !file_exists( URL_DATA_DIR . '/' . date('Y') ) ) {
mkdir( URL_DATA_DIR . '/' . date('Y'), 0777 );
}

if ( !file_exists( URL_DATA_DIR . '/' . date('Y') . '/' . date('m') ) ) {
mkdir( URL_DATA_DIR . '/' . date('Y') . '/' . date('m'), 0777 );
}

if ( !file_exists( URL_DATA_DIR . '/index.php' ) ) {
$file = URL_DATA_DIR . '/index.php';
$str = "<?php\r\n/**\r\n * URL Record\r\n * This file is auto generate from URL Record plugin\r\n**/\r\n?>";
file_put_contents( $file, $str );
}

if ( !file_exists( URL_DATA_DIR . '/' . date('Y') . '/index.php' ) ) {
$file = URL_DATA_DIR . '/' . date('Y') . '/index.php';
$str = "<?php\r\n/**\r\n * URL Record\r\n * This file is auto generate from URL Record plugin\r\n**/\r\n?>";
file_put_contents( $file, $str );
}

if ( !file_exists( URL_DATA_DIR . '/' . date('Y') . '/' . date('m') . '/index.php' ) ) {
$file = URL_DATA_DIR . '/' . date('Y') . '/' . date('m') . '/index.php';
$str = "<?php\r\n/**\r\n * URL Record\r\n * This file is auto generate from URL Record plugin\r\n**/\r\n?>";
file_put_contents( $file, $str );
}

if ( !file_exists( URL_DATA_DIR . '/' . date('Y') . '/' . date('m') . '/.htaccess' ) ) {
$file = URL_DATA_DIR . '/' . date('Y') . '/' . date('m') . '/.htaccess';
$str = "<FilesMatch (.*)\.log>\r\nOrder deny,allow\r\nDeny from all\r\n</FilesMatch>";
file_put_contents( $file, $str );
}

}

function url_record() {

url_checker();

$url_date = date('m-d-Y H:i:s');
$url_file = date('m-d-Y');
$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$ref = $_SERVER['HTTP_REFERER'];
$req = $_SERVER['REQUEST_URI'];
$str = '[' . $url_date . '] IP : ' . $ip . ' BROWSER : ' . $user_agent . ' REFERER : ' . $ref . ' REQUEST : ' . $req . "\r\n";

$op = fopen( URL_DATA_DIR . '/' . date('Y') . '/' . date('m') . '/' . $url_file . '.log', 'a+');
fputs( $op, $str );
fclose( $op );

}

add_action( 'wp_head', 'url_record' );

function url_main_menu() {
add_submenu_page( 'tools.php', 'URL Record', 'URL Record', 10, __FILE__, 'url_main_manage' );
}

add_action( 'admin_menu', 'url_main_menu' );

function url_main_manage() {
echo('
<div class="wrap">
<h2>URL Record Options</h2>
</div>
');
}

?>