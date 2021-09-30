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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'uzsakymo_demo1' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'u+&@++Tjxjw~q>@S>1P/W:w1&G fqPs3jy2C-Ta2[O89 /=3tqull#:+_,$!93pn' );
define( 'SECURE_AUTH_KEY',  'x##aoh{*@.WedER<W~iNRS^qc/Rw~K!fkpc])/3L|veaTl5ZZY*_:&Hh&O,3v2t6' );
define( 'LOGGED_IN_KEY',    '|[:29`v#bG@/o_ftlc;1y2~c8V<M~@hF9NMa|X-?oMtlt=lB2H_!}eYDLfe?[#TA' );
define( 'NONCE_KEY',        'Sq!goxb.m7%l[jBU/v1}_-/rm<I4!cYR?$0=fFrOCi1q7 i+S,$e`v?B=F#$?z^S' );
define( 'AUTH_SALT',        '8&J*=_h6;i`0K|,H5)vDVv=kWEpk5$&w`2J31<x&$NuZEMlP#rN>mG5p+7Ib=,?c' );
define( 'SECURE_AUTH_SALT', 'OK]F]nDprJacjTU(D+i.m{U;C1jA 7o`|_I0N}u.c8T4E(/:v-@|QoM-U|lcYT-g' );
define( 'LOGGED_IN_SALT',   '0UV;96.EFg_YiVxNq%mzY0wY#}F-AD;qG6U.#f]e9}<.r5+wx=w&OZkN6j,jwl%1' );
define( 'NONCE_SALT',       ']=/^Jl@m5r$ai!bCx79IgN[gAbZ+<6 DnD-],+_;Rgg{tm}^9IW0`ub[JHzrpw,C' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

define('WP_HOME', 'https://78.60.66.246/');
define('WP_SITEURL', 'https://78.60.66.246/');
$_SERVER['HTTPS'] = 'on';
$_SERVER['SERVER_PORT'] = 443;
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
