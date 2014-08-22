<?php
/**
 * Classe SZGoogleAdmin per la creazione di istanze che controllino le
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
if (!class_exists('SZGoogleAdmin'))
{
	class SZGoogleAdmin
	{
		/**
		 * Definizione delle variabili che contengono le configurazioni
		 * da applicare alle varie chiamate delle funzioni wordpress
		 */
		protected $titlefix        = 'SZ-Google - ';
		protected $capability      = 'manage_options';
		protected $parentslug      = 'sz-google-admin.php';

		/**
		 * Definizione delle variabili che contengono le configurazioni
		 * da applicare alle varie chiamate delle funzioni wordpress
		 */
		protected $null            = '';
		protected $pagetitle       = '';
		protected $menutitle       = '';
		protected $menuslug        = '';
		protected $sections        = '';
		protected $sectionsmenu    = '';
		protected $sectionsfields  = '';
		protected $sectionstabs    = '';
		protected $sectionstitle   = '';
		protected $sectionsgroup   = '';
		protected $sectionsoptions = '';
		protected $validate        = '';
		protected $callback        = '';
		protected $callbackstart   = '';
		protected $callbacksection = '';
		protected $formHTML        = '';
		protected $formsavebutton  = '1';

		/**
		 * Definizione delle variabili che contengono le impostazioni
		 * fatte durante la chiamata alla funzione moduleAddSetup()
		 */
		private $moduleClassName  = false;
		private $moduleOptions    = false;
		private $moduleOptionSet  = false;

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
			if (!is_array($this->sectionsoptions)) $this->sectionsoptions = array();
			if (!is_array($this->sectionsmenu))    $this->sectionsmenu    = array();
			if (!is_array($this->sectionsfields))  $this->sectionsfields  = array();

			// Caricamento delle opzioni in riferimento ad un gruppo
			// predefinito che verrà richiamato nel form finale

			foreach ($this->sectionsoptions as $value) { 
				register_setting($this->sectionsoptions[0],$value); 
			}				

			// Lettura array generale contenente elenco delle sezioni
			// Su ogni sezione bisogna definire un array per elenco campi

			foreach($this->sectionsmenu as $key=>$value) {
				add_settings_section($value['section'],$value['title'],$value['callback'],$value['slug']);
			}

			// Lettura array generale contenente elenco dei campi
			// che bisogna aggiungere alle sezioni precedentemente definite

			foreach($this->sectionsfields as $key=>$sectionsfield) {
				foreach($sectionsfield as $value) {
					add_settings_field($value['field'],$value['title'],$value['callback'],$this->sectionsmenu[$key]['slug'],$this->sectionsmenu[$key]['section']);
				}
			}
 		}

		/**
		 * Chiamata alla funzione generale per la creazione del form generale
		 * le sezioni devono essere passate come un array con nome => titolo
		 *
		 * @return void
		 */
		function moduleCallback()
		{
			$this->moduleCommonForm(
				$this->sectionstitle,$this->sectionsoptions,
				$this->sections,$this->formsavebutton,$this->formHTML
			); 
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
		 * Calcolo il nome della pagina di amministrazione attuale
		 * che può essere utile per il caricamento di moduli specifici
		 *
		 * @return string
		 */
		function moduleAdminGetPageNow() {
			global $pagenow;
			return $pagenow;
		}

		/**
		 * Calcolo il nome della pagina di amministrazione attuale
		 * che può essere utile per il caricamento di moduli specifici
		 *
		 * @return string
		 */
		function moduleAdminGetAdminPage() {
			if (isset($_GET['page'])) return $_GET['page']; 
				else return '';
		}

		/**
		 * Calcolo le opzioni legate al modulo con esecuzione dei 
		 * controlli formali di coerenza e impostazione dei default
		 *
		 * @return array
		 */
		function getOptions()
		{ 
			if ($this->moduleOptions) return $this->moduleOptions;
				else $this->moduleOptions = $this->getOptionsSet($this->moduleOptionSet);

			// Ritorno indietro il gruppo di opzioni corretto dai
			// controlli formali eseguito dalla funzione di controllo

			return $this->moduleOptions;
		}

		/**
		 * Calcolo le opzioni legate al modulo con esecuzione dei 
		 * controlli formali di coerenza e impostazione dei default
		 *
		 * @return array
		 */
		function getOptionsSet($nameset)
		{
			$optionsDB   = get_option($nameset);
			$optionsList = include(dirname(SZ_PLUGIN_GOOGLE_MAIN)."/options/{$nameset}.php");

			// Controllo delle opzioni in caso di valori non esistenti
			// richiamo della funzione per il controllo isset()

			foreach($optionsList as $key => $item) 
			{
				// Controllo esistenza campo in elenco opzioni wordpress
				// in caso contrario aggiungo il campo in array orginale

				if (!isset($optionsDB[$key])) $optionsDB[$key] = $item['value'];

				// Controllo se il campo opzione contiene un valore di NULL
				// in questo caso assegno al valore opzione quello di default

				if (isset($item['N']) and $item['N'] == '1') {
					if ($optionsDB[$key] == '') $optionsDB[$key] = $item['value'];
				}

				// Controllo se il campo opzione contiene un valore di ZERO
				// in questo caso assegno al valore opzione quello di default

				if (isset($item['Z']) and $item['Z'] == '1') {
					if ($optionsDB[$key] == '0') $optionsDB[$key] = $item['value'];
				}

				// Controllo se il campo opzione contiene un valore di YES/NO
				// in questo caso assegno al valore opzione quello di default

				if (isset($item['Y']) and $item['Y'] == '1') {
					if (!in_array($optionsDB[$key],array('1','0'))) $optionsDB[$key] = '0';
				}
			}

			// Ritorno elenco opzioni collegate al set specificato
			// conversione array in object per accesso diretto

			return (object) $optionsDB;
		}

		/**
		 * Funzioni per assegnazione valori che servono alla configurazione
		 * inziale del modulo come il nome della classe e il set di opzioni
		 */
		function moduleSetClassName($classname) { $this->moduleClassName = $classname; }
		function moduleSetOptionSet($nameset)   { $this->moduleOptionSet = $nameset;   }

		/**
		 * Definizione funzione per disegnare il form generale delle
		 * pagine presenti nel pannello di amministrazione con opzioni del plugin
		 *
		 * @return void
		 */
		function moduleCommonForm($title,$group,$sections,$formsavebutton,$HTML)
		{
			// Creazione codice HTML per contenitore principale a cui si 
			// aggiunge un titolo, le notifiche di sistema e gli eventuali tabs

			echo '<div id="sz-google-wrap" class="wrap">';
			echo '<h2>'.ucwords($title).'</h2>';

			// Emissione messaggi di setting dopo il titolo come ad esempio
			// il messaggio di aggiornamento opzioni in configurazione

			settings_errors();

			// Contenitore principale con zona dedicata ai parametri di configurazione
			// definiti tramite le chiamate dei singoli moduli attivati da pannello ammnistrativo

			echo '<div class="postbox-container" id="sz-google-admin-options">';
			echo '<div class="metabox-holder">';
			echo '<div class="meta-box-sortables ui-sortable" id="sz-google-box">';

			// Se la chiamata contiene un array di documentazione posso disattivare
			// il form per la modifica di parametri dato che si tratta di solo lettura

			if ($formsavebutton == '1') {
				echo '<form method="post" action="options.php" enctype="multipart/form-data">';
				echo '<input type="hidden" name="sz_google_options_plus[plus_redirect_flush]" value="0">';
			}

			// Se la chiamata non contiene un array di documentazione eseguo
			// la creazione del codice HTML con tutti i campi opzione da modificare

			if ($HTML != '') 
			{
				echo '<div class="postbox">'; 
				echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
				echo '<h3 class="hndle"><span>'.ucfirst(__('documentation','szgoogleadmin')).'</span></h3>';
				echo '<div class="inside">';
				echo '<div class="help">';
				echo $HTML;
				echo '</div>';
				echo '</div>';
				echo '</div>';

			} else {

				// Creazione sessione del form per aggiungere l'elenco dei
				// campi in hidden che sono necessari alla sottomissione

				settings_fields($group[0]);

				// Composizione modello con i tab specificati in sectionstabs
				// in caso contrario eseguo la composizione HTML delle sezioni

				if (is_array($this->sectionstabs)) 
				{
					// Composizione HTML del titolo H2 con i vari tab che
					// compongono la pagina di configurazione del modulo

					echo '<h2 id="sz-google-tab" class="nav-tab-wrapper">';

					foreach ($this->sectionstabs as $TABKey => $TABValue) {
						echo '<a class="nav-tab" ';
						echo 'id="sz-google-tab-'.$TABValue['anchor'].'" ';
						echo 'href="#'.$TABValue['anchor'].'"';
						echo '>'.ucfirst($TABValue['description']).'</a>';
					}
				
					echo '</h2>';

					// Per ogni tab che trovo in array disegno la sezione HTML
					// in modalità hidden che sarà attivata tramite selezione tab

					foreach ($this->sectionstabs as $TABKey => $TABValue) 
					{
						echo '<div class="sz-google-tab-div" id="sz-google-tab-div-'.$TABValue['anchor'].'">';

						foreach ($sections as $key => $value) 
						{
							if ($TABKey == $value['tab']) {
								echo '<div class="postbox">'; 
								echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
								echo '<h3 class="hndle"><span>'.$value['title'].'</span></h3>';
								echo '<div class="inside">';
								do_settings_sections($value['section']);
								echo '</div>';
								echo '</div>';
							}
						}

						echo '</div>';
					}

				// Composizione modello semplice senza leggere array dei tabs
				// scrivo le sezioni HTML in ordine di definizione standard

				} else {

					foreach ($sections as $key => $value)	
					{
						echo '<div class="postbox">'; 
						echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
						echo '<h3 class="hndle"><span>'.$value['title'].'</span></h3>';
						echo '<div class="inside">';
						do_settings_sections($value['section']);
						echo '</div>';
						echo '</div>';
					}
				}
			}

			// Se la chiamata contiene un array di documentazione posso disattivare
			// il form per la modifica di parametri dato che si tratta di solo lettura

			if ($formsavebutton == '1') {
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
			echo '<a target="_blank" href="https://plus.google.com/+wpitalyplus"><img src="'.plugin_dir_url(SZ_PLUGIN_GOOGLE_MAIN).'frontend/files/images/wpitalyplus.png'.'" alt="WordPress Italy+" style="width:100%;height:auto;vertical-align:bottom;"></a>';
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
			echo '<li><a target="_blank" href="https://otherplus.com/tech/sz-google/">'.ucfirst(__('news:','szgoogleadmin'))."&nbsp;".ucfirst(__('official website','szgoogleadmin')).'</a></li>';
			echo '<li><a target="_blank" href="https://plus.google.com/communities/109254048492234113886">'.ucfirst(__('news:','szgoogleadmin'))."&nbsp;".ucfirst(__('community WordPress','szgoogleadmin')).'</a></li>';
			echo '<li><a target="_blank" href="http://www.youtube.com/user/wpitalyplus?sub_confirmation=1">'.ucfirst(__('news:','szgoogleadmin'))."&nbsp;".ucfirst(__('youtube channel','szgoogleadmin')).'</a></li>';
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
		 * Descrizione opzione da inserire sotto il campo di input
		 * presente nel form generale delle pagine con le opzioni
		 *
		 * @return void
		 */
		function moduleCommonFormDescription($description) 
		{
			echo '</td></tr>';
			echo '<tr><td class="description" colspan="2">';
			echo ucfirst(trim($description));
		}

		/**
		 * Descrizione campo TEXT da inserire sotto il campo di input
		 * presente nel form generale delle pagine con le opzioni
		 *
		 * @return void
		 */
		function moduleCommonFormText($optionset,$name,$class='medium',$placeholder='') 
		{	
			$options = get_option($optionset);

			if (!isset($options[$name])) $options[$name] = '';
				else $options[$name] =  esc_html($options[$name]);

			echo '<input name="'.$optionset.'['.$name.']" type="text" class="'.$class.'" ';
			echo 'value="'.$options[$name].'" placeholder="'.$placeholder.'"/>';
		}

		/**
		 * Descrizione campo SELECT da inserire sotto il campo di input
		 * presente nel form generale delle pagine con le opzioni
		 *
		 * @return void
		 */
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

		/**
		 * Descrizione campo YES/NO da inserire sotto il campo di input
		 * presente nel form generale delle pagine con le opzioni
		 *
		 * @return void
		 */
		function moduleCommonFormCheckboxYesNo($optionset,$name,$class='medium') 
		{
			$options = get_option($optionset);

			if (!isset($options[$name])) $options[$name] = '0';

			echo '<input type="hidden" name="'.$optionset.'['.$name.']" value="0"/>';
			echo '<label class="sz-google"><input name="'.$optionset.'['.$name.']" type="checkbox" value="1" ';
			echo 'class="'.$class.'" '.checked(1,$options[$name],false).'/><span class="checkbox" style="display:none">'.__('YES / NO','szgoogleadmin').'</span></label>';
		}

		/**
		 * Descrizione campo NUMERIC da inserire sotto il campo di input
		 * presente nel form generale delle pagine con le opzioni
		 *
		 * @return void
		 */
		function moduleCommonFormNumberStep1($optionset,$name,$class='medium',$placeholder='') 
		{
			$options = get_option($optionset);

			if (!isset($options[$name])) $options[$name]=""; 

			echo '<input name="'.$optionset.'['.$name.']" type="number" step="1" class="'.$class.'" ';
			echo 'value="'.$options[$name].'" placeholder="'.$placeholder.'"/>';
		}
	}
}
