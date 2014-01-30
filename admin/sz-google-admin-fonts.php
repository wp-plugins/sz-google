<?php
/**
 * Modulo GOOGLE FONTS per la definizione delle funzioni che riguardano
 * sia i widget che i shortcode ma anche filtri e azioni che il modulo
 * può integrare durante l'aggiunta di funzionalità a wordpress.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE_ADMIN') or !SZ_PLUGIN_GOOGLE_ADMIN) die();

/**
 * Prima della definizione della classe controllo se esiste
 * una definizione con lo stesso nome o già definita la stessa.
 */
if (!class_exists('SZGoogleModuleAdminFonts'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleAdminModule
	 * dove bisogna ridefinire il metodo per il calcolo delle opzioni.
	 */
	class SZGoogleModuleAdminFonts extends SZGoogleModuleAdmin
	{
		/**
		 * Definizione delle variabili che contengono le configurazioni
		 * specifiche sulla creazione dell'istanza corrente
		 */
		protected $fontslist = SZ_PLUGIN_GOOGLE_VALUE_NULL;

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

			$this->sections = array(
				'sz-google-admin-fonts.php'       => ucwords(__('font setting loader','szgoogleadmin')),
				'sz-google-admin-fonts-BX.php'    => ucwords(__('font setting general','szgoogleadmin')),
				'sz-google-admin-fonts-HX.php'    => ucwords(__('font setting headings','szgoogleadmin')),
			);

			$this->sectionstitle   = ucfirst(__('google fonts configuration','szgoogleadmin'));
			$this->sectionsoptions = 'sz_google_options_fonts';

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
			register_setting($this->sectionsoptions,$this->sectionsoptions,$this->validate);

			// Definizione sezione per configurazione GOOGLE FONTS

			add_settings_section('sz_google_fonts_section','',$this->callbacksection,'sz-google-admin-fonts.php');
			add_settings_field('fonts_family_L1',ucfirst(__('font family','szgoogleadmin').' (1)'),array($this,'get_fonts_family_L1'),'sz-google-admin-fonts.php','sz_google_fonts_section');
			add_settings_field('fonts_family_L2',ucfirst(__('font family','szgoogleadmin').' (2)'),array($this,'get_fonts_family_L2'),'sz-google-admin-fonts.php','sz_google_fonts_section');
			add_settings_field('fonts_family_L3',ucfirst(__('font family','szgoogleadmin').' (3)'),array($this,'get_fonts_family_L3'),'sz-google-admin-fonts.php','sz_google_fonts_section');
			add_settings_field('fonts_family_L4',ucfirst(__('font family','szgoogleadmin').' (4)'),array($this,'get_fonts_family_L4'),'sz-google-admin-fonts.php','sz_google_fonts_section');
			add_settings_field('fonts_family_L5',ucfirst(__('font family','szgoogleadmin').' (5)'),array($this,'get_fonts_family_L5'),'sz-google-admin-fonts.php','sz_google_fonts_section');
			add_settings_field('fonts_family_L6',ucfirst(__('font family','szgoogleadmin').' (6)'),array($this,'get_fonts_family_L6'),'sz-google-admin-fonts.php','sz_google_fonts_section');

			// Definizione sezione per configurazione GOOGLE FONTS BX

			add_settings_section('sz_google_fonts_section_BX','',$this->callbacksection,'sz-google-admin-fonts-BX.php');
			add_settings_field('fonts_family_B1',ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <body>')),array($this,'get_fonts_family_B1'),'sz-google-admin-fonts-BX.php','sz_google_fonts_section_BX');
			add_settings_field('fonts_family_P1',ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <p>')),array($this,'get_fonts_family_P1'),'sz-google-admin-fonts-BX.php','sz_google_fonts_section_BX');
			add_settings_field('fonts_family_B2',ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <blockquote>')),array($this,'get_fonts_family_B2'),'sz-google-admin-fonts-BX.php','sz_google_fonts_section_BX');

			// Definizione sezione per configurazione GOOGLE FONTS HX

			add_settings_section('sz_google_fonts_section_HX','',$this->callbacksection,'sz-google-admin-fonts-HX.php');
			add_settings_field('fonts_family_H1',ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h1>')),array($this,'get_fonts_family_H1'),'sz-google-admin-fonts-HX.php','sz_google_fonts_section_HX');
			add_settings_field('fonts_family_H2',ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h2>')),array($this,'get_fonts_family_H2'),'sz-google-admin-fonts-HX.php','sz_google_fonts_section_HX');
			add_settings_field('fonts_family_H3',ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h3>')),array($this,'get_fonts_family_H3'),'sz-google-admin-fonts-HX.php','sz_google_fonts_section_HX');
			add_settings_field('fonts_family_H4',ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h4>')),array($this,'get_fonts_family_H4'),'sz-google-admin-fonts-HX.php','sz_google_fonts_section_HX');
			add_settings_field('fonts_family_H5',ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h5>')),array($this,'get_fonts_family_H5'),'sz-google-admin-fonts-HX.php','sz_google_fonts_section_HX');
			add_settings_field('fonts_family_H6',ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h6>')),array($this,'get_fonts_family_H6'),'sz-google-admin-fonts-HX.php','sz_google_fonts_section_HX');
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

			if($this->fontslist != SZ_PLUGIN_GOOGLE_VALUE_NULL)
				return $this->fontslist;

			// Se è la prima volta che viene richiamata questa funziona
			// eseguo l'elaborazione del file data in formato json con fonts

			$file = file_get_contents(SZ_PLUGIN_GOOGLE_BASENAME_DATA.'webfonts.json');
			$file = json_decode($file,true);

			$this->fontslist = array(
				SZ_PLUGIN_GOOGLE_FONTS_NULL => __('no fonts','szgoogleadmin')
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

	/**
	 * Creazione oggetto principale per creazione ed elaborazione del
	 * modulo richiesto con azioni iniziali specificate nel costruttore
	 */
	$SZ_GOOGLE_ADMIN_FONTS = new SZGoogleModuleAdminFonts();
}