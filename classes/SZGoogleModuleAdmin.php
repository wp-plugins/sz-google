<?php
/**
 * Classe SZGoogleModuleAdmin per la creazione di istanze che controllino le
 * opzioni e le funzioni comuni che ogni modulo del plugin deve richiamare
 * o elaborare. Tutti i moduli devo fare riferimento a questa classe. 
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Prima della definizione della classe controllo se esiste
 * una definizione con lo stesso nome o già definita la stessa.
 */
if (!class_exists('SZGoogleModuleAdmin'))
{
	class SZGoogleModuleAdmin
	{
		/**
		 * Definizione delle variabili che contengono le configurazioni
		 * da applicare alle varie chiamate delle funzioni wordpress
		 */
		protected $pagetitle       = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		protected $menutitle       = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		protected $menuslug        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		protected $capability      = SZ_PLUGIN_GOOGLE_VALUE_CAPABILITY;
		protected $parentslug      = SZ_PLUGIN_GOOGLE_ADMIN_BASENAME;
		protected $titlefix        = SZ_PLUGIN_GOOGLE_VALUE_TITLEFIX;
		protected $sections        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		protected $sectionstitle   = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		protected $sectionsoptions = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		protected $validate        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		protected $callback        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		protected $callbackstart   = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		protected $callbacksection = SZ_PLUGIN_GOOGLE_VALUE_NULL;

		/**
		 * Definizione della funzione costruttore che viene richiamata
		 * nel momento della creazione di un'istanza con questa classe
		 */
		function __construct()
		{
			// Impostazione variabili per la corretta esecuzione del modulo,
			// posso essere ridefinite nella funzione moduleSetup()

			$this->validate        = array($this,'moduleValidate');
			$this->callback        = array($this,'moduleCallback');
			$this->callbackstart   = array($this,'moduleCallbackStart');
			$this->callbacksection = array($this,'moduleCallbackSection');

			// Definizione delle azioni wordpress per la creazione del 
			// menu di amministrazione e del form delle opzioni collegate

			add_action('admin_menu',array($this,'moduleAddMenu'));
			add_action('admin_init',array($this,'moduleAddFields'));
 		}

		/**
		 * Creazione del menu sul pannello di amministrazione usando
		 * come valori di configurazione le variabili object
		 *
		 * @return void
		 */
		function moduleAddMenu()
		{
			if (function_exists('add_submenu_page')) 
			{
				$pagehook = add_submenu_page($this->parentslug,$this->titlefix.$this->pagetitle,
					$this->menutitle,$this->capability,$this->menuslug,$this->callback);
				add_action('admin_print_scripts-'.$pagehook,array($this,'moduleAddJavascriptPlugins'));
			}
 		}

		/**
		 * Impostazione delle variabili per le opzioni che devono
		 * essere elencate nella schermata di amministrazione wordpress
		 *
		 * @return void
		 */
		function moduleAddFields()
		{
 		}

		/**
		 * Chiamata alla funzione generale per la creazione del form generale
		 * le sezioni devono essere passate come un array con nome => titolo
		 *
		 * @return void
		 */
		function moduleCallback()
		{
			$this->moduleCommonForm($this->sectionstitle,$this->sectionsoptions,$this->sections); 
		}

		/**
		 * Definizione di una callback dummy per la sezione che viene
		 * elaborata durante la definizione delle sezioni e campi di input
		 *
		 * @return void
		 */
		function moduleCallbackStart()
		{
		}

		/**
		 * Definizione di una callback dummy per la sezione che viene
		 * elaborata durante la definizione delle sezioni e campi di input
		 *
		 * @return void
		 */
		function moduleCallbackSection()
		{
		}

		/**
		 * Definizione di un validatore dummy per la sezione che viene
		 * elaborata durante la definizione delle sezioni e campi di input
		 *
		 * @return void
		 */
		function moduleValidate($options) {
	  		return $options;
		}

		/**
		 * Aggiungere i plugin javascript necessari solo nelle pagine
		 * di amministrazione legate al plugin sz-google e relativo caricamento
		 *
		 * @return void
		 */
		function moduleAddJavascriptPlugins() 
		{
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('postbox');
			wp_enqueue_script('utils');
			wp_enqueue_script('dashboard');
			wp_enqueue_script('thickbox');
		}

		/**
		 * Definizione funzione per disegnare il form generale delle
		 * pagine presenti nel pannello di amministrazione con opzioni del plugin
		 *
		 * @return void
		 */
		function moduleCommonForm($title,$setting,$sections,$documentation=false)
		{
			echo '<div id="sz-google-wrap" class="wrap">';
			echo '<h2>'.ucwords($title).'</h2>';

			if (!$documentation) echo '<p>'.ucfirst(__('overriding the default settings with your own specific preferences','szgoogleadmin')).'</p>';
				else echo '<p>'.ucfirst(__('select the module documentation to read','szgoogleadmin')).'</p>';

			// Contenitore principale con zona dedicata ai parametri di configurazione
			// definiti tramite le chiamate dei singoli moduli attivati da pannello ammnistrativo

			echo '<div class="postbox-container" id="sz-google-admin-options">';
			echo '<div class="metabox-holder">';
			echo '<div class="meta-box-sortables ui-sortable" id="sz-google-box">';

			// Se la chiamata contiene un array di documentazione posso disattivare
			// il form per la modifica di parametri dato che si tratta di solo lettura

			if (!$documentation) {
				echo '<form method="post" action="options.php" enctype="multipart/form-data">';
				echo '<input type="hidden" name="sz_google_options_plus[plus_redirect_flush]" value="0">';
			}

			// Se la chiamata non contiene un array di documentazione eseguo
			// la creazione del codice HTML con tutti i campi opzione da modificare

			settings_fields($setting);

			foreach ($sections as $section => $title) 
			{
				echo '<div class="postbox'; if ($documentation) echo " closed";
				echo '">';
				echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
				echo '<h3 class="hndle"><span>'.$title.'</span></h3>';
				echo '<div class="inside">';
				do_settings_sections($section);
				echo '</div>';
				echo '</div>';
			}	

			// Se la chiamata contiene un array di documentazione posso disattivare
			// il form per la modifica di parametri dato che si tratta di solo lettura

			if (!$documentation) {
				echo '<p class="submit"><input name="Submit" type="submit" class="button-primary" value="'.ucfirst(__('save changes','szgoogleadmin')).'"/></p>';
				echo '</form>';
			}

			echo '</div>';
			echo '</div>';
			echo '</div>';

			// Contenitore secondario con informazioni degli autori e alcuni link
			// come ad esempio la community di  wordpress italiana for ever :)

			echo '<div class="postbox-container" id="sz-google-admin-sidebar">';
			echo '<div class="metabox-holder">';
			echo '<div class="meta-box-sortables ui-sortable">';

			// Sezione su sidebar per "Dacci un piccolo aiuto"

			echo '<div id="help-us" class="postbox">';
			echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
			echo '<h3 class="hndle"><span><strong>'.ucwords(__('give us a little help','szgoogleadmin')).'</strong></span></h3>';
			echo '<div class="inside">';
			echo '<ul>';
			echo '<li><a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/sz-google">'.ucfirst(__('rate the plugin','szgoogleadmin')).'</a></li>';
			echo '<li><a target="_blank" href="https://plus.google.com/communities/109254048492234113886">'.ucfirst(__('join our community','szgoogleadmin')).'</a></li>';
			echo '<li><a target="_blank" href="https://plus.google.com/+wpitalyplus">'.ucfirst(__('join our google+ page','szgoogleadmin')).'</a></li>';
			echo '</ul>';
			echo '</div>';
			echo '</div>';

			// Sezione su sidebar per "pagina ufficiale"

			echo '<div id="official-plugin" class="postbox">';
			echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
			echo '<h3 class="hndle"><span><strong>'.ucwords(__('official page','szgoogleadmin')).'</strong></span></h3>';
			echo '<div class="inside">';
			echo '<a target="_blank" href="https://plus.google.com/+wpitalyplus"><img src="'.SZ_PLUGIN_GOOGLE_PATH_IMAGE.'wpitalyplus.png'.'" alt="WordPress Italy+" style="width:100%;height:auto;vertical-align:bottom;"></a>';
			echo '</div>';
			echo '</div>';

			// Sezione su sidebar per "Richiesta di supporto"

			echo '<div id="support-plugin" class="postbox">';
			echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
			echo '<h3 class="hndle"><span><strong>'.ucwords(__('support','szgoogleadmin')).'</strong></span></h3>';
			echo '<div class="inside">';
			echo '<ul>';
			echo '<li><a target="_blank" href="http://wordpress.org/support/plugin/sz-google">'.ucfirst(__('support for bugs and reports','szgoogleadmin')).'</a></li>';
			echo '<li><a target="_blank" href="https://plus.google.com/communities/109254048492234113886">'.ucfirst(__('support for new requests','szgoogleadmin')).'</a></li>';
			echo '</ul>';
			echo '</div>';
			echo '</div>';

			// Sezione su sidebar per "Autori del plugin"

			echo '<div id="authors-plugin" class="postbox">';
			echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
			echo '<h3 class="hndle"><span><strong>'.ucwords(__('authors','szgoogleadmin')).'</strong></span></h3>';
			echo '<div class="inside">';
			echo '<ul>';
			echo '<li><a target="_blank" href="https://plus.google.com/+EugenioPetullà">Eugenio Petullà</a></li>';
			echo '<li><a target="_blank" href="https://plus.google.com/+MassimoDellaRovere">Massimo Della Rovere</a></li>';
			echo '</ul>';
			echo '</div>';
			echo '</div>';

			// Sezione su sidebar per "Informazioni sul plugin"

			echo '<div id="info-plugin" class="postbox">';
			echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
			echo '<h3 class="hndle"><span><strong>'.ucwords(__('latest news','szgoogleadmin')).'</strong></span></h3>';
			echo '<div class="inside">';
			echo '<ul>';
			echo '<li><a target="_blank" href="https://plus.google.com/+wpitalyplus">'.ucfirst(__('news:','szgoogleadmin'))."&nbsp;".ucfirst(__('official page','szgoogleadmin')).'</a></li>';
			echo '<li><a target="_blank" href="https://wpitalyplus.com">'.ucfirst(__('news:','szgoogleadmin'))."&nbsp;".ucfirst(__('official website','szgoogleadmin')).'</a></li>';
			echo '<li><a target="_blank" href="https://plus.google.com/communities/109254048492234113886">'.ucfirst(__('news:','szgoogleadmin'))."&nbsp;".ucfirst(__('community WordPress','szgoogleadmin')).'</a></li>';
			echo '<li><a target="_blank" href="http://www.youtube.com/user/wpitalyplus?sub_confirmation=1">'.ucfirst(__('news:','szgoogleadmin'))."&nbsp;".ucfirst(__('youtube channel','szgoogleadmin')).'</a></li>';
			echo '<li><a target="_blank" href="https://startbyzero.com/wordpress/plugin-google/">'.ucfirst(__('news:','szgoogleadmin'))."&nbsp;".ucfirst(__('official documentation','szgoogleadmin')).'</a></li>';
			echo '</ul>';
			echo '</div>';
			echo '</div>';

			// Sezione su sidebar chiusura

			echo '</div>';
			echo '</div>';
			echo '</div>';

			echo '</div>';
		}

		/**
		 * Definizione funzione per disegnare il form generale delle pagine
		 * presenti nel pannello di amministrazione con opzioni del plugin
		 *
		 * @return void
		 */
		function moduleCommonFormDescription($description) 
		{
			echo '<tr valign="top"><td class="description" colspan="2">';
			echo ucfirst(trim($description));
			echo '</td></tr>';
		}

		function moduleCommonFormText($optionset,$name,$class='medium',$placeholder='') 
		{	
			$options = get_option($optionset);

			if (!isset($options[$name])) $options[$name] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
				else $options[$name] =  esc_html($options[$name]);

			echo '<input name="'.$optionset.'['.$name.']" type="text" class="'.$class.'" ';
			echo 'value="'.$options[$name].'" placeholder="'.$placeholder.'"/>';
		}

		function moduleCommonFormSelect($optionset,$name,$values,$class='medium',$placeholder='') 
		{
			$options = get_option($optionset);

			if (!isset($options[$name])) $options[$name] = ""; 
			if (!isset($options['plus_language'])) $options['plus_language'] = '99';

			echo '<select name="'.$optionset.'['.$name.']" class="'.$class.'">';

			foreach ($values as $key=>$value) {
				$selected = ($options[$name] == $key) ? ' selected = "selected"' : '';
				echo '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
			}

			echo '</select>';
		}

		function moduleCommonFormCheckboxYesNo($optionset,$name,$class='medium') 
		{
			$options = get_option($optionset);

			if (!isset($options[$name])) $options[$name] = '0';

			echo '<label class="sz-google"><input name="'.$optionset.'['.$name.']" type="checkbox" value="1" ';
			echo 'class="'.$class.'" '.checked(1,$options[$name],false).'/><span class="checkbox" style="display:none">'.__('YES / NO','szgoogleadmin').'</span></label>';
		}

		function moduleCommonFormCheckboxYN($optionset,$name,$class='small') 
		{
			$options = get_option($optionset);

			if (!isset($options[$name])) $options[$name] = '0';

			echo '<label class="sz-google"><input name="'.$optionset.'['.$name.']" type="checkbox" value="1" ';
			echo 'class="'.$class.'" '.checked(1,$options[$name],false).'/><span class="checkbox checkboxsmall" style="display:none">'.__('Y/N','szgoogleadmin').'</span></label>';
		}

		function moduleCommonFormNumberStep1($optionset,$name,$class='medium',$placeholder='') 
		{
			$options = get_option($optionset);

			if (!isset($options[$name])) $options[$name]=""; 

			echo '<input name="'.$optionset.'['.$name.']" type="number" step="1" class="'.$class.'" ';
			echo 'value="'.$options[$name].'" placeholder="'.$placeholder.'"/>';
		}
	}
}