<?php
 
//  define('DISALLOW_FILE_MODS',true);
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache
/** Enable W3 Total Cache */
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'mywordpress');
/** MySQL database username */
define( 'DB_USER', 'root');
/** MySQL database password */
define( 'DB_PASSWORD', '@rizwan92');
/** MySQL hostname */
define( 'DB_HOST', 'localhost');
/** Database Charset to use in creating database tables. */
 define( 'DB_CHARSET', 'utf8');  
/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '');
// define('DISABLE_WP_CRON', true);
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'ab259994443359c378ad22638be451bb310a9d5b');
define( 'SECURE_AUTH_KEY',  'b2cdacc06efaf1103471391e69f7fb80c259c923');
define( 'LOGGED_IN_KEY',    'f024ac0e371b8a2addef0b3972db93def2f011ea');
define( 'NONCE_KEY',        'e034647cceb5b19104f4cc159793e8d4366d4f37');
define( 'AUTH_SALT',        '7019f6025f0a28fc925e32e0210aed45b48f9356');
define( 'SECURE_AUTH_SALT', 'adc217aaae81c6323efd6ed8ba0bd866af4ecbc6');
define( 'LOGGED_IN_SALT',   'a1b995f5c668f448ed86ec37deb442ea965817b3');
define( 'NONCE_SALT',       '2dcae56217cc6c1f9350ffe4daccc5daa856eb4f');
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
// If we're behind a proxy server and using HTTPS, we need to alert Wordpress of that fact
// see also http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        $_SERVER['HTTPS'] = 'on';
}
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
        define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}
/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
// define('DISALLOW_FILE_EDIT', true);
// define('DISALLOW_FILE_MODS', false);
define('FS_METHOD','direct');
define( 'WP_DEBUG', true );

// define( 'WP_DEBUG', true );

// // Enable Debug logging to the /wp-content/debug.log file

// define( 'WP_DEBUG_LOG', true );

// // Disable display of errors and warnings

// define( 'WP_DEBUG_DISPLAY', false );

// @ini_set( 'display_errors', 0 );

// Use dev versions of core JS and CSS files (only needed if you are modifying these core files)