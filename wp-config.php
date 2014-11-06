<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

include('wp-env.php');
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/var/www/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
$env = unserialize(ENV);
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', $env["DB_NAME"]);

/** MySQL database username */
define('DB_USER',$env["DB_USER"]);

/** MySQL database password */
define('DB_PASSWORD', $env["DB_PASSWORD"]);

/** MySQL hostname */
define('DB_HOST', $env["DB_HOST"]);

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'B4,5B)0,0u7T62kuvoK+dg5afqr!z<P5m!L[00xvYoD%w 1G~-kET_U5-{|nj^wT');
define('SECURE_AUTH_KEY',  ']gh}H([]MRl#n>SCh5L-Fi|$f;xEA;y.H,~<B,1FG&}gAZh2|rv-t{*SrMHWGO}s');
define('LOGGED_IN_KEY',    'Nm?5Me*H|yh76Ha[G+`/lkhp#++EWlCLgv;:$Bd+RNrh)#1T;>a!{{<HX][]ZD_|');
define('NONCE_KEY',        '[SlU*4$zK8(@<p;uR{}D.6q|KdS=4p4:TN^9<$N@:pf4}dYbWF!X6{+=-Ks4I{o.');
define('AUTH_SALT',        '%%e-W/:n19]Rb-^cLs^C3>.9_9r1 f$)9j-5Kco8||5zS.@Y2`~Th&]rk,kt6-xC');
define('SECURE_AUTH_SALT', '%Mx=8f. SGg1vY;`^Y[ :-7-vp$G8;-?R66m?!l_IK:>5KNMaE-5Sc7Ll]cDN3mZ');
define('LOGGED_IN_SALT',   'RV`xp^#N6_c5qJ$o9r,+ d_)dp9G$ h>.n}MR0&IDI-pYQ%/QzkNRT9XbX>.+!Wf');
define('NONCE_SALT',       'jgu~-k|g]5CrsoN&pLJe7by3ti%7f)8u~q}^3!MX4 +w|-6DO:}iE`>GOe+-g.)Q');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'es_ES');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', $env['WP_DEBUG']);

define('FS_METHOD', $env['FS_METHOD']);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
