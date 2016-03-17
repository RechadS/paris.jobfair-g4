<?php

define( 'ONETONE_THEME_BASE_URL', get_template_directory_uri());
define( 'ONETONE_OPTIONS_FRAMEWORK', get_template_directory().'/admin/' ); 
define( 'ONETONE_OPTIONS_FRAMEWORK_URI',  ONETONE_THEME_BASE_URL. '/admin/'); 
define('ONETONE_OPTIONS_PREFIXED' ,'onetone_');

define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/' );
require_once dirname( __FILE__ ) . '/admin/options-framework.php';
require_once get_template_directory() . '/includes/admin-options.php';

/**
 * Required: include options framework.
 **/
load_template( trailingslashit( get_template_directory() ) . 'admin/options-framework.php' );

/**
 * Mobile Detect Library
 **/
 if(!class_exists("Mobile_Detect")){
   load_template( trailingslashit( get_template_directory() ) . 'includes/Mobile_Detect.php' );
 }
/**
 * Theme setup
 **/
 
load_template( trailingslashit( get_template_directory() ) . 'includes/theme-setup.php' );

/**
 * Theme Functions
 **/
 
load_template( trailingslashit( get_template_directory() ) . 'includes/theme-functions.php' );

/**
 * Theme breadcrumb
 **/
load_template( trailingslashit( get_template_directory() ) . 'includes/class-breadcrumb.php');
/**
 * Theme widget
 **/
 
load_template( trailingslashit( get_template_directory() ) . 'includes/theme-widget.php' );


 

add_filter( 'manage_edit-entreprise_columns', 'my_edit_entreprise_columns' ) ;

function my_edit_entreprise_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Entreprise' ),
		'en_charge' => __( 'En Charge' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

add_action( 'manage_entreprise_posts_custom_column', 'my_manage_entreprise_columns', 10, 2 );

function my_manage_entreprise_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'duration' column. */
		case 'en_charge' :

			/* Get the post meta. */
			$encharge = get_post_meta( $post_id, 'en_charge', true );

			/* If no duration is found, output a default message. */
			if ( empty( $encharge ) )
				echo __( 'Non Défini' );

			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf( __( '%s' ), $encharge );

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

add_filter( 'manage_edit-entreprise_sortable_columns', 'my_entreprise_sortable_columns' );

function my_entreprise_sortable_columns( $columns ) {

	$columns['en_charge'] = 'en_charge';

	return $columns;
}

/* Only run our customization on the 'edit.php' page in the admin. */
add_action( 'load-edit.php', 'my_edit_entreprise_load' );

function my_edit_entreprise_load() {
	add_filter( 'request', 'my_sort_entreprise' );
}

/* Sorts the movies. */
function my_sort_entreprise( $vars ) {

	/* Check if we're viewing the 'movie' post type. */
	if ( isset( $vars['post_type'] ) && 'entreprise' == $vars['post_type'] ) {

		/* Check if 'orderby' is set to 'duration'. */
		if ( isset( $vars['orderby'] ) && 'en_charge' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'en_charge',
					'orderby' => 'meta_value'
				)
			);
		}
	}

	return $vars;
}

wp_enqueue_script('inscription', get_template_directory_uri().'/js/inscription.js', array('jquery'), '1.0', 1 );
wp_localize_script('inscription', 'ajax_var', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-nonce')
    )
);


add_action( 'wp_ajax_inscription_entreprise', 'inscription_entreprise' );
add_action( 'wp_ajax_nopriv_inscription_entreprise', 'inscription_entreprise' );

function inscription_entreprise() {

	if(!empty($_POST['nom_entreprise']))
    {
        $nomEntreprise = $_POST['nom_entreprise'];

        if(!empty($_POST['nom_resp_entreprise']))
    	{
    		$nomRespEntreprise = $_POST['nom_resp_entreprise'];
    		if(!empty($_POST['email_entreprise']))
	    	{
	    		$mailEntreprise = $_POST['email_entreprise'];

	    		$new_post = array(
			        'post_title'    => $nomEntreprise,
			        'post_status'   => 'publish',           // Choose: publish, preview, future, draft, etc.
			        'post_type' => 'entreprise',  //'post',page' or use a custom post type if you want to
			    );
			    //save the new post
			    $pid = wp_insert_post($new_post);

			    if ($pid) {
			    	add_post_meta($pid, 'nom_contact_entreprise', $nomRespEntreprise, true);
			    	add_post_meta($pid, 'mail_contact_entreprise', $mailEntreprise, true);
			    	add_post_meta($pid, 'telephone_contact_entreprise', $_POST['tel_entreprise'], true);
			    	if (!empty($_POST['pitch_intervenant'])) {
			    		add_post_meta($pid, 'pitch_entreprise', 'Participe', true);
			    	}
			    	if (!empty($_POST['pitch_spectateur'])) {
			    		add_post_meta($pid, 'pitch_entreprise', 'Spectateur', true);
			    	}
			    	if (!empty($_POST['jobdating'])) {
			    		add_post_meta($pid, 'jobdating', 'Participe', true);
			    	}
			    	if (!empty($_POST['table_intervenant'])) {
			    		add_post_meta($pid, 'table_ronde_entreprise', 'Participe', true);
			    	}
			    	if (!empty($_POST['table_spectateur'])) {
			    		add_post_meta($pid, 'table_ronde_entreprise', 'Spectateur', true);
			    	}
			    	$message = "Votre inscription a bien été effectuée";

			    	/*** Créer envoi des mails ***/


					$mail = $mailEntreprise; // Déclaration de l'adresse de destination.
					if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
					{
						$passage_ligne = "\r\n";
					}
					else
					{
						$passage_ligne = "\n";
					}
					//=====Déclaration des messages au format texte et au format HTML.
					$message_txt = "L'institut G4 vous remercie de votre inscription à JobFair en date du jeudi 28 avril de 14h à 18h à l'adresse suivante: 30 rue de Turbigo, Passage de l'Ancre, 75003 Paris
						Vous serez contactés très prochainement par notre équipe afin de régler les détails de votre participation
						Plus d'information sur le site de Jobfair Paris

						L'équipe JobFair";
					$message_html = "<html><head></head><body>
					<p>L'institut G4 vous remercie de votre inscription à JobFair en date du jeudi 28 avril de 14h à 18h à l'adresse suivante: 30 rue de Turbigo, Passage de l'Ancre, 75003 Paris</p>
					<p>Vous serez contactés très prochainement par notre équipe afin de régler les détails de votre participation.</p>
					<p>Plus d'information sur le site de <a href='http://paris.jobfair-g4.fr'>Jobfair Paris</a></p>

					<p>L'équipe JobFair</p></body></html>";
					//==========
					 
					//=====Création de la boundary
					$boundary = "-----=".md5(rand());
					//==========
					 
					//=====Définition du sujet.
					$sujet = "Inscription JobFair 2016";
					//=========
					 
					//=====Création du header de l'e-mail.
					$header = "From: \"Institut G4 - Equipe JobFair\"".$passage_ligne;
					//$header.= "Reply-to: \"WeaponsB\" <weaponsb@mail.fr>".$passage_ligne;
					$header.= "MIME-Version: 1.0".$passage_ligne;
					$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
					//==========
					 
					//=====Création du message.
					$message = $passage_ligne."--".$boundary.$passage_ligne;
					//=====Ajout du message au format texte.
					$message.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne;
					$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
					$message.= $passage_ligne.$message_txt.$passage_ligne;
					//==========
					$message.= $passage_ligne."--".$boundary.$passage_ligne;
					//=====Ajout du message au format HTML
					$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
					$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
					$message.= $passage_ligne.$message_html.$passage_ligne;
					//==========
					$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
					$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
					//==========
					 
					//=====Envoi de l'e-mail.
					if(mail($mail,$sujet,$message,$header)){
						$message = "Le message a bien été envoyé";
					} else{
						$message = "Le message n'a pas été envoyé";
					}
					//==========



					$mail = "rechad.sanehy.test@gmail.com"; // Déclaration de l'adresse de destination.
					if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
					{
						$passage_ligne = "\r\n";
					}
					else
					{
						$passage_ligne = "\n";
					}
					//=====Déclaration des messages au format texte et au format HTML.
					$message_txt = "Une entreprise vient de s'inscrire au JobFair 2016";
					$message_html = "<html><head></head><body>
					<p>Une entreprise vient de s'inscrire au JobFair 2016</p>
					</body></html>";
					//==========
					 
					//=====Création de la boundary
					$boundary = "-----=".md5(rand());
					//==========
					 
					//=====Définition du sujet.
					$sujet = "Inscription JobFair 2016";
					//=========
					 
					//=====Création du header de l'e-mail.
					$header = "From: \"Institut G4 - Equipe JobFair\"".$passage_ligne;
					//$header.= "Reply-to: \"WeaponsB\" <weaponsb@mail.fr>".$passage_ligne;
					$header.= "MIME-Version: 1.0".$passage_ligne;
					$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
					//==========
					 
					//=====Création du message.
					$message = $passage_ligne."--".$boundary.$passage_ligne;
					//=====Ajout du message au format texte.
					$message.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne;
					$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
					$message.= $passage_ligne.$message_txt.$passage_ligne;
					//==========
					$message.= $passage_ligne."--".$boundary.$passage_ligne;
					//=====Ajout du message au format HTML
					$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
					$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
					$message.= $passage_ligne.$message_html.$passage_ligne;
					//==========
					$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
					$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
					//==========
					 
					//=====Envoi de l'e-mail.
					if(mail($mail,$sujet,$message,$header)){
						$message = "Le message a bien été envoyé";
					} else{
						$message = "Le message n'a pas été envoyé";
					}
					//==========

			    }else{
			    	$message = "Une erreur est survenue votre inscription n'a pas été effectuée";
			    }
			    
	    	}else{

		    	$message = "Veuillez renseigner une adresse mail";
		    	 
		    }
    	}else{

	    	$message = "Veuillez renseigner votre nom et prénom";
	    	 
	    }
        
    }else{
    	$message = "Veuillez renseigner une entreprise";
    	
    }
    echo $message; 
    die();
}