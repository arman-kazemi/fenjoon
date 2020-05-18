<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
//define('WP_HOME','http://192.168.1.2/fenjoon');
//define('WP_SITEURL','http://192.168.1.2/fenjoon');
 
define('WP_POST_REVISIONS', false);
define( 'AUTOSAVE_INTERVAL', 3600 ); // Default is 60
//define( WP_DEBUG, true );

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'fenjoon');

/** MySQL database username */
define('DB_USER', 'fenjoon');

/** MySQL database password */
define('DB_PASSWORD', 'fenjoon');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '-knG#^~>KYU/sz_KI-+h#-+E9i&Ah`P%^#UQhLg/.NS%R|]Ex&+i00?G$C}_ThlP');
define('SECURE_AUTH_KEY',  'F[+Bkt/N)T|IF+1w~^k&Cihmr->=O?yzNG@~m#<06M w#3ql1C#1uk3io&f(R8K`');
define('LOGGED_IN_KEY',    'j1UnE8s=KA2C17+-X<JnKnv k-O0qxvcNMoc,Q]sFr2 gi@`D3JN3ZICE Ngpfk~');
define('NONCE_KEY',        'v69v$kd-F=YB=gr_sz,9}6ZOpLM9m*2$#SpC$.i]++{N{wQ4b:C:l5>`bu8e*D*c');
define('AUTH_SALT',        'u|U(]<1y|gm a@T)|fnv_Kq*~95#vssn}yVVO#*)F.}d?-]w@j9kciY5!qyLZ.<c');
define('SECURE_AUTH_SALT', 'GM8KMyfU/O=VXp:YV7`7x# [K~Np@|p.:37|97wH]v!|W|p!-{pO`g+x1L/8pA+q');
define('LOGGED_IN_SALT',   '$odC6h]llF>H6 p,ILmf}q?T3*:~aIZ%n|}]Gsl-gwP[kC%8c6N>K8w)|T-6aS37');
define('NONCE_SALT',       'h|=r;.L]=r_%s?H5,W+m>P {><lZ,HJ?~a ]0~Qx+`5$_x{YzB(llM57$yJ./AHv');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
