<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'tilesbsu_wptilemob');

/** MySQL database username */
define('DB_USER', 'tilesbsu_wpuser');

/** MySQL database password */
define('DB_PASSWORD', 'Tp7TvwLraTDi');

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
define('AUTH_KEY',         '&E5sCMyk=rAb-d:czaA|mvgy;-QsZm-1Peui6S?tzd;#+Cp%ihO>oY-{f-|ZqE{(');
define('SECURE_AUTH_KEY',  'bvYO[`wv$xn%CX4S[|cg6M(Nt|DZa:@T+@oK[`S+&V-j/K`mN2cm{Zy)LD %,Y.C');
define('LOGGED_IN_KEY',    '_=S*7Zv,a~)_5^;{N0D3G2iw8:D|}WmKdxN`r~=C9&fm(MZPSTqo,MU*G-32J*I4');
define('NONCE_KEY',        '%IF8?Eo%1y(/A@Oxb[Sa;GRPY5;)O,+qa-MfU|1q]01DbaZklPJ1{3Uc{C8=h8xX');
define('AUTH_SALT',        'd&K/e[D|_N@K~=4Bh|>|GPx5Ov*wZn+R:B(=fkwi5`UxVY.-rnWdK*Xkf#:yN+p-');
define('SECURE_AUTH_SALT', 'y C[gx3b@7>bq5P2[ YFX~Sc@.}?,dA#oc^Pgg|S|X0j_4u{Qo-?%CZpT3{AwBEb');
define('LOGGED_IN_SALT',   ']|TcBM>/F$a::SaG-?(z-&8XH)c2T~>A5>p,5 5YhSza^-7}k.q83em*c|7=J?gE');
define('NONCE_SALT',       '97;$%u>J4-TPRL.mnCrpu++#!u8@nQLlB|8K/fwcA+H=2+|uX.+[QgyWDTl+Cb3/');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
