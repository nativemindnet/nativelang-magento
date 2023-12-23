<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'nativemind' );

/** Database username */
define( 'DB_USER', 'nativemind' );

/** Database password */
define( 'DB_PASSWORD', 'RHSKRUesuYnOrqFlevXZ' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1:3306' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'M~36&~h?j1O42HTm|`T8m`6]595Yi.1*v)o?H]W:Iz;uw6;f:&1!;U/ >da-T``0' );
define( 'SECURE_AUTH_KEY',   'W.cV-qP5`hz?16DHc9,(%gVLM30>fp~Cg-,xfP)U]3XXNsgq&4y?)!u<D<$0<)MF' );
define( 'LOGGED_IN_KEY',     '4P6-pw%/J1&C-5&3+LmS])(?j}O#FDt<A`)<_{SP KLAp,vy3d9+]!01(CD(7&_X' );
define( 'NONCE_KEY',         '&]/,GYh{v&##rIuC]]tB$QI!IF1DB[hoT@LLzgg;W 9Wh<}Ug2I4?a~T;:@4-f+:' );
define( 'AUTH_SALT',         'dYf4SHsh)(_ep=t@`A.D&6zx8O|7Bk<6i u/]w-gVVI8MfPQ]W;]G~-+RPmCrS9n' );
define( 'SECURE_AUTH_SALT',  'U/D385 Y+,_0/!A|x AE$l[7JEIr.*>gZ1`O9:/R/XG%! S }_BQ#^FaFs(t&fk|' );
define( 'LOGGED_IN_SALT',    '/[Og01L$Ki~&BKLVK[Td1^1*U)&`MPz)o-n(xuOJS>RhcH}!^q0w(f&iifCl*#Ov' );
define( 'NONCE_SALT',        ';U(%oQ5ogr:`no?54%AKfg,hoTlnbYDIK+Ov/sJd4T!4U sY~[mPl1[m T)4]L4w' );
define( 'WP_CACHE_KEY_SALT', 'kpWc._cu+)x[+^xR^Th^&J$YFb_IcdHY7B-Jvu)P$mx?6}^_JhbZH-)RUkG<(fau' );


/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */



define( 'SUNRISE', true );

define( 'WP_ALLOW_MULTISITE', true );
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', true );
$base = '/';
define( 'DOMAIN_CURRENT_SITE', 'nativemind.net' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );

define( 'FS_METHOD', 'direct' );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', true );
define( 'CONCATENATE_SCRIPTS', false );
define( 'AUTOSAVE_INTERVAL', 600 );
define( 'WP_POST_REVISIONS', 5 );
define( 'EMPTY_TRASH_DAYS', 21 );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
