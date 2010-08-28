<?php
/*
Plugin Name: URL Record
Plugin URI: http://www.noeonline.info/
Description: This plugin will create an URL Record on your blog and will write all activity on your blog in main blog page. The file report will found on <code>/wp-content/url-record/data/</code> you can analize it for prevent your blog from hacker or attacker. This plugin is recomended for use if your hosting not use cpanel or etc.
Author: noe
Version: 1.0
Author URI: http://www.noeonline.info/
*/

function url_record() {
$data_folder = ABSPATH . 'wp-content/url-record/data';
if ( !file_exists( $data_folder ) ) {
mkdir( ABSPATH . 'wp-content/url-record', 0777 );
mkdir( $data_folder, 0777 );
}
if ( !file_exists( $data_folder . '/index.php' ) ) {
$op = fopen( $data_folder . '/index.php', 'a+' );
fputs( $op, "<?php\r\n/**\r\n * URL Record\r\n * This file is auto generate from URL Record plugin\r\n**/\r\n?>" );
fclose( $op );
}
if ( !file_exists( $data_folder . '/.htaccess' ) ) {
$op = fopen( $data_folder . '/.htaccess', 'a+' );
fputs( $op, "<FilesMatch (.*)\.log>\r\nOrder deny,allow\r\nDeny from all\r\n</FilesMatch>" );
fclose( $op );
}
$url_date = date('m-d-Y H:i:s');
$url_date2 = date('m-d-Y');
$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$ref = $_SERVER['HTTP_REFERER'];
$req = $_SERVER['REQUEST_URI'];

$op = fopen( $data_folder . '/' . $url_date2 . '.log', 'a+');
fputs( $op, '[' . $url_date . '] IP : ' . $ip . ' BROWSER : ' . $user_agent . ' REFERER : ' . $ref . ' REQUEST : ' . $req . "\r\n");
fclose( $op );

}

add_action( 'wp_head', 'url_record' );
/* do_action('plugin_name_hook') */
?>