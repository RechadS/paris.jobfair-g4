<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur 
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** activer les variables de session $_SESSION dans WordPress **/
if (!session_id()) {
  session_start();
}
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'paris_jobfair');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', '');
/**define('DB_PASSWORD', ''); */

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données. 
  * N'y touchez que si vous savez ce que vous faites. 
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant 
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'pv1;%>Fm+7 v+ra_+rgxdB=-$4TXXTBlGfx&2%]ODOE]| cNgeE:;&Npq*j#=|cg');
define('SECURE_AUTH_KEY',  '6_^T0Jb,jw_&jp.F_j!q+lUIa 3wW-OI/wBY608/tb/_i4?d+vvMlSf,A!:w$6_;');
define('LOGGED_IN_KEY',    'GV7:R;C-%^KB^^{)cU`.E/W+0yEbM:E0>4pKYtSR]<_?S4s:tuzo|ARox%m}*,p0');
define('NONCE_KEY',        '{+aZl}9X#O+QFtjKSAJ?NxY<$NP=I_2agTzv^(7ei 4PkLN6t<+3:afr8hkSe1S4');
define('AUTH_SALT',        'Fi`B+a4B#t~}vu/=+<Es|SGf4{[<Cja&ALn0-&y~vMdl/8=XY,g#)29j2GmC|Dg7');
define('SECURE_AUTH_SALT', '1+OqpvewqQy~-R7B+V, t2Z5D3&lv,&#0k^xoeTET!e69q2:WEeV1_UvP,+d8Q?D');
define('LOGGED_IN_SALT',   '1-w1-pFZ:vCmq/9c2-:mO1RU/}^}-Z[;N,k<[tp]|.qOx4n3n*A_}b+Jdgbjyn@B');
define('NONCE_SALT',       'nh(A-P 2k@4A.j&M#>Q$CNsX+c7l]FTFL&,/%3G-l-8sqQNA7V/zx-FYq&vJgeP|');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique. 
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'wp_';

/**
 * Langue de localisation de WordPress, par défaut en Anglais.
 *
 * Modifiez cette valeur pour localiser WordPress. Un fichier MO correspondant
 * au langage choisi doit être installé dans le dossier wp-content/languages.
 * Par exemple, pour mettre en place une traduction française, mettez le fichier
 * fr_FR.mo dans wp-content/languages, et réglez l'option ci-dessous à "fr_FR".
 */
define('WPLANG', 'fr_FR');

/** 
 * Pour les développeurs : le mode deboguage de WordPress.
 * 
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant votre essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de 
 * développement.
 */ 
define('WP_DEBUG', false); 

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');