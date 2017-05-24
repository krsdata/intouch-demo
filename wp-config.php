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
define('DB_NAME', 'ekart_db1');

/** MySQL database username */
define('DB_USER', 'ekart_user');

/** MySQL database password */
define('DB_PASSWORD', 'user@123!');

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
define('AUTH_KEY',         'q#Qs%kD6t0%$xL|K3ws.Q*||NM WekxKtjNrG *inG?l{p?qirp|k{5`*?$Rh2:8');
define('SECURE_AUTH_KEY',  'u]I@1$M}g-O@jJ2oR@^z+NFFwuf6]V-L.53N{.IfU$:g*juZNTW s|*VirH8>-R!');
define('LOGGED_IN_KEY',    '^VVJ3%tRzL|<dDV]J#N1.AGLqENw[QS5#!.vIw(1cyA:81@5#@M^o^,ntaI#VU)g');
define('NONCE_KEY',        '7[ }sCHx{5+x2LJ31?(kQfxsL/:uF`nMW|]ZzYt8CVIM |]36sY.VyCTurlNZFWM');
define('AUTH_SALT',        'WCIx-2/hKf9GZOm!N_~GU?`E]q2q(9fqCDIPo(RYR#:Eq3xCGP!A=JV&*]#faPVZ');
define('SECURE_AUTH_SALT', 'x5h4dE!!_j0sDK4iDw@Otp_PX!(zO3LLj2jHmolRaGX7g%FQAX=/04=dW^R74gUb');
define('LOGGED_IN_SALT',   'Tf>4ZT,srg%b5)5um8~r| T$lO{-$E)Wh*zh&JtlQYO1@Czz)2s;x#4z!sWw@Rok');
define('NONCE_SALT',       '4_[^lO8#kmEbm4OJ>>kU/Y]ucchKXPN7iAAW(0C[ Xy0KQqy=igu$gL)f.shW^`+');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
