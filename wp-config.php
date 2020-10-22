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
define('FS_METHOD','direct');

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/Applications/XAMPP/xamppfiles/htdocs/POLEDIGITALE/wordpress/wp-content/plugins/wp-super-cache/' );
define( 'DB_NAME', 'MYDB1' );

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
define( 'AUTH_KEY',         'alS?}s8Ib7[d@k =vQ`D37/|L*{*y4y7e5E^cSO}{Os`4c :l1[}i:(k~t^FbiIF' );
define( 'SECURE_AUTH_KEY',  '._nl7z$b@A`mvyE/6gO&5:Rc8K#_3?]q`pzk;8aH|,s_XU$X%jBSwn|_Q ZiD/7q' );
define( 'LOGGED_IN_KEY',    'E|6^VzU]<~kF%Fhm_&{=%n2Tq,a,nf;h}xr|/ujiU5%r<ffJQoK#bsO.QxW`dp#9' );
define( 'NONCE_KEY',        'A:yg^!cBl_0FdNQ4 6T5b@#y;d!CJyAd:J60-G[r+~I2jKlt^G1$Fq*Z7Sd}p)Vs' );
define( 'AUTH_SALT',        'yFvAnJ#S0en/Ycp&TjX*Z@Uo!kl(BE?,[H<}GrmPMwJZa0$:AoWs~Ok~5D1C;n=|' );
define( 'SECURE_AUTH_SALT', '2n3*8S&_nV=N,uPH%JvQX3Cj)=COtYPH>N[ra.7C6),<pm;p}!gT-(y12_@ bpZi' );
define( 'LOGGED_IN_SALT',   'K1kdpTXy5cb!}6X8iuUMawW--z,h8LWo9^a~WAN1@<LSSkrSvJ@|=,x%tkw,Fl%i' );
define( 'NONCE_SALT',       'PR]SKzSfnCU9-p/58RH|xI7h@MVG_e%GU7<q:r~=8<#4?/Z^TPPH&Y0{Gbu}n{Lk' );

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
