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
define( 'DB_NAME', 'bizhours' );

/** MySQL database username */
define( 'DB_USER', 'bizhours' );

/** MySQL database password */
define( 'DB_PASSWORD', 'N$7^1%L10royV6*j' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */

define( 'DB_COLLATE', '' );
define( 'WP_DEBUG', true );
/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '(a&?-ikocK`^d`O{mwh{a>>K5$d(qW|W! E8-$-]B=e0N.|N-LinR-4aUU2$SV&:');
define('SECURE_AUTH_KEY',  '/P*#zM=WAbP5e:2zDi/d8gX<g({=rqnsXpDBDIa5y8p4E>Sp,Hmz-rT-jj22`BQq');
define('LOGGED_IN_KEY',    'lougZHA_pEG&qhd~qvWpL/Jznv@7y<tRhh09LXpopL|M])a!sgw!+RB[TNT{+Fjq');
define('NONCE_KEY',        '-aIMfVQ V)6fBQicd#h!@fN#{XX<taC{3dx_?/eM[+1a:hHN$LViT^MdRk@ae-**');
define('AUTH_SALT',        'k^:<{baID/0<Wb&F=X:y:)ck-4(DV!==7.(tn_OQlXI^VFGLB+7VRX2$R5+.bO++');
define('SECURE_AUTH_SALT', 'Z)vXBPSv1zvl<HWrswD+ V8}X-2aI!>dG +Uru4Ab8D>mBU2:Hu4HGTwsv>48-vX');
define('LOGGED_IN_SALT',   'iZ_5eNkd+pa$7Q!M>VB!%+JngA<03XIt_?;?fCGXp>^V+RzdBDfZ:_|gtz&3?(I7');
define('NONCE_SALT',       ':(>c;B/rFUbH@m{#7?(_wq*z11PNdJX-KH~$_e|~^8E+VDj1Y_+eOUukkrB8ln2r');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


if ( isset( $_SERVER['HTTP_HOST'] ) && preg_match('/^(community_justice_league.)\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(.xip.io)\z/', $_SERVER['HTTP_HOST'] ) ) {
define( 'WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] );
define( 'WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] );
}


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
