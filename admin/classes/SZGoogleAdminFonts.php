<?php
/**
 * Modulo GOOGLE FONTS per la definizione delle funzioni che riguardano
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
if (!class_exists('SZGoogleAdminFonts'))
{
	class SZGoogleAdminFonts extends SZGoogleAdmin
	{
		/**
		 * Definizione delle variabili che contengono le configurazioni
		 * specifiche sulla creazione dell'istanza corrente
		 */
		protected $fontslist = '';

		/**
		 * Creazione del menu sul pannello di amministrazione usando
		 * come valori di configurazione le variabili object
		 *
		 * @return void
		 */
		function moduleAddMenu()
		{
			$this->menuslug   = 'sz-google-admin-fonts.php';
			$this->pagetitle  = ucwords(__('google fonts','szgoogleadmin'));
			$this->menutitle  = ucwords(__('google fonts','szgoogleadmin'));

			// Definizione delle sezioni che devono essere composte in HTML
			// le sezioni devono essere passate come un array con nome => titolo

			$this->sectionstabs = array(
				'01' => array('anchor' => 'general' ,'description' => __('general','szgoogleadmin')),
				'02' => array('anchor' => 'header'  ,'description' => __('header' ,'szgoogleadmin')),
			);

			$this->sections = array(
				array('tab' => '01','section' => 'sz-google-admin-fonts.php'   ,'title' => ucwords(__('fonts loader','szgoogleadmin'))),
				array('tab' => '01','section' => 'sz-google-admin-fonts-BX.php','title' => ucwords(__('fonts general','szgoogleadmin'))),
				array('tab' => '02','section' => 'sz-google-admin-fonts-HX.php','title' => ucwords(__('fonts headings','szgoogleadmin'))),
			);

			$this->sectionstitle   = $this->menutitle;
			$this->sectionsoptions = array('sz_google_options_fonts');

			// Richiamo la funzione della classe padre per elaborare le
			// variabili contenenti i valori di configurazione sezione
			
			parent::moduleAddMenu();
		}

		/**
		 * Funzione per aggiungere i campi del form con la corrispondenza
		 * delle opzioni specificate nel modulo attualmente utilizzato
		 *
		 * @return void
		 */
		function moduleAddFields()
		{
			// Definizione array generale contenente elenco delle sezioni
			// Su ogni sezione bisogna definire un array per elenco campi

			$this->sectionsmenu = array(
				'01' => array('section' => 'sz_google_fonts_section'   ,'title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-fonts.php'),
				'02' => array('section' => 'sz_google_fonts_section_BX','title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-fonts-BX.php'),
				'03' => array('section' => 'sz_google_fonts_section_HX','title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-fonts-HX.php'),
			);

			// Definizione array generale contenente elenco dei campi
			// che bisogna aggiungere alle sezioni precedentemente definite

			$this->sectionsfields = array
			(
				// Definizione sezione per configurazione GOOGLE FONTS BX

				'01' => array(
					array('field' => 'fonts_family_L1','title' => ucfirst(__('font family','szgoogleadmin')),'callback' => array($this,'get_fonts_family_L1')),
					array('field' => 'fonts_family_L2','title' => ucfirst(__('font family','szgoogleadmin')),'callback' => array($this,'get_fonts_family_L2')),
					array('field' => 'fonts_family_L3','title' => ucfirst(__('font family','szgoogleadmin')),'callback' => array($this,'get_fonts_family_L3')),
					array('field' => 'fonts_family_L4','title' => ucfirst(__('font family','szgoogleadmin')),'callback' => array($this,'get_fonts_family_L4')),
					array('field' => 'fonts_family_L5','title' => ucfirst(__('font family','szgoogleadmin')),'callback' => array($this,'get_fonts_family_L5')),
					array('field' => 'fonts_family_L6','title' => ucfirst(__('font family','szgoogleadmin')),'callback' => array($this,'get_fonts_family_L6')),
				),

				// Definizione sezione per configurazione GOOGLE FONTS BX

				'02' => array(
					array('field' => 'fonts_family_B1','title' => ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <body>'))      ,'callback' => array($this,'get_fonts_family_B1')),
					array('field' => 'fonts_family_P1','title' => ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <p>'))         ,'callback' => array($this,'get_fonts_family_P1')),
					array('field' => 'fonts_family_B2','title' => ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <blockquote>')),'callback' => array($this,'get_fonts_family_B2')),
				),

				// Definizione sezione per configurazione GOOGLE FONTS BX

				'03' => array(
					array('field' => 'fonts_family_H1','title' => ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h1>')),'callback' => array($this,'get_fonts_family_H1')),
					array('field' => 'fonts_family_H2','title' => ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h2>')),'callback' => array($this,'get_fonts_family_H2')),
					array('field' => 'fonts_family_H3','title' => ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h3>')),'callback' => array($this,'get_fonts_family_H3')),
					array('field' => 'fonts_family_H4','title' => ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h4>')),'callback' => array($this,'get_fonts_family_H4')),
					array('field' => 'fonts_family_H5','title' => ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h5>')),'callback' => array($this,'get_fonts_family_H5')),
					array('field' => 'fonts_family_H6','title' => ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h6>')),'callback' => array($this,'get_fonts_family_H6')),
				),
			);

			// Richiamo la funzione della classe padre per elaborare le
			// variabili contenenti i valori di configurazione sezione

			parent::moduleAddFields();
		}

		/**
		 * Funzione per leggere dal database json tutte le famiglie font
		 * disponibili sulla CDN di google font e ritorno lista in array
		 *
		 * @return $values
		 */
		function getGoogleFontsList()
		{
			// Se ho già eseguito l'operazione di lista fonts ritorno
			// array collegato alla variabile e salto elaborazione

			if($this->fontslist != '')
				return $this->fontslist;

			// Se è la prima volta che viene richiamata questa funziona
			// eseguo l'elaborazione del file data in formato json con fonts

			$file = file_get_contents(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/data/webfonts.json');
			$file = json_decode($file,true);

			$this->fontslist = array(
				'nofonts' => __('no fonts','szgoogleadmin')
			);

			foreach ($file['items'] as $key=>$name) {
				$fontsfamily = $name['family'];
				$this->fontslist[$fontsfamily] = $fontsfamily;
			}

			return $this->fontslist;
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_fonts_family_L1() 
		{
			$values = $this->getGoogleFontsList();
			$this->moduleCommonFormSelect('sz_google_options_fonts','fonts_family_L1_name',$values,'medium','');
			$this->moduleCommonFormDescription(__('specify the name of a font to create download from google CDN. This option is only concerned of loading, the assignment you have to manually enter in your CSS file. If you want to do it all automatically use the options found below.','szgoogleadmin'));
		}

		function get_fonts_family_L2() 
		{
			$values = $this->getGoogleFontsList();
			$this->moduleCommonFormSelect('sz_google_options_fonts','fonts_family_L2_name',$values,'medium','');
			$this->moduleCommonFormDescription(__('specify the name of a font to create download from google CDN. This option is only concerned of loading, the assignment you have to manually enter in your CSS file. If you want to do it all automatically use the options found below.','szgoogleadmin'));
		}

		function get_fonts_family_L3() 
		{
			$values = $this->getGoogleFontsList();
			$this->moduleCommonFormSelect('sz_google_options_fonts','fonts_family_L3_name',$values,'medium','');
			$this->moduleCommonFormDescription(__('specify the name of a font to create download from google CDN. This option is only concerned of loading, the assignment you have to manually enter in your CSS file. If you want to do it all automatically use the options found below.','szgoogleadmin'));
		}

		function get_fonts_family_L4() 
		{
			$values = $this->getGoogleFontsList();
			$this->moduleCommonFormSelect('sz_google_options_fonts','fonts_family_L4_name',$values,'medium','');
			$this->moduleCommonFormDescription(__('specify the name of a font to create download from google CDN. This option is only concerned of loading, the assignment you have to manually enter in your CSS file. If you want to do it all automatically use the options found below.','szgoogleadmin'));
		}

		function get_fonts_family_L5() 
		{
			$values = $this->getGoogleFontsList();
			$this->moduleCommonFormSelect('sz_google_options_fonts','fonts_family_L5_name',$values,'medium','');
			$this->moduleCommonFormDescription(__('specify the name of a font to create download from google CDN. This option is only concerned of loading, the assignment you have to manually enter in your CSS file. If you want to do it all automatically use the options found below.','szgoogleadmin'));
		}

		function get_fonts_family_L6() 
		{
			$values = $this->getGoogleFontsList();
			$this->moduleCommonFormSelect('sz_google_options_fonts','fonts_family_L6_name',$values,'medium','');
			$this->moduleCommonFormDescription(__('specify the name of a font to create download from google CDN. This option is only concerned of loading, the assignment you have to manually enter in your CSS file. If you want to do it all automatically use the options found below.','szgoogleadmin'));
		}

		function get_fonts_family_B1()
		{
			$values = $this->getGoogleFontsList();
			$this->moduleCommonFormSelect('sz_google_options_fonts','fonts_family_B1_name',$values,'medium','');
			$this->moduleCommonFormDescription(__('choose the font name to associate with the HTML indicated, the plugin will generate the code to download the font from the google CDN and CSS code to link with the specified HTML element. It is not necessary to change the original CSS file.','szgoogleadmin'));
		}

		function get_fonts_family_P1()
		{
			$values = $this->getGoogleFontsList();
			$this->moduleCommonFormSelect('sz_google_options_fonts','fonts_family_P1_name',$values,'medium','');
			$this->moduleCommonFormDescription(__('choose the font name to associate with the HTML indicated, the plugin will generate the code to download the font from the google CDN and CSS code to link with the specified HTML element. It is not necessary to change the original CSS file.','szgoogleadmin'));
		}

		function get_fonts_family_B2()
		{
			$values = $this->getGoogleFontsList();
			$this->moduleCommonFormSelect('sz_google_options_fonts','fonts_family_B2_name',$values,'medium','');
			$this->moduleCommonFormDescription(__('choose the font name to associate with the HTML indicated, the plugin will generate the code to download the font from the google CDN and CSS code to link with the specified HTML element. It is not necessary to change the original CSS file.','szgoogleadmin'));
		}

		function get_fonts_family_H1()
		{
			$values = $this->getGoogleFontsList();
			$this->moduleCommonFormSelect('sz_google_options_fonts','fonts_family_H1_name',$values,'medium','');
			$this->moduleCommonFormDescription(__('choose the font name to associate with the HTML indicated, the plugin will generate the code to download the font from the google CDN and CSS code to link with the specified HTML element. It is not necessary to change the original CSS file.','szgoogleadmin'));
		}

		function get_fonts_family_H2()
		{
			$values = $this->getGoogleFontsList();
			$this->moduleCommonFormSelect('sz_google_options_fonts','fonts_family_H2_name',$values,'medium','');
			$this->moduleCommonFormDescription(__('choose the font name to associate with the HTML indicated, the plugin will generate the code to download the font from the google CDN and CSS code to link with the specified HTML element. It is not necessary to change the original CSS file.','szgoogleadmin'));
		}

		function get_fonts_family_H3()
		{
			$values = $this->getGoogleFontsList();
			$this->moduleCommonFormSelect('sz_google_options_fonts','fonts_family_H3_name',$values,'medium','');
			$this->moduleCommonFormDescription(__('choose the font name to associate with the HTML indicated, the plugin will generate the code to download the font from the google CDN and CSS code to link with the specified HTML element. It is not necessary to change the original CSS file.','szgoogleadmin'));
		}

		function get_fonts_family_H4()
		{
			$values = $this->getGoogleFontsList();
			$this->moduleCommonFormSelect('sz_google_options_fonts','fonts_family_H4_name',$values,'medium','');
			$this->moduleCommonFormDescription(__('choose the font name to associate with the HTML indicated, the plugin will generate the code to download the font from the google CDN and CSS code to link with the specified HTML element. It is not necessary to change the original CSS file.','szgoogleadmin'));
		}

		function get_fonts_family_H5()
		{
			$values = $this->getGoogleFontsList();
			$this->moduleCommonFormSelect('sz_google_options_fonts','fonts_family_H5_name',$values,'medium','');
			$this->moduleCommonFormDescription(__('choose the font name to associate with the HTML indicated, the plugin will generate the code to download the font from the google CDN and CSS code to link with the specified HTML element. It is not necessary to change the original CSS file.','szgoogleadmin'));
		}

		function get_fonts_family_H6()
		{
			$values = $this->getGoogleFontsList();
			$this->moduleCommonFormSelect('sz_google_options_fonts','fonts_family_H6_name',$values,'medium','');
			$this->moduleCommonFormDescription(__('choose the font name to associate with the HTML indicated, the plugin will generate the code to download the font from the google CDN and CSS code to link with the specified HTML element. It is not necessary to change the original CSS file.','szgoogleadmin'));
		}
	}
}