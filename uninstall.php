<?php
/**
 * File richiamato in fase di disinstallazione plugin: In questa
 * fase bisogna eseguire la pulizia delle opzioni memorizzate sul
 * database wordpress e controllare se ambiente multisite. 
 *
 * @package SZGoogle
 */
if(!defined('WP_UNINSTALL_PLUGIN')) die();

/**
 * Prima della definizione della classe controllo se esiste
 * una definizione con lo stesso nome o già definita la stessa.
 */
if (!class_exists('SZGoogleUninstall'))
{
	class SZGoogleUninstall
	{
		// Funzione costruttore per controlli e operazioni iniziali.
		// Il controllo principale di questa classe è legato ai controlli di versione.

		function __construct()
		{
			if (is_multisite()) $this->uninstall_delete_options_multisite();  
				else $this->uninstall_delete_options_single();
		}

		// Cancellazione delle opzioni di configurazione per
		// singolo blog durante la fase di disinstallazione

		function uninstall_delete_options_single()
		{
			delete_option('sz_google_options_base');           // Google Setup
			delete_option('sz_google_options_plus');           // Google Plus
			delete_option('sz_google_options_ga');             // Google Analytics
			delete_option('sz_google_options_authenticator');  // Google Authenticator
			delete_option('sz_google_options_calendar');       // Google Calendar
			delete_option('sz_google_options_drive');          // Google Drive
			delete_option('sz_google_options_fonts');          // Google Fonts
			delete_option('sz_google_options_groups');         // Google Groups
			delete_option('sz_google_options_hangouts');       // Google Hangouts
			delete_option('sz_google_options_panoramio');      // Google Panoramio
			delete_option('sz_google_options_translate');      // Google Translate
			delete_option('sz_google_options_youtube');        // Google Youtube
		}

		// Cancellazione delle opzioni di configurazione per
		// intero network durante la fase di disinstallazione

		function uninstall_delete_options_multisite()
		{
			global $wpdb;
			$blogs = $wpdb->get_results("SELECT blog_id FROM {$wpdb->blogs}", ARRAY_A);

			// Loop principale del network con tutti i blog configurati,
			// per ognuno di essi esguo la cancellazione delle opzioni.

			if ($blogs) {
				foreach($blogs as $blog) {
					switch_to_blog($blog['blog_id']);
					$this->uninstall_delete_options_single();
				}
			}

			// Ripristino il blog corrente dopo la lettura e il loop
			// principale dei blog appartenenti al network completo

			restore_current_blog();
		}
	}

	// Creazione oggetto per eseguire la funzione di disinstallazione
	// del plugin con la pulizia delle opzioni ad esso legate

	new SZGoogleUninstall();
}