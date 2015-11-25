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
define('DB_NAME', 'jennyo_info_1');

/** MySQL database username */
define('DB_USER', 'jennyoinfo1');

/** MySQL database password */
define('DB_PASSWORD', 'zna82thE');

/** MySQL hostname */
define('DB_HOST', 'mysql.jennyo.info');

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
define('AUTH_KEY',         '&R(IA#+;QEu?2D!7+k)KnJNQ6@*Ku%8PsoVu_Ije^OorLR|vm1%#*a~PLbn1/Iw*');
define('SECURE_AUTH_KEY',  'D)83fOsTm!w_LSAXhZSG2hty5l+jnj!GLaXj/XQ#?:43FC4|f/%ttZ*z8J*;CC%&');
define('LOGGED_IN_KEY',    'PpDstYR`&rHH/k*m9S+aEiw2jhE0T7BrgZDzz1cfAjM7xd:fsz^V3*H:qR~m1sMI');
define('NONCE_KEY',        '4e@IE0NOUkDGCNyL3HnD`u+&$;*Ij/5CLq)R%4pop/E)khIoSBVXzy@9QxBNZZfJ');
define('AUTH_SALT',        '^J!Ox8e^~XoeIy#G+QoZM:gXePq1yDt!gjf+C69#)$|Gs@BbtoU"$BmjNga0GLCU');
define('SECURE_AUTH_SALT', '#)UGk(j7%:7RV5tv:xS5LU:~Bh0"MipZ7+t~UT%(tfPHgaxT5yB/!G!CX@&$mn76');
define('LOGGED_IN_SALT',   ')mO`8bYw?jy$Uo@5e~jXt*zGl4@Q^y6dj^c?E)c`9~p1B0UV5hiY*;9yM9gx5G0E');
define('NONCE_SALT',       'tba%?sHw+~#_7taz:b`|vaAhj2PkEsAd8jnVn|!N6AZ5Y_?^Ev_1"jx"lEOK%&XT');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_nj5zw9_';

/**
 * Limits total Post Revisions saved per Post/Page.
 * Change or comment this line out if you would like to increase or remove the limit.
 */
define('WP_POST_REVISIONS',  10);

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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

