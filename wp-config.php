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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'DreamItReelProductions');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '}@z|*Lls;|},8kc>g~]Z6FP:XJfHSV4(jaO/#luVtz#~!U2/yDTGyOjt72%nJ)+W');
define('SECURE_AUTH_KEY',  'R]6# DlBPu=ht&jV^M`0a4M02-xbs4}UB/+uq+YP#%>NYu0Km2|sF`Sn5)J^n|;D');
define('LOGGED_IN_KEY',    'U41n}?s}myVV*f??J &?wQu>;s;`|cLuftrD%.-q_#Z$YcKl;V>Z_s~KTZ(y#NL@');
define('NONCE_KEY',        'V)ZZmHQ}9UNk(.XY@GrK->SH;gSK<2Kwu Iy&:o/Y/#Bu@+P.:s^Jt%QC+^HL+kn');
define('AUTH_SALT',        'Kx+<S*!<qcBCCF:Nu):CE(o|,/4UA<$-H#(q2]/,-UE.ANRk>;;t4v)3Z7!:Fx0>');
define('SECURE_AUTH_SALT', '|+#)CTbvOMU/(U,}JzUMDb%%h<)_,E=P-5G5~y Vl9bUJ5T)(6kKM8Xi4vFWVHOZ');
define('LOGGED_IN_SALT',   '[+D|8h<{@&.e[A|+x+#tAN+3<ETq)s!y&VK8x_Zn& k|A9KEkc61V,eH&E5s3bcc');
define('NONCE_SALT',       'p%]c|!F)6[oHpfA<c4Mx-~|-^)ym%1/5FHDo/^Y%4I5tf?>kdl$vN[+9+:GtYr#r');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_production';

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
