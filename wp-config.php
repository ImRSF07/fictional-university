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
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          'M<V/_Fu}BxB`uwg&nhN>65Cywm.69*<9a#XG`#ktK#,ddZ&:Tn^CAkN^cpX<>MuX' );
define( 'SECURE_AUTH_KEY',   '%??n?_cLw+RXBdu67Cer~I0[n;vC#kr<`8S$#?W0F~3(0$C`9PK1U.QQEIU.v.QS' );
define( 'LOGGED_IN_KEY',     'r)<,>|t*sbE$qSB`Fk3j&v5YgvdX=zLb*N&C6=u<e.$^=c%ucGP0G]j*LolS4|s:' );
define( 'NONCE_KEY',         'u-YyH)9jf8}0A vm8x^AA]c~_V:UY`qc_4P4FnJ,-}*dixAYP};^$3Y`IsI%R;!y' );
define( 'AUTH_SALT',         ')7;1;aU0S=,dA7k]VQxx$)]3yZkx.hS:}adtA]N|8}%3N`Hhh_uS_;])VPsdU1(l' );
define( 'SECURE_AUTH_SALT',  '/!e H(__N0Z)sd2d%!<d*l#N|2|tLq vPCJ3ID(xFJ!p4}$@Jf5k+#}yhMxPldnd' );
define( 'LOGGED_IN_SALT',    ']sOJG:qCmd4BXR(Q;az3B5Wtklwb@>xCpS<I~#l>e=-}crs_fQ3igo|U!h}5f758' );
define( 'NONCE_SALT',        'n;ANaMB^ks}^RYN$;_Y0,6 e:DvyH8 {6=Uk7[)*mvWPua[~RcM3y.AMo_*6{W[Z' );
define( 'WP_CACHE_KEY_SALT', '=U+z}0Uf1R/bQ}.m]PsO*%R(F1DAsp~95<P#wEzBF8$$Z${ey^tpqNWN?bB@vv,n' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
