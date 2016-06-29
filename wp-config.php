<?php
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
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', 'E:\xampp\htdocs\info\wp-content\plugins\wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'info');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'Z:ZmAE J}/sFP.2+ig=%73 ;ro07&M]=G5Hp=)QprIM5@/24=@`%ujnL};:O1/><');
define('SECURE_AUTH_KEY',  'nX!s7+AQ& ON{lKpDICyi{wgzExHAnqF,_*c|5.V=;_>*f61J.IE,s<>)((Gj%}i');
define('LOGGED_IN_KEY',    '?:Mi9TKm-HY V:/NiY.Ud }V~]+?AF?~%;pYLc=H&!!?Z PR<UzFSMToK3`n(c(J');
define('NONCE_KEY',        'Cb#TSD6]xyd;Ah823y@oRx>$*bJ~Cb@3vd#N}jt~W#z~,6C5X?i]:ji?Q<!o@+kl');
define('AUTH_SALT',        'IOSAGk9w,OvV1Go[tclu4%e1B>~g !hbj7+(Jye{c)wu8X-bc:W(LT*M~iP50N4J');
define('SECURE_AUTH_SALT', 'S=kg.]&_R8B3aEw.Y&:)-bLu*N j[ZU]2Wa9?$k @V6&YDZUKH1&<gI b%WfgCv|');
define('LOGGED_IN_SALT',   'xdXIDX#cnsM8|~Dw#r+fwbWgLv]KjumGuD#-L3?T6&K](HI$*dh)/lN+=eOK|7f~');
define('NONCE_SALT',       '-u{QSM$&S[.Xusl8t1h@8EEO QJzj@1yV?Sqa)b`W3P?=3G5CIa_kl~+CA<0QaRJ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'tfg_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
