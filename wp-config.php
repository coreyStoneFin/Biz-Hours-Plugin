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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'SEWP' );

/** MySQL database username */
define( 'DB_USER', 'wp' );

/** MySQL database password */
define( 'DB_PASSWORD', 'wp' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '%_!eM@[kW[G)(+NXsq1G<Qm^e5+Bz41*t*SzYA|;4JMW)q,+~?N5)1S41+#$$6uy');
define('SECURE_AUTH_KEY',  '{q.VEFY.r3}}u/Rj2=6GBDG1G0vXy3{aRL|2g/-Lr$onVK7ZiQh{u`v-5~7|og^S');
define('LOGGED_IN_KEY',    ';9ZVDS$2Z`c7^(uhTRqYu-|u|_(~qV-e4]Mo&AgA(>{d^g(Q-CtWt}}< t.T-H8G');
define('NONCE_KEY',        ':l{-PM4rdF1as+2Z&(CzNt3s!2o,=E8Z;>%L|:^Y_f_-a~0cR|ZTq-zPjP!BbO,o');
define('AUTH_SALT',        '{(xYbHSNfO]K.-?qDU&h.sm3afSY0POyp1~K{{y|lo|.).$Rf}11!e|Q2&e7EItX');
define('SECURE_AUTH_SALT', 'VB3[v-CjF<-PRqJMu97p/F@Kw[JrPuj8D|x2=RIV{CO`-#%Q}[Y1#h*tHvCPKWKa');
define('LOGGED_IN_SALT',   'T-wR5d.D_^j|(Un.YORkbW~e/i)XQ<^P(<;zNXQU(|`.X9dc!mOX/!JU_zPO],$0');
define('NONCE_SALT',       '~Lo}xL^bilLrTcS6:)SY$_-sqEMT&)//p]]|6(U(=PI2Lm`h*mH4)O.Y@%zP:$c<');


/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


if ( isset( $_SERVER['HTTP_HOST'] ) && preg_match('/^(SEWP.)\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(.xip.io)\z/', $_SERVER['HTTP_HOST'] ) ) {
define( 'WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] );
define( 'WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] );
}


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
