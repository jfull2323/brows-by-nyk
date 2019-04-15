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
define( 'DB_NAME', 'brows' );

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
define( 'AUTH_KEY',         '+Axs,sMbnh%m8 =WxfSw7QGHLuHMEB(h93]]TOf4d*E]RuY8(|.=`ip*4Yp.aC:(' );
define( 'SECURE_AUTH_KEY',  '5ICp%;iMij;KMa;4qa_KGHW&yI,)H`$ZafI~*sgEw:10ulr[64|v~I*Q9eq{/QLA' );
define( 'LOGGED_IN_KEY',    ',nXCU7x!_xgwq.bh!aI7SKG3yXh/>RT4RHf) 10p;C$=%8|$lxiKbplg!q8cCT|~' );
define( 'NONCE_KEY',        '!4 .-s%`+k{hi[T1sZ?O 0oov;ym$[jhb6#wy;&++/`=H:w3+wfW`?d~MND.L2/g' );
define( 'AUTH_SALT',        'xVNezO>mNY{JITr8;kScagsxg :r@Gw0m_qu_K 7|;UW-:3&SP+BEE:UlbAY@kj;' );
define( 'SECURE_AUTH_SALT', '5{4hSnnbYNx[V_V4~!?MQz&J%wBo@Mer^()aZX2]CUe2`63#H;Hb+Y~82.*3`Ax ' );
define( 'LOGGED_IN_SALT',   'or![3RJaV+c[5j;bA0AN[5_zC|*]`u;2KSY]R7}s6/Ew[;mZvPzsv(2jvHboAYtf' );
define( 'NONCE_SALT',       '6nH8XBhkS-=[%[+Oy+]CX4:E?+4vD;(]cO/yk4ERt^]i~/Ofj&g4y$[JKovP3ASG' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
