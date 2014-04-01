<?php
/**
 * Modulo GOOGLE DOCUMENTATION per la definizione delle funzioni che riguardano
 * sia i widget che i shortcode ma anche filtri e azioni che il modulo
 * può integrare durante l'aggiunta di funzionalità a wordpress.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Prima della definizione della classe controllo se esiste
 * una definizione con lo stesso nome o già definita la stessa.
 */
if (!class_exists('SZGoogleAdminDocumentation'))
{
	class SZGoogleAdminDocumentation extends SZGoogleAdmin
	{
		/**
		 * Definizione delle variabili che contengono le configurazioni
		 * da applicare alle varie elaborazione della classe attuale
		 */
		protected $HelpIndexItems = SZ_PLUGIN_GOOGLE_VALUE_NULL;

		/**
		 * Creazione del menu sul pannello di amministrazione usando
		 * come valori di configurazione le variabili object
		 *
		 * @return void
		 */
		function moduleAddMenu()
		{
			$this->menuslug   = 'sz-google-admin-documentation.php';
			$this->pagetitle  = ucwords(__('documentation','szgoogleadmin'));
			$this->menutitle  = ucwords(__('documentation','szgoogleadmin'));

			// Definizione delle sezioni che devono essere composte in HTML
			// le sezioni devono essere passate come un array con nome => titolo

			$this->sections = array(
				'sz-google-admin-documentation-gplus.php'         => ucwords(__('google+','szgoogleadmin')),
				'sz-google-admin-documentation-analytics.php'     => ucwords(__('google analytics','szgoogleadmin')),
				'sz-google-admin-documentation-authenticator.php' => ucwords(__('google authenticator','szgoogleadmin')),
				'sz-google-admin-documentation-calendar.php'      => ucwords(__('google calendar','szgoogleadmin')),
				'sz-google-admin-documentation-drive.php'         => ucwords(__('google drive','szgoogleadmin')),
				'sz-google-admin-documentation-groups.php'        => ucwords(__('google groups','szgoogleadmin')),
				'sz-google-admin-documentation-hangouts.php'      => ucwords(__('google hangouts','szgoogleadmin')),
				'sz-google-admin-documentation-panoramio.php'     => ucwords(__('google panoramio','szgoogleadmin')),
				'sz-google-admin-documentation-translate.php'     => ucwords(__('google translate','szgoogleadmin')),
				'sz-google-admin-documentation-youtube.php'       => ucwords(__('youtube','szgoogleadmin')),
			);

			$this->sectionstitle   = $this->menutitle;
			$this->sectionsoptions = 'sz_google_options_documentation';
			$this->formsavebutton  = SZ_PLUGIN_GOOGLE_VALUE_NO;

			// Richiamo la funzione della classe padre per elaborare le
			// variabili contenenti i valori di configurazione sezione

			parent::moduleAddMenu();

			// Creazione indice di documentazione per la composizione del navigatore

			$this->HelpIndexItems = array(
					array('slug'=>'sz-google-help-plus-profile.php'           ,'title'=>__('google+ badge profile'     ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-plus-page.php'              ,'title'=>__('google+ badge page'        ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-plus-community.php'         ,'title'=>__('google+ badge community'   ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-plus-plusone.php'           ,'title'=>__('google+ button +1'         ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-plus-share.php'             ,'title'=>__('google+ button share'      ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-plus-follow.php'            ,'title'=>__('google+ button follow'     ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-plus-comments.php'          ,'title'=>__('google+ widget comments'   ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-plus-post.php'              ,'title'=>__('google+ embedded post'     ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-plus-followers.php'         ,'title'=>__('google+ badge followers'   ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-plus-author-publisher.php'  ,'title'=>__('google+ author & publisher','szgoogleadmin')),
					array('slug'=>'sz-google-help-plus-redirect.php'          ,'title'=>__('google+ redirect'          ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-plus-recommendations.php'   ,'title'=>__('google+ recommendations'   ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-ga-setup.php'               ,'title'=>__('analytics setup'           ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-ga-functions.php'           ,'title'=>__('analytics PHP functions'   ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-authenticator-setup.php'    ,'title'=>__('authenticator setup'       ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-authenticator-functions.php','title'=>__('authenticator PHP'         ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-authenticator-device.php'   ,'title'=>__('authenticator device'      ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-calendar.php'               ,'title'=>__('widget calendar'           ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-drive-embed.php'            ,'title'=>__('drive embed'               ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-drive-viewer.php'           ,'title'=>__('drive viewer'              ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-drive-save.php'             ,'title'=>__('drive save button'         ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-groups.php'                 ,'title'=>__('widget groups'             ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-hangout-start.php'          ,'title'=>__('hangout start button'      ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-panoramio.php'              ,'title'=>__('widget panoramio'          ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-translate.php'              ,'title'=>__('translate setup'           ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-translate-functions.php'    ,'title'=>__('translate PHP functions'   ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-youtube-video.php'          ,'title'=>__('youtube video'             ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-youtube-playlist.php'       ,'title'=>__('youtube playlist'          ,'szgoogleadmin')),
					array('slug'=>'sz-google-help-youtube-link.php'           ,'title'=>__('youtube link'              ,'szgoogleadmin')),
			);
 		}

		/**
		 * Chiamata alla funzione generale per la creazione del form generale
		 * le sezioni devono essere passate come un array con nome => titolo
		 *
		 * @return void
		 */
		function moduleCallback()
		{
			// Controllo se viene specificata una sezione di documentazione
			// help presente nella directory dei file e se questa risulta esistente

			if (isset($_GET['help'])) 
			{
				$LANGUAGE = get_bloginfo('language');
				$FILENAM1 = SZ_PLUGIN_GOOGLE_BASENAME_HELP.$LANGUAGE.'/'.trim($_GET['help']);
				$FILENAM2 = SZ_PLUGIN_GOOGLE_BASENAME_HELP.substr($LANGUAGE,0,2).'/'.trim($_GET['help']);
				$FILENAM3 = SZ_PLUGIN_GOOGLE_BASENAME_HELP.'en/'.trim($_GET['help']);

				if (is_readable($FILENAM1)) { @include($FILENAM1); return; }
				if (is_readable($FILENAM2)) { @include($FILENAM2); return; }
				if (is_readable($FILENAM3)) { @include($FILENAM3); return; }
			}

			// Se non trovo nessun file di documentazione specifico o 
			// semplicemente viene richiamata la pagina principale

			parent::moduleCallback();
		}

		/**
		 * Funzione per aggiungere i campi del form con la corrispondenza
		 * delle opzioni specificate nel modulo attualmente utilizzato
		 *
		 * @return void
		 */
		function moduleAddFields()
		{
			register_setting($this->sectionsoptions,$this->sectionsoptions);

			// Definizione sezione per configurazione GOOGLE DOCUMENTATION

			add_settings_section('sz_google_documentation_gplus'        ,'',array($this,'moduleAddHelpPlus')         ,'sz-google-admin-documentation-gplus.php');
			add_settings_section('sz_google_documentation_analytics'    ,'',array($this,'moduleAddHelpAnalytics')    ,'sz-google-admin-documentation-analytics.php');
			add_settings_section('sz_google_documentation_authenticator','',array($this,'moduleAddHelpAuthenticator'),'sz-google-admin-documentation-authenticator.php');
			add_settings_section('sz_google_documentation_calendar'     ,'',array($this,'moduleAddHelpCalendar')     ,'sz-google-admin-documentation-calendar.php');
			add_settings_section('sz_google_documentation_drive'        ,'',array($this,'moduleAddHelpDriveSave')    ,'sz-google-admin-documentation-drive.php');
			add_settings_section('sz_google_documentation_groups'       ,'',array($this,'moduleAddHelpGroups')       ,'sz-google-admin-documentation-groups.php');
			add_settings_section('sz_google_documentation_hangouts'     ,'',array($this,'moduleAddHelpHangouts')     ,'sz-google-admin-documentation-hangouts.php');
			add_settings_section('sz_google_documentation_panoramio'    ,'',array($this,'moduleAddHelpPanoramio')    ,'sz-google-admin-documentation-panoramio.php');
			add_settings_section('sz_google_documentation_translate'    ,'',array($this,'moduleAddHelpTranslate')    ,'sz-google-admin-documentation-translate.php');
			add_settings_section('sz_google_documentation_youtube'      ,'',array($this,'moduleAddHelpYoutube')      ,'sz-google-admin-documentation-youtube.php');
		}

		/**
		 * Funzione per aggiungere le icone di sezione con array
		 * contenete lo slug del link e il titolo della documentazione
		 */
		function moduleAddHelpLinks($options)
		{
			echo '<div class="help-index">';

			foreach ($options as $key => $value) 
			{
				echo '<div class="help-items">';
				echo '<div class="help-image"><a href="'.menu_page_url($this->menuslug,false).'&amp;help='.$value['slug'].'"><img src="'.SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'help/'.basename($value['slug'],".php").'.png" alt=""></a></div>';
				echo '<div class="help-title"><a href="'.menu_page_url($this->menuslug,false).'&amp;help='.$value['slug'].'">'.ucwords($value['title']).'</a></div>';
				echo '</div>';
			}

			echo '</div>';
		}

		/**
		 * Funzioni per aggiungere le varie sezioni che riguardano
		 * l'indice fatto ad icone della documentazione GOOGLE PLUS
		 */
		function moduleAddHelpPlus()
		{
			$this->moduleAddHelpLinks(array(
				array('slug'=>'sz-google-help-plus-profile.php'          ,'title'=>__('badge profile','szgoogleadmin')),
				array('slug'=>'sz-google-help-plus-page.php'             ,'title'=>__('badge page','szgoogleadmin')),
				array('slug'=>'sz-google-help-plus-community.php'        ,'title'=>__('badge community','szgoogleadmin')),
				array('slug'=>'sz-google-help-plus-plusone.php'          ,'title'=>__('button +1','szgoogleadmin')),
				array('slug'=>'sz-google-help-plus-share.php'            ,'title'=>__('button share','szgoogleadmin')),
				array('slug'=>'sz-google-help-plus-follow.php'           ,'title'=>__('button follow','szgoogleadmin')),
				array('slug'=>'sz-google-help-plus-comments.php'         ,'title'=>__('widget comments','szgoogleadmin')),
				array('slug'=>'sz-google-help-plus-post.php'             ,'title'=>__('embedded post','szgoogleadmin')),
				array('slug'=>'sz-google-help-plus-followers.php'        ,'title'=>__('badge followers','szgoogleadmin')),
				array('slug'=>'sz-google-help-plus-author-publisher.php' ,'title'=>__('author & publisher','szgoogleadmin')),
				array('slug'=>'sz-google-help-plus-redirect.php'         ,'title'=>__('redirect +','szgoogleadmin')),
				array('slug'=>'sz-google-help-plus-recommendations.php'  ,'title'=>__('recommendations','szgoogleadmin')),
			));
		}

		/**
		 * Funzioni per aggiungere le varie sezioni che riguardano
		 * l'indice fatto ad icone della documentazione GOOGLE ANALYTICS
		 */
		function moduleAddHelpAnalytics()
		{
			$this->moduleAddHelpLinks(array(
				array('slug'=>'sz-google-help-ga-setup.php'    ,'title'=>__('analytics setup','szgoogleadmin')),
				array('slug'=>'sz-google-help-ga-functions.php','title'=>__('analytics PHP functions','szgoogleadmin')),
			));
		}

		/**
		 * Funzioni per aggiungere le varie sezioni che riguardano
		 * l'indice fatto ad icone della documentazione GOOGLE AUTHENTICATOR
		 */
		function moduleAddHelpAuthenticator()
		{
			$this->moduleAddHelpLinks(array(
				array('slug'=>'sz-google-help-authenticator-setup.php'    ,'title'=>__('authenticator setup','szgoogleadmin')),
				array('slug'=>'sz-google-help-authenticator-functions.php','title'=>__('authenticator PHP','szgoogleadmin')),
				array('slug'=>'sz-google-help-authenticator-device.php'   ,'title'=>__('authenticator device','szgoogleadmin')),
			));
		}

		/**
		 * Funzioni per aggiungere le varie sezioni che riguardano
		 * l'indice fatto ad icone della documentazione GOOGLE CALENDAR
		 */
		function moduleAddHelpCalendar()
		{
			$this->moduleAddHelpLinks(array(
				array('slug'=>'sz-google-help-calendar.php','title'=>__('widget calendar','szgoogleadmin')),
			));
		}

		/**
		 * Funzioni per aggiungere le varie sezioni che riguardano
		 * l'indice fatto ad icone della documentazione GOOGLE DRIVE
		 */
		function moduleAddHelpDriveSave()
		{
			$this->moduleAddHelpLinks(array(
				array('slug'=>'sz-google-help-drive-embed.php' ,'title'=>__('drive embed','szgoogleadmin')),
				array('slug'=>'sz-google-help-drive-viewer.php','title'=>__('drive viewer','szgoogleadmin')),
				array('slug'=>'sz-google-help-drive-save.php'  ,'title'=>__('drive save button','szgoogleadmin')),
			));
		}

		/**
		 * Funzioni per aggiungere le varie sezioni che riguardano
		 * l'indice fatto ad icone della documentazione GOOGLE GROUPS
		 */
		function moduleAddHelpGroups()
		{
			$this->moduleAddHelpLinks(array(
				array('slug'=>'sz-google-help-groups.php','title'=>__('widget groups','szgoogleadmin')),
			));
		}

		/**
		 * Funzioni per aggiungere le varie sezioni che riguardano
		 * l'indice fatto ad icone della documentazione GOOGLE HANGOUTS
		 */
		function moduleAddHelpHangouts()
		{
			$this->moduleAddHelpLinks(array(
				array('slug'=>'sz-google-help-hangout-start.php','title'=>__('hangout start button','szgoogleadmin')),
			));
		}

		/**
		 * Funzioni per aggiungere le varie sezioni che riguardano
		 * l'indice fatto ad icone della documentazione GOOGLE PANORAMIO
		 */
		function moduleAddHelpPanoramio()
		{
			$this->moduleAddHelpLinks(array(
				array('slug'=>'sz-google-help-panoramio.php','title'=>__('widget panoramio','szgoogleadmin')),
			));
		}

		/**
		 * Funzioni per aggiungere le varie sezioni che riguardano
		 * l'indice fatto ad icone della documentazione GOOGLE TRANSLATE
		 */
		function moduleAddHelpTranslate()
		{
			$this->moduleAddHelpLinks(array(
				array('slug'=>'sz-google-help-translate.php'          ,'title'=>__('translate setup','szgoogleadmin')),
				array('slug'=>'sz-google-help-translate-functions.php','title'=>__('translate PHP functions','szgoogleadmin')),
			));
		}

		/**
		 * Funzioni per aggiungere le varie sezioni che riguardano
		 * l'indice fatto ad icone della documentazione GOOGLE YOUTUBE
		 */
		function moduleAddHelpYoutube()
		{
			$this->moduleAddHelpLinks(array(
				array('slug'=>'sz-google-help-youtube-video.php'   ,'title'=>__('youtube video'   ,'szgoogleadmin')),
				array('slug'=>'sz-google-help-youtube-playlist.php','title'=>__('youtube playlist','szgoogleadmin')),
				array('slug'=>'sz-google-help-youtube-link.php'    ,'title'=>__('youtube link'    ,'szgoogleadmin')),
			));
		}

		/**
		 * Chiamata alla funzione generale per la creazione del form generale
		 * le sezioni devono essere passate come un array con nome => titolo
		 *
		 * @return void
		 */
		function moduleAddNavs($name)
		{
			// Calcolo le chiavi per elementi presenti negli array che 
			// corrispondono a quello attuale, precedente e successivo.

			$KeyPrecedente = false;
			$KeyAttuale    = false;
			$KeySeguente   = false;

			foreach ($this->HelpIndexItems as $key => $value) {
				if($value['slug'] == $name) {
					$KeyAttuale = $key; break;
				}
			}

			if ($KeyAttuale > 0) $KeyPrecedente = $KeyAttuale - 1;
			if ($KeyAttuale < (count($this->HelpIndexItems)-1)) $KeySeguente = $KeyAttuale + 1;

			// Creazione dei link per successivo e seguente
			// Creazione codice HTML per il navigatore di help

			$LINKPREV = ''; $LINKNEXT = '';

			if ($KeyPrecedente !== false) $LINKPREV = '<a href="'.menu_page_url($this->menuslug,false).'&amp;help='.$this->HelpIndexItems[$KeyPrecedente]['slug'].'""><-- '.ucfirst($this->HelpIndexItems[$KeyPrecedente]['title']).'</a>';
			if ($KeySeguente   !== false) $LINKNEXT = '<a href="'.menu_page_url($this->menuslug,false).'&amp;help='.$this->HelpIndexItems[$KeySeguente]['slug'].'"">'.ucfirst($this->HelpIndexItems[$KeySeguente]['title']).' --></a>';

			$HTML  = '<div class="navs">';
			$HTML .= '<div class="prev">'.$LINKPREV.'</div>';
			$HTML .= '<div class="capo"><a href="'.menu_page_url($this->menuslug,false).'">'.$this->pagetitle.'</a></div>';
			$HTML .= '<div class="next">'.$LINKNEXT.'</div>';
			$HTML .= '</div>';

			return $HTML;
		}

		function moduleCommonFormHelp($title,$setting,$sections,$formsavebutton,$HTML,$slug)
		{
			$HTML .= $this->moduleAddNavs($slug);
			$this->moduleCommonForm($title,$setting,$sections,$formsavebutton,$HTML);
		}

	}
}