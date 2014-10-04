<?php
/**
 * Modulo GOOGLE TinyMCE per la definizione delle funzioni che riguardano
 * sia i widget che i shortcode ma anche filtri e azioni che il modulo
 * può integrare durante l'aggiunta di funzionalità a wordpress.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima della definizione della classe controllo se esiste
// una definizione con lo stesso nome o già definita la stessa.
 
if (!class_exists('SZGoogleAdminTinyMCE'))
{
	class SZGoogleAdminTinyMCE extends SZGoogleAdmin
	{
		function __construct() {
			if (version_compare($GLOBALS['wp_version'],'3.9','>=')) {
				add_action('admin_head',array($this,'register_tinymce_init'));
 			}
 		}

 		// Definizione filtri e azioni per integrazione dei componenti
 		// presenti nel plugin con tinyMCE usato come editor standard

		function register_tinymce_init() {
			if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
				if (get_user_option('rich_editing') == 'true') {
					add_filter('mce_external_plugins',array($this,'register_tinymce_plugin'));
					add_filter('mce_buttons',array($this,'register_tinymce_button'));
					add_action('after_wp_tiny_mce',array($this,'register_tinymce_hidden'));
				}
			}
		}

		// Registrazione del plugin per TinyMCE in maniera da caricare il file
		// javascript con la configurazione del componente solo quando necessario

		function register_tinymce_plugin($plugin_array) {
			$plugin_array['sz_google_mce_button'] = 
				plugin_dir_url(SZ_PLUGIN_GOOGLE_MAIN).'admin/mce/plugins/sz-google-mce.js';
			return $plugin_array;
		}

		// Registrazione del pulsante per TinyMCE usando lo stesso nome con cui
		// viene associata la risorsa javascript e con cui bisogna definire il plugin

		function register_tinymce_button($buttons) {
			array_push($buttons,'sz_google_mce_button');
			return $buttons;
		}

		// Utilizzo l'azione di fine elaborazione TinyMCE per eseguire il codice
		// che mi permette di nascondere le traduzione da usare nel plugin

		function register_tinymce_hidden() 
		{
			$translate = $this->register_tinymce_translate();

			// Creazione divisione nascosta con un div per ogni shortcode del
			// plugin che risulta attivo in questo momento nella sessione

			echo '<div id="sz-google-hidden-shortcodes" style="display:none !important">';

			foreach ($translate as $key=>$value) {
				if (shortcode_exists($key)) {
					echo '<div class="'.$key.'" ';
					echo 'data-width="'      .$value['width'] .'" ';
					echo 'data-height="'     .$value['height'].'" ';
					echo 'data-description="'.$value['title'] .'"';
					echo '></div>';
				}
			}

			echo '</div>';
		}

		// Definizione array per contenere le stringhe di traduzione da 
		// utilizzare nel plugin definito nel file js collegato

		function register_tinymce_translate() 
		{
			return array(
				'sz-gplus-profile'   => array('width'=>'430','height'=>'470','title'=>__('G+ Badge Profile'    ,'szgoogleadmin')),
				'sz-gplus-page'      => array('width'=>'430','height'=>'470','title'=>__('G+ Badge Page'       ,'szgoogleadmin')),
				'sz-gplus-community' => array('width'=>'430','height'=>'390','title'=>__('G+ Badge Community'  ,'szgoogleadmin')),
				'sz-gplus-followers' => array('width'=>'430','height'=>'300','title'=>__('G+ Badge Followers'  ,'szgoogleadmin')),
				'sz-gplus-one'       => array('width'=>'430','height'=>'450','title'=>__('G+ Button +1'        ,'szgoogleadmin')),
				'sz-gplus-share'     => array('width'=>'430','height'=>'450','title'=>__('G+ Button Share'     ,'szgoogleadmin')),
				'sz-gplus-follow'    => array('width'=>'430','height'=>'450','title'=>__('G+ Button Follow'    ,'szgoogleadmin')),
				'sz-gplus-comments'  => array('width'=>'430','height'=>'270','title'=>__('G+ Widget Comments'  ,'szgoogleadmin')),
				'sz-gplus-post'      => array('width'=>'430','height'=>'170','title'=>__('G+ Widget Post'      ,'szgoogleadmin')),
				'sz-calendar'        => array('width'=>'430','height'=>'580','title'=>__('Calendar Widget'     ,'szgoogleadmin')),
				'sz-drive-embed'     => array('width'=>'430','height'=>'380','title'=>__('Drive Embed'         ,'szgoogleadmin')),
				'sz-drive-viewer'    => array('width'=>'430','height'=>'270','title'=>__('Drive Viewer'        ,'szgoogleadmin')),
				'sz-drive-save'      => array('width'=>'430','height'=>'350','title'=>__('Drive Save Button'   ,'szgoogleadmin')),
				'sz-ggroups'         => array('width'=>'430','height'=>'370','title'=>__('Groups Widget'       ,'szgoogleadmin')),
				'sz-hangouts-start'  => array('width'=>'430','height'=>'450','title'=>__('Hangout Start Button','szgoogleadmin')),
				'sz-panoramio'       => array('width'=>'430','height'=>'520','title'=>__('Panoramio Widget'    ,'szgoogleadmin')),
//				'sz-gtranslate'      => array('width'=>'430','height'=>'470','title'=>__('Translate Widget'    ,'szgoogleadmin')),
				'sz-ytvideo'         => array('width'=>'430','height'=>'580','title'=>__('Youtube Video'       ,'szgoogleadmin')),
				'sz-ytplaylist'      => array('width'=>'430','height'=>'560','title'=>__('Youtube Playlist'    ,'szgoogleadmin')),
				'sz-ytbadge'         => array('width'=>'430','height'=>'250','title'=>__('Youtube Badge'       ,'szgoogleadmin')),
				'sz-ytlink'          => array('width'=>'430','height'=>'370','title'=>__('Youtube Link'        ,'szgoogleadmin')),
				'sz-ytbutton'        => array('width'=>'430','height'=>'350','title'=>__('Youtube Button'      ,'szgoogleadmin')),
			);
		}
	}
}