<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'congreso_fondo_editorial' );

/** Database username */
define( 'DB_USER', 'congreso_fondo_editorial' );

/** Database password */
define( 'DB_PASSWORD', 'BLcTkCMyKhBBzFBj' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '=_v(O^CS|g x/FZLsY<vaKl-.aE;enK~)bw&*{&4@[8k T]h:6j1JQy3Hf=bjp?M' );
define( 'SECURE_AUTH_KEY',  ';E)Jsga6*moml8/*mtP9`uF~`.@r)g3v}#I7Ax2v<S Q-k-L}HSV ,6[1d?N;0nY' );
define( 'LOGGED_IN_KEY',    'L]M!d&-F5Srzcy;z5.]ZhLFKDPN?%&@)XAU5k$.ugGE4{yI{L?y/Ebp;rKDk[O,A' );
define( 'NONCE_KEY',        'rwOi=_V8&*Wvx>[.FZjU))!NTH!F[RJ^Sq1=pA&.GW>*P-dB}}w&bB;xVQS]a1@*' );
define( 'AUTH_SALT',        '0cBNMmx%FdV`@TptdACw0kVQ5<Z <@iS0OYf[4&$*=M*dV&u>[Ep4aN{3`9l<1TM' );
define( 'SECURE_AUTH_SALT', '>6D|DiGB85sz=V}|QV^RV~5_ZRF@M9ie;Dgs,P{yMrT~}W^xm%$Sg*-dUQI*va:|' );
define( 'LOGGED_IN_SALT',   '*D >cH+A$W!yH,h*s2rjcQg`d4-[k&=0Sg2mnAVst_oH&NB^* N6qdbBT3_lRb&E' );
define( 'NONCE_SALT',       'rrA[O-DiVhU&%8Zj-=3)VcS;#L/Rqp&n5}2ryn$>Dm;b*i {E(<i.PZ^#}e/4;^.' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'fe_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
