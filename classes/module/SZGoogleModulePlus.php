<?php
/**
 * Modulo GOOGLE PLUS per la definizione delle funzioni che riguardano
 * sia i widget che i shortcode ma anche i filtri e le azioni che il modulo
 * può integrare durante l'aggiunta di funzionalità particolari a wordpress
 *
 * @package SZGoogle
 * @subpackage SZGoogleModule
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome

if (!class_exists('SZGoogleModulePlus'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleModule
	 */
	class SZGoogleModulePlus extends SZGoogleModule
	{
		protected $setMetaAuthor        = false;
		protected $setMetaPublisher     = false;
		protected $setJavascriptPlusone = false;

		/**
		 * Definizione delle variabili iniziali su array che servono
		 * ad indentificare il modulo e le opzioni ad esso collegate
		 */
		function moduleAddSetup()
		{
			$this->moduleSetClassName(__CLASS__);
			$this->moduleSetOptionSet('sz_google_options_plus');

			$this->moduleActions = array(
				'plus_author_badge'       => 'SZGoogleActionPlusAuthorBadge',
				'plus_comments_gp_enable' => 'SZGoogleActionPlusComments',
			);

			// Definizione degli shortcode collegati al modulo con un array in cui bisogna
			// specificare l'opzione di attivazione il nome dello shortcode e la funzione da eseguire

			$this->moduleSetShortcodes(array(
				'plus_shortcode_pr_enable'          => array('sz-gplus-profile'  ,array($this,'getPlusProfileShortcode')),
				'plus_shortcode_pa_enable'          => array('sz-gplus-page'     ,array($this,'getPlusPageShortcode')),
				'plus_shortcode_co_enable'          => array('sz-gplus-community',array($this,'getPlusCommunityShortcode')),
				'plus_shortcode_fl_enable'          => array('sz-gplus-followers',array($this,'getPlusFollowersShortcode')),
				'plus_button_enable_plusone'        => array('sz-gplus-one'      ,array($this,'getPlusPlusoneShortcode')),
				'plus_button_enable_sharing'        => array('sz-gplus-share'    ,array($this,'getPlusShareShortcode')),
				'plus_button_enable_follow'         => array('sz-gplus-follow'   ,array($this,'getPlusFollowShortcode')),
				'plus_comments_sh_enable'           => array('sz-gplus-comments' ,array($this,'getPlusCommentsShortcode')),
				'plus_post_enable_shortcode'        => array('sz-gplus-post'     ,array($this,'getPlusPostShortcode')),
			));

			$this->moduleSetWidgets(array(
				'plus_widget_pr_enable'             => 'SZGoogleWidgetPlusProfile',
				'plus_widget_pa_enable'             => 'SZGoogleWidgetPlusPage',
				'plus_widget_co_enable'             => 'SZGoogleWidgetPlusCommunity',
				'plus_widget_fl_enable'             => 'SZGoogleWidgetPlusFollowers',
				'plus_button_enable_widget_plusone' => 'SZGoogleWidgetPlusPlusone',
				'plus_button_enable_widget_sharing' => 'SZGoogleWidgetPlusShare',
				'plus_button_enable_widget_follow'  => 'SZGoogleWidgetPlusFollow',
				'plus_comments_wd_enable'           => 'SZGoogleWidgetPlusComments',
				'plus_post_enable_widget'           => 'SZGoogleWidgetPlusPost',
			));
		}

		/**
		 * Aggiungo le azioni necessarie al modulo corrente, questa funzione deve
		 * essere implementata non è possibile creare una standardizzazione
		 *
		 * @return void
		 */
		function moduleAddActions()
		{
			$options = (object) $this->getOptions();

			foreach($this->moduleActions as $key=>$classname) 
			{
				if (isset($options->$key) and $options->$key == SZ_PLUGIN_GOOGLE_VALUE_YES) {
					add_action('init',array(new $classname($this),'addAction'));
				}
			}

			// Controllo se devo eseguire delle funzioni di redirect
			// e aggiungo la funzione specifica al contesto (init)

			if (	$options->plus_redirect_sign  == SZ_PLUGIN_GOOGLE_VALUE_YES or
					$options->plus_redirect_plus  == SZ_PLUGIN_GOOGLE_VALUE_YES or
					$options->plus_redirect_curl  == SZ_PLUGIN_GOOGLE_VALUE_YES or 
					$options->plus_redirect_flush == SZ_PLUGIN_GOOGLE_VALUE_NO) 
			{
				add_action('init',array($this,'addPlusRewriteRules'));
			}

			// Controllo se devo attivare la sezione HEAD per author
			// quindi aggiungere author ID nella configurazione generale

			if ($options->plus_enable_author == SZ_PLUGIN_GOOGLE_VALUE_YES) {
				add_action('SZ_HEAD',array($this,'moduleAddMetaAuthor'),20);
			}

			// Controllo se devo attivare la sezione HEAD per publisher
			// quindi aggiungere publisher ID nella configurazione generale

			if ($options->plus_enable_publisher == SZ_PLUGIN_GOOGLE_VALUE_YES) {
				add_action('SZ_HEAD',array($this,'moduleAddMetaPublisher'),20);
			}

			// Controllo se devo attivare le raccomandazioni per mobile,
			// quindi aggiungere publisher ID su codice javascript e sezione HEAD

			if ($options->plus_enable_recommendations == SZ_PLUGIN_GOOGLE_VALUE_YES) {
				add_action('SZ_HEAD',array($this,'moduleAddMetaPublisher'),20);
				$this->addCodeJavascriptFooter();
			}
		}

		/**
		 * Funzione per reperire il campo aggiuntivo che riguarda la
		 * pagina di google plus collegata al profilo utente indicato
		 *
		 * @return string
		 */
		function getPlusContactPage($userid=null) {
			return get_the_author_meta('googlepluspage',$userid);
		}

		/**
		 * Funzione per reperire il campo aggiuntivo che riguarda la
		 * community di google plus collegata al profilo utente indicato
		 *
		 * @return string
		 */
		function getPlusContactCommunity($userid=null) {
			return get_the_author_meta('googlepluscommunity',$userid);
		}

		/**
		 * Funzione per reperire il campo aggiuntivo che riguarda il
		 * post migliore di google plus collegata al profilo utente indicato
		 *
		 * @return string
		 */
		function getPlusContactBestpost($userid=null) {
			return get_the_author_meta('googleplusbestpost',$userid);
		}

		/**
		 * Aggiungo informazione in <head> per il link di tipo publisher
		 * questa funzione viene aggiunta all'azione WP_HEAD() di wordpress
		 *
		 * @return void
		 */
		function moduleAddMetaPublisher()
		{
			// Se ho inserito il meta tag una volta salto la richiesta
			// altrimento imposta la variabile oggetto in (true)

			if ($this->setMetaPublisher) return;
				else $this->setMetaPublisher = true;

			$options = $this->getOptions();

			if (trim($options['plus_page']) != SZ_PLUGIN_GOOGLE_VALUE_NULL) {
				echo '<link rel="publisher" href="https://plus.google.com/'.esc_attr(trim($options['plus_page'])).'"/>'."\n";
			}
		}

		/**
		 * Aggiungo informazione in <head> per il link di tipo publisher
		 * questa funzione viene aggiunta all'azione WP_HEAD() di wordpress
		 *
		 * @return void
		 */
		function moduleAddMetaAuthor()
		{
			// Se ho inserito il meta tag una volta salto la richiesta
			// altrimento imposta la variabile oggetto in (true)

			if ($this->setMetaAuthor) return;
				else $this->setMetaAuthor = true; 

			$options = $this->getOptions();

			if (trim($options['plus_profile']) != SZ_PLUGIN_GOOGLE_VALUE_NULL) {
				echo '<link rel="author" href="https://plus.google.com/'.esc_attr(trim($options['plus_profile'])).'"/>'."\n";
			}
		}

		/**
		 * Funzione per esecuzione shortcode google+ profile con 
		 * passaggio delle opzioni e richiamo della funzione generale
		 *
		 * @return string
		 */
		function getPlusProfileShortcode($atts,$content=null) 
		{
			return $this->getPlusProfileCode(shortcode_atts(array(
				'id'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'type'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_WIDTH,
				'align'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'layout'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT,
				'theme'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME,
				'cover'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER,
				'tagline' => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE,
				'author'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_AUTHOR,
				'text'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'image'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'  => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
			),$atts),$content);
		}

		/**
		 * Funzione per esecuzione codice google+ profile con 
		 * creazione codice HTML sia per shortcode che per widget
		 *
		 * @return string
		 */
		function getPlusProfileCode($atts=array(),$content=null) 
		{
			if (!is_array($atts)) $atts = array();

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			extract(shortcode_atts(array(
				'id'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'type'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'layout'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'theme'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'cover'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'tagline' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'author'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'text'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'image'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$atts));

			// Esecuzione del trim sui valori specificati nello shortcode

			$id      = trim($id);
			$text    = trim($text);
			$image   = trim($image);

			$type    = strtolower(trim($type));
			$width   = strtolower(trim($width));
			$align   = strtolower(trim($align));
			$layout  = strtolower(trim($layout));
			$theme   = strtolower(trim($theme));
			$cover   = strtolower(trim($cover));
			$tagline = strtolower(trim($tagline));
			$author  = strtolower(trim($author));
			$action  = strtolower(trim($action));

			// Lettura opzioni generali per impostazione dei dati di default

			$options = $this->getOptions();

			// Imposto i valori di default nel caso siano specificati dei valori
			// che non appartengono al range dei valori accettati

			if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = trim($options['plus_profile']); }
			if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE; $author = 'false'; }

			// Controllo se azione di richiesta non è un widget posso conrollare i valori
			// di default legati allo shortcode che sono gli stessi per la funzione PHP diretta

			if ($action != SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) 
			{
				if ($layout  != 'portrait' and $layout  != 'landscape') $layout  = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT; 
				if ($theme   != 'light'    and $theme   != 'dark')      $theme   = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME; 
				if ($cover   != 'true'     and $cover   != 'false')     $cover   = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER; 
				if ($tagline != 'true'     and $tagline != 'false')     $tagline = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE; 
				if ($author  != 'true'     and $author  != 'false')     $author  = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_AUTHOR; 

			} else {

				if ($layout  != 'portrait' and $layout  != 'landscape') $layout  = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_LAYOUT; 
				if ($theme   != 'light'    and $theme   != 'dark')      $theme   = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_THEME; 
				if ($cover   != 'true'     and $cover   != 'false')     $cover   = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_COVER; 
				if ($tagline != 'true'     and $tagline != 'false')     $tagline = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_TAGLINE; 
				if ($author  != 'true'     and $author  != 'false')     $author  = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_AUTHOR; 
			}

			// Controllo la dimensione del widget se non specificata applico i valori
			// di default specificati nel pannello di amministrazione o nelle costanti

			if (!is_numeric($width) and $width != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = SZ_PLUGIN_GOOGLE_VALUE_NULL;

			if ($action != SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) 
			{
				if ($layout == 'portrait') {
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_shortcode_size_portrait'];
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT;
				} else {
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_shortcode_size_landscape'];
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_LANDSCAPE;
			}

			} else {

				if ($layout == 'portrait') {
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_widget_size_portrait'];
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT;
				} else {
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_widget_size_landscape'];
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_LANDSCAPE;
				}
			}

			if (!is_numeric($width) and $width != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = SZ_PLUGIN_GOOGLE_VALUE_NULL;

			// Controllo la dimensione del widget e controllo formale dei valori numerici
			// se trovo qualche incongruenza applico i valori di default prestabiliti

			if ($width == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = "'+w+'";
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = "'+w+'";

			$uniqueID = 'sz-google-profile-'.md5(uniqid(),false);

			// Preparazione codice HTML per il badge di google plus
			// con modalità pop-up con la generazione di un link semplice

			if ($type == 'popup') 
			{
				$HTML  = '<span class="sz-google-profile">';
				$HTML .= '<a class="g-profile" href="https://plus.google.com/'.$id.'">';

				if (!empty($text))    $HTML .= $text;
				if (!empty($image))   $HTML .= '<img src="'.$image.'" alt=""/>';

				$HTML .= '</a>';
				$HTML .= '</span>';

			// Preparazione codice HTML per il badge di google plus
			// con modalità standard tramite la creazione di un iframe

			} else {

				// Apertura delle divisioni che rappresentano il wrapper
				// comune per eventuali personalizzazioni di visualizzazione

				$HTML  = '<div class="sz-google-badge">';
				$HTML .= '<div class="sz-google-profile">';
				$HTML .= '<div class="sz-google-profile-wrap">';

				// Blocco principale della divisione con codice javascript
				// per il calcolo della dimensione automatica e contenitore

				$HTML .= '<div class="sz-google-profile-iframe" id="'.$uniqueID.'" style="display:block;';

				if ($align == 'left')   $HTML .= 'text-align:left;';
				if ($align == 'center') $HTML .= 'text-align:center;';
				if ($align == 'right')  $HTML .= 'text-align:right;';

				$HTML .= '">';

				$HTML .= '<script type="text/javascript">';
				$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
				$HTML .= "var h='<'+'";

				$HTML .= 'div class="g-person"';
				$HTML .= ' data-href="https://plus.google.com/'.$id.'"';
				$HTML .= ' data-width="'         .$width  .'"';
				$HTML .= ' data-layout="'        .$layout .'"';
				$HTML .= ' data-theme="'         .$theme  .'"';
				$HTML .= ' data-showcoverphoto="'.$cover  .'"';
				$HTML .= ' data-showtagline="'   .$tagline.'"';

				if ($author == 'true') $HTML .= ' data-rel="author"';

				$HTML .= "></'+'div'+'>';";
				$HTML .= "document.write(h);";
				$HTML .= '</script>';

				$HTML .= '</div>';

				// Chiusura delle divisioni che rappresentano il wrapper

				$HTML .= '</div>';
				$HTML .= '</div>';
				$HTML .= '</div>';
			}

			// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
			// viene aggiungo anche dalla sidebar però viene inserito una sola volta

			$this->addCodeJavascriptFooter();

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}

		/**
		 * Funzione per esecuzione shortcode google+ page con 
		 * passaggio delle opzioni e richiamo della funzione generale
		 *
		 * @return string
		 */
		function getPlusPageShortcode($atts,$content=null) 
		{
			return $this->getPlusPageCode(shortcode_atts(array(
				'id'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'type'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'     => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_WIDTH,
				'align'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'layout'    => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT,
				'theme'     => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME,
				'cover'     => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER,
				'tagline'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE,
				'publisher' => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PUBLISHER,
				'text'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'image'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'    => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
			),$atts),$content);
		}

		/**
		 * Funzione per esecuzione codice google+ page con 
		 * creazione codice HTML sia per shortcode che per widget
		 *
		 * @return string
		 */
		function getPlusPageCode($atts=array(),$content=null) 
		{
			if (!is_array($atts)) $atts = array();

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			extract(shortcode_atts(array(
				'id'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'type'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'layout'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'theme'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'cover'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'tagline'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'publisher' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'text'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'image'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$atts));

			// Esecuzione trim su valori specificati su shortcode

			$id        = trim($id);
			$text      = trim($text);
			$image     = trim($image);

			$type      = strtolower(trim($type));
			$width     = strtolower(trim($width));
			$align     = strtolower(trim($align));
			$layout    = strtolower(trim($layout));
			$theme     = strtolower(trim($theme));
			$cover     = strtolower(trim($cover));
			$tagline   = strtolower(trim($tagline));
			$publisher = strtolower(trim($publisher));
			$action    = strtolower(trim($action));

			// Lettura opzioni generali per impostazione dei dati di default

			$options = $this->getOptions();

			// Imposto i valori di default nel caso siano specificati dei valori
			// che non appartengono al range dei valori accettati

			if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = trim($options['plus_page']); }
			if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE; $publisher = 'false'; }

			// Controllo se azione di richiesta non è un widget posso conrollare i valori
			// di default legati allo shortcode che sono gli stessi per la funzione PHP diretta

			if ($action != SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) 
			{
				if ($layout    != 'portrait' and $layout    != 'landscape') $layout    = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT; 
				if ($theme     != 'light'    and $theme     != 'dark')      $theme     = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME; 
				if ($cover     != 'true'     and $cover     != 'false')     $cover     = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER; 
				if ($tagline   != 'true'     and $tagline   != 'false')     $tagline   = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE; 
				if ($publisher != 'true'     and $publisher != 'false')     $publisher = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PUBLISHER; 

			} else {

				if ($layout    != 'portrait' and $layout    != 'landscape') $layout    = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_LAYOUT; 
				if ($theme     != 'light'    and $theme     != 'dark')      $theme     = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_THEME; 
				if ($cover     != 'true'     and $cover     != 'false')     $cover     = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_COVER; 
				if ($tagline   != 'true'     and $tagline   != 'false')     $tagline   = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_TAGLINE; 
				if ($publisher != 'true'     and $publisher != 'false')     $publisher = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_PUBLISHER; 
			}

			// Controllo la dimensione del widget se non specificata applico i valori
			// di default specificati nel pannello di amministrazione o nelle costanti

			if (!is_numeric($width) and $width != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = SZ_PLUGIN_GOOGLE_VALUE_NULL;

			if ($action != SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) 
			{
				if ($layout == 'portrait') {
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_shortcode_size_portrait'];
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT;
				} else {
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_shortcode_size_landscape'];
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_LANDSCAPE;
				}

			} else {

				if ($layout == 'portrait') {
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_widget_size_portrait'];
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT;
				} else {
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_widget_size_landscape'];
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_LANDSCAPE;
				}
			}

			if (!is_numeric($width) and $width != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = SZ_PLUGIN_GOOGLE_VALUE_NULL;

			// Controllo la dimensione del widget e controllo formale dei valori numerici
			// se trovo qualche incongruenza applico i valori di default prestabiliti

			if ($width == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = "'+w+'";
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = "'+w+'";

			$uniqueID = 'sz-google-page-'.md5(uniqid(),false);

			// Preparazione codice HTML per il badge di google plus
			// con modalità pop-up con la generazione di un link semplice

			if ($type == 'popup') 
			{
				$HTML  = '<span class="sz-google-profile">';
				$HTML .= '<a class="g-profile" href="https://plus.google.com/'.$id.'">';

				if (!empty($text))    $HTML .= $text;
				if (!empty($image))   $HTML .= '<img src="'.$image.'" alt=""/>';

				$HTML .= '</a>';
				$HTML .= '</span>';

			// Preparazione codice HTML per il badge di google plus
			// con modalità standard tramite la creazione di un iframe

			} else {

				// Apertura delle divisioni che rappresentano il wrapper
				// comune per eventuali personalizzazioni di visualizzazione

				$HTML  = '<div class="sz-google-badge">';
				$HTML .= '<div class="sz-google-page">';
				$HTML .= '<div class="sz-google-page-wrap">';

				$HTML .= '<div class="sz-google-page-iframe" id="'.$uniqueID.'" style="display:block;';

				if ($align == 'left')   $HTML .= 'text-align:left;';
				if ($align == 'center') $HTML .= 'text-align:center;';
				if ($align == 'right')  $HTML .= 'text-align:right;';

				$HTML .= '">';

				$HTML .= '<script type="text/javascript">';
				$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
				$HTML .= "var h='<'+'";

				$HTML .= 'div class="g-page"';
				$HTML .= ' data-href="https://plus.google.com/'.$id.'"';
				$HTML .= ' data-width="'         .$width  .'"';
				$HTML .= ' data-layout="'        .$layout .'"';
				$HTML .= ' data-theme="'         .$theme  .'"';
				$HTML .= ' data-showcoverphoto="'.$cover  .'"';
				$HTML .= ' data-showtagline="'   .$tagline.'"';

				if ($publisher == 'true') $HTML .= ' data-rel="publisher"';

				$HTML .= "></'+'div'+'>';";
				$HTML .= "document.write(h);";
				$HTML .= '</script>';

				$HTML .= '</div>';

				// Chiusura delle divisioni che rappresentano il wrapper

				$HTML .= '</div>';
				$HTML .= '</div>';
				$HTML .= '</div>';
			}

			// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
			// viene aggiungo anche dalla sidebar però viene inserito una sola volta

			$this->addCodeJavascriptFooter();

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}

		/**
		 * Funzione per esecuzione shortcode google+ community con 
		 * passaggio delle opzioni e richiamo della funzione generale
		 *
		 * @return string
		 */
		function getPlusCommunityShortcode($atts,$content=null) 
		{
			return $this->getPlusCommunityCode(shortcode_atts(array(
				'id'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_WIDTH,
				'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'layout' => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT,
				'theme'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME,
				'photo'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PHOTO,
				'owner'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_OWNER,
				'action' => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
			),$atts),$content);
		}

		/**
		 * Funzione per esecuzione codice google+ community con 
		 * creazione codice HTML sia per shortcode che per widget
		 *
		 * @return string
		 */
		function getPlusCommunityCode($atts=array(),$content=null) 
		{
			if (!is_array($atts)) $atts = array();

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			extract(shortcode_atts(array(
				'id'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'layout' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'theme'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'photo'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'owner'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$atts));

			// Esecuzione trim su valori specificati su shortcode

			$id     = trim($id);
			$width  = strtolower(trim($width));
			$align  = strtolower(trim($align));
			$layout = strtolower(trim($layout));
			$theme  = strtolower(trim($theme));
			$photo  = strtolower(trim($photo));
			$owner  = strtolower(trim($owner));
			$action = strtolower(trim($action));

			// Lettura opzioni generali per impostazione dei dati di default

			$options = $this->getOptions();

			// Imposto i valori di default nel caso siano specificati dei valori
			// che non appartengono al range dei valori accettati

			if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = trim($options['plus_community']); }
			if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = SZ_PLUGIN_GOOGLE_PLUS_ID_COMMUNITY; }

			// Controllo se azione di richiesta non è un widget posso conrollare i valori
			// di default legati allo shortcode che sono gli stessi per la funzione PHP diretta

			if ($action != SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) 
			{
				if ($layout != 'portrait' and $layout != 'landscape') $layout = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT; 
				if ($theme  != 'light'    and $theme  != 'dark')      $theme  = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME; 
				if ($photo  != 'true'     and $photo  != 'false')     $photo  = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PHOTO; 
				if ($owner  != 'true'     and $owner  != 'false')     $owner  = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_OWNER; 

			} else {

				if ($layout != 'portrait' and $layout != 'landscape') $layout = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_LAYOUT; 
				if ($theme  != 'light'    and $theme  != 'dark')      $theme  = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_THEME; 
				if ($photo  != 'true'     and $photo  != 'false')     $cover  = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_PHOTO; 
				if ($owner  != 'true'     and $owner  != 'false')     $owner  = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_OWNER; 
			}

			// Controllo la dimensione del widget se non specificata applico i valori
			// di default specificati nel pannello di amministrazione o nelle costanti

			if (!is_numeric($width) and $width != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = SZ_PLUGIN_GOOGLE_VALUE_NULL;

			if ($action != SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) 
			{
				if ($layout == 'portrait') {
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_shortcode_size_portrait'];
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT;
				} else {
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_shortcode_size_landscape'];
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_LANDSCAPE;
				}

			} else {

				if ($layout == 'portrait') {
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_widget_size_portrait'];
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT;
				} else {
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_widget_size_landscape'];
					if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_LANDSCAPE;
				}
			}

			if (!is_numeric($width) and $width != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = SZ_PLUGIN_GOOGLE_VALUE_NULL;

			// Controllo la dimensione del widget e controllo formale dei valori numerici
			// se trovo qualche incongruenza applico i valori di default prestabiliti

			if ($width == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = "'+w+'";
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = "'+w+'";

			$uniqueID = 'sz-google-community-'.md5(uniqid(),false);

			// Apertura delle divisioni che rappresentano il wrapper
			// comune per eventuali personalizzazioni di visualizzazione

			$HTML  = '<div class="sz-google-badge">';
			$HTML .= '<div class="sz-google-community">';
			$HTML .= '<div class="sz-google-community-wrap">';

			$HTML .= '<div class="sz-google-community-iframe" id="'.$uniqueID.'" style="display:block;';

			if ($align == 'left')   $HTML .= 'text-align:left;';
			if ($align == 'center') $HTML .= 'text-align:center;';
			if ($align == 'right')  $HTML .= 'text-align:right;';

			$HTML .= '">';

			$HTML .= '<script type="text/javascript">';
			$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
			$HTML .= "var h='<'+'";

			$HTML .= 'div class="g-community"';
			$HTML .= ' data-href="https://plus.google.com/communities/'.$id.'"';
			$HTML .= ' data-width="'     .$width .'"';
			$HTML .= ' data-layout="'    .$layout.'"';
			$HTML .= ' data-theme="'     .$theme .'"';
			$HTML .= ' data-showphoto="' .$photo .'"';
			$HTML .= ' data-showowners="'.$owner .'"';

			$HTML .= "></'+'div'+'>';";
			$HTML .= "document.write(h);";
			$HTML .= '</script>';

			$HTML .= '</div>';

			// Chiusura delle divisioni che rappresentano il wrapper

			$HTML .= '</div>';
			$HTML .= '</div>';
			$HTML .= '</div>';

			// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
			// viene aggiungo anche dalla sidebar però viene inserito una sola volta

			$this->addCodeJavascriptFooter();

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}

		/**
		 * Funzione per esecuzione shortcode google+ followers con 
		 * passaggio delle opzioni e richiamo della funzione generale
		 *
		 * @return string
		 */
		function getPlusFollowersShortcode($atts,$content=null) 
		{
			return $this->getPlusFollowersCode(shortcode_atts(array(
				'id'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action' => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
			),$atts),$content);
		}

		/**
		 * Funzione per esecuzione codice google+ followers con 
		 * creazione codice HTML sia per shortcode che per widget
		 *
		 * @return string
		 */
		function getPlusFollowersCode($atts=array(),$content=null) 
		{
			if (!is_array($atts)) $atts = array();

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			extract(shortcode_atts(array(
				'id'     => SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE,
				'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$atts));

			// Esecuzione trim su valori specificati su shortcode

			$id     = trim($id);
			$width  = strtolower(trim($width));
			$height = strtolower(trim($height));
			$align  = strtolower(trim($align));
			$action = strtolower(trim($action));

			// Lettura opzioni generali per impostazione dei dati di default

			$options = $this->getOptions();

			// Imposto i valori di default nel caso siano specificati dei valori
			// che non appartengono al range dei valori accettati

			if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = $options['plus_page']; }
			if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = $options['plus_profile']; }

			if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE; }
			if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE; }

			// Controllo la dimensione del widget e controllo formale dei valori numerici
			// se trovo qualche incongruenza applico i valori di default prestabiliti

			if (!is_numeric($width)  and $width  != 'auto') $width  = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			if (!is_numeric($height) and $height != 'auto') $height = SZ_PLUGIN_GOOGLE_VALUE_NULL;

			if ($action != SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) {
				if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_shortcode_size_portrait'];
				if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT;
			} else {
				if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_widget_size_portrait'];
				if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT;
			}

			if (!is_numeric($width)  and $width  != 'auto') $width  = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			if (!is_numeric($height) and $height != 'auto') $height = SZ_PLUGIN_GOOGLE_VALUE_NULL;

			// Controllo la dimensione del widget e controllo formale dei valori numerici
			// se trovo qualche incongruenza applico i valori di default prestabiliti

			if ($width  == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = "'+w+'";
			if ($width  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = "'+w+'";

			if ($height == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $height = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_HEIGHT;
			if ($height == SZ_PLUGIN_GOOGLE_VALUE_NULL) $height = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_HEIGHT;

			$uniqueID = 'sz-google-followers-'.md5(uniqid(),false);

			// Preparazione codice HTML per il badge di google plus

			$HTML  = '<div class="sz-google-followers">';
			$HTML .= '<div class="sz-google-followers-wrap">';

			$HTML .= '<div class="sz-google-followers-iframe" id="'.$uniqueID.'" style="display:block;';

			if ($align == 'left')   $HTML .= 'text-align:left;';
			if ($align == 'center') $HTML .= 'text-align:center;';
			if ($align == 'right')  $HTML .= 'text-align:right;';

			$HTML .= '">';

			$HTML .= '<script type="text/javascript">';
			$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
			$HTML .= "var h='<'+'";

			$HTML .= 'div class="g-plus"';
			$HTML .= ' data-action="followers"';
			$HTML .= ' data-href="https://plus.google.com/'.$id.'"';
			$HTML .= ' data-width="' .$width .'"';
			$HTML .= ' data-height="'.$height.'"';
			$HTML .= ' data-source="blogger:blog:followers"';

			$HTML .= "></'+'div'+'>';";
			$HTML .= "document.write(h);";
			$HTML .= '</script>';

			$HTML .= '</div>';
			$HTML .= '</div>';
			$HTML .= '</div>';

			// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
			// viene aggiungo anche dalla sidebar però viene inserito una sola volta

			$this->addCodeJavascriptFooter();

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}

		/**
		 * Funzione per esecuzione shortcode google+ plusone con 
		 * passaggio delle opzioni e richiamo della funzione generale
		 *
		 * @return string
		 */
		function getPlusPlusoneShortcode($atts,$content=null) 
		{
			return $this->getPlusPlusoneCode(shortcode_atts(array(
				'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'size'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'annotation'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'float'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'       => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
			),$atts),$content);
		}

		/**
		 * Funzione per esecuzione codice google+ plusone con 
		 * creazione codice HTML sia per shortcode che per widget
		 *
		 * @return string
		 */
		function getPlusPlusoneCode($atts=array(),$content=null) 
		{
			if (!is_array($atts)) $atts = array();

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			$DEFAULT_SIZE       = 'standard';
			$DEFAULT_ANNOTATION = 'none';
			$DEFAULT_FLOAT      = 'none';
			$DEFAULT_ALIGN      = 'none';
			$DEFAULT_POSITION   = 'outside';

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			extract(shortcode_atts(array(
				'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'size'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'annotation'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'float'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$atts));

			// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
			// stringa minuscolo per il controllo di valori speciali come "auto"

			$url          = trim($url);
			$text         = trim($text);
			$img          = trim($img);

			$width        = strtolower(trim($width));
			$size         = strtolower(trim($size));
			$annotation   = strtolower(trim($annotation));
			$align        = strtolower(trim($align));
			$float        = strtolower(trim($float));
			$position     = strtolower(trim($position));
			$margintop    = strtolower(trim($margintop));
			$marginright  = strtolower(trim($marginright));
			$marginbottom = strtolower(trim($marginbottom));
			$marginleft   = strtolower(trim($marginleft));
			$marginunit   = strtolower(trim($marginunit));

			// Imposto i valori di default nel caso siano specificati dei valori
			// che non appartengono al range dei valori accettati

			if (!in_array($size,array('small','medium','standard','tail')))    $size       = $DEFAULT_SIZE;
			if (!in_array($annotation,array('inline','bubble','none')))        $annotation = $DEFAULT_ANNOTATION; 
			if (!in_array($float,array('none','left','right')))                $float      = $DEFAULT_FLOAT; 
			if (!in_array($align,array('none','left','right','center')))       $align      = $DEFAULT_ALIGN; 
			if (!in_array($position,array('top','center','bottom','outside'))) $position   = $DEFAULT_POSITION; 

			// Se non specifico un URL fisso imposto il permalink attuale

			if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) $url = get_permalink();

			// Creazione codice HTML per embed code da inserire nella pagina wordpress

			$HTML  = '<div class="g-plusone"';

			if ($width != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= ' data-width="'.$width.'"';
			if ($align == 'right') $HTML .= ' data-align="right"';

			$HTML .= ' data-href="'      .$url       .'"';
			$HTML .= ' data-size="'      .$size      .'"';
			$HTML .= ' data-annotation="'.$annotation.'"';
			$HTML .= '></div>';

			$HTML = SZGoogleCommonButton::getButton(array(
				'html'         => $HTML,
				'text'         => $text,
				'image'        => $img,
				'content'      => $content,
				'float'        => $float,
				'align'        => $align,
				'position'     => $position,
				'margintop'    => $margintop,
				'marginright'  => $marginright,
				'marginbottom' => $marginbottom,
				'marginleft'   => $marginleft,
				'marginunit'   => $marginunit,
				'class'        => SZ_PLUGIN_GOOGLE_PLUS_CLASS_PLUSONE,
			));

			// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
			// viene aggiungo anche dalla sidebar però viene inserito una sola volta

			$this->addCodeJavascriptFooter();

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}

		/**
		 * Funzione per esecuzione shortcode google+ share con 
		 * passaggio delle opzioni e richiamo della funzione generale
		 *
		 * @return string
		 */
		function getPlusShareShortcode($atts,$content=null) 
		{
			return $this->getPlusShareCode(shortcode_atts(array(
				'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'size'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'annotation'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'float'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'       => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
			),$atts),$content);
		}

		/**
		 * Funzione per esecuzione codice google+ share con 
		 * creazione codice HTML sia per shortcode che per widget
		 *
		 * @return string
		 */
		function getPlusShareCode($atts=array(),$content=null) 
		{
			if (!is_array($atts)) $atts = array();

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			$DEFAULT_SIZE       = 'medium';
			$DEFAULT_ANNOTATION = 'inline';
			$DEFAULT_FLOAT      = 'none';
			$DEFAULT_ALIGN      = 'none';
			$DEFAULT_POSITION   = 'outside';

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			extract(shortcode_atts(array(
				'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'size'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'annotation'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'float'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$atts));

			// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
			// stringa minuscolo per il controllo di valori speciali come "auto"

			$url          = trim($url);
			$text         = trim($text);
			$img          = trim($img);

			$width        = strtolower(trim($width));
			$size         = strtolower(trim($size));
			$annotation   = strtolower(trim($annotation));
			$float        = strtolower(trim($float));
			$align        = strtolower(trim($align));
			$position     = strtolower(trim($position));
			$margintop    = strtolower(trim($margintop));
			$marginright  = strtolower(trim($marginright));
			$marginbottom = strtolower(trim($marginbottom));
			$marginleft   = strtolower(trim($marginleft));
			$marginunit   = strtolower(trim($marginunit));

			// Imposto i valori di default nel caso siano specificati dei valori
			// che non appartengono al range dei valori accettati

			if (!in_array($size,array('small','medium','large')))                         $size       = $DEFAULT_SIZE;
			if (!in_array($annotation,array('inline','bubble','vertical-bubble','none'))) $annotation = $DEFAULT_ANNOTATION; 
			if (!in_array($float,array('none','left','right')))                           $float      = $DEFAULT_FLOAT; 
			if (!in_array($align,array('none','left','right','center')))                  $align      = $DEFAULT_ALIGN; 
			if (!in_array($position,array('top','center','bottom','outside')))            $position   = $DEFAULT_POSITION; 

			// Se non specifico un URL fisso imposto il permalink attuale

			if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) $url = get_permalink();

			// Preparazione codice HTML per il badge di google plus

			$HTML  = '<div class="g-plus"';
			$HTML .= ' data-action="share"';	
			$HTML .= ' data-href="'      .$url       .'"';
			$HTML .= ' data-annotation="'.$annotation.'"';

			if ($size  == 'small')  $HTML .= ' data-height="15"';
			if ($size  == 'medium') $HTML .= ' data-height="20"';
			if ($size  == 'large')  $HTML .= ' data-height="24"';
			if ($width != '')       $HTML .= ' data-width="'.$width.'"';
			if ($align == 'right')  $HTML .= ' data-align="right"';

			$HTML .= '></div>';

			$HTML = SZGoogleCommonButton::getButton(array(
				'html'         => $HTML,
				'text'         => $text,
				'image'        => $img,
				'content'      => $content,
				'float'        => $float,
				'align'        => $align,
				'position'     => $position,
				'margintop'    => $margintop,
				'marginright'  => $marginright,
				'marginbottom' => $marginbottom,
				'marginleft'   => $marginleft,
				'marginunit'   => $marginunit,
				'class'        => SZ_PLUGIN_GOOGLE_PLUS_CLASS_SHARE,
			));

			// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
			// viene aggiungo anche dalla sidebar però viene inserito una sola volta

			$this->addCodeJavascriptFooter();

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}

		/**
		 * Funzione per esecuzione shortcode google+ follow con 
		 * passaggio delle opzioni e richiamo della funzione generale
		 *
		 * @return string
		 */
		function getPlusFollowShortcode($atts,$content=null) 
		{
			return $this->getPlusFollowCode(shortcode_atts(array(
				'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'size'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'annotation'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'float'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'rel'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'       => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
			),$atts),$content);
		}

		/**
		 * Funzione per esecuzione codice google+ follow con 
		 * creazione codice HTML sia per shortcode che per widget
		 *
		 * @return string
		 */
		function getPlusFollowCode($atts=array(),$content=null) 
		{
			if (!is_array($atts)) $atts = array();

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			$DEFAULT_SIZE       = 'medium';
			$DEFAULT_ANNOTATION = 'bubble';
			$DEFAULT_REL        = 'none';
			$DEFAULT_FLOAT      = 'none';
			$DEFAULT_ALIGN      = 'none';
			$DEFAULT_POSITION   = 'outside';

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			extract(shortcode_atts(array(
				'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'size'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'annotation'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'float'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'rel'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$atts));

			// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
			// stringa minuscolo per il controllo di valori speciali come "auto"

			$url          = trim($url);
			$text         = trim($text);
			$img          = trim($img);

			$width        = strtolower(trim($width));
			$size         = strtolower(trim($size));
			$annotation   = strtolower(trim($annotation));
			$float        = strtolower(trim($float));
			$align        = strtolower(trim($align));
			$rel          = strtolower(trim($rel));
			$position     = strtolower(trim($position));
			$margintop    = strtolower(trim($margintop));
			$marginright  = strtolower(trim($marginright));
			$marginbottom = strtolower(trim($marginbottom));
			$marginleft   = strtolower(trim($marginleft));
			$marginunit   = strtolower(trim($marginunit));

			// Imposto i valori di default nel caso siano specificati dei valori
			// che non appartengono al range dei valori accettati

			if (!in_array($size,array('small','medium','large')))                         $size       = $DEFAULT_SIZE;
			if (!in_array($annotation,array('inline','bubble','vertical-bubble','none'))) $annotation = $DEFAULT_ANNOTATION; 
			if (!in_array($float,array('none','left','right')))                           $float      = $DEFAULT_FLOAT; 
			if (!in_array($align,array('none','left','right','center')))                  $align      = $DEFAULT_ALIGN; 
			if (!in_array($rel,array('author','publisher')))                              $rel        = $DEFAULT_REL; 
			if (!in_array($position,array('top','center','bottom','outside')))            $position   = $DEFAULT_POSITION; 

			// Lettura opzioni generali per impostazione dei dati di default

			$options = $this->getOptions();

			// Imposto i valori di default nel caso siano specificati dei valori
			// che non appartengono al range dei valori accettati

			if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $url = 'https://plus.google.com/'.$options['plus_page']; }
			if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $url = 'https://plus.google.com/'.$options['plus_profile']; }

			if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $url = 'https://plus.google.com/'.SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE;    $rel = SZ_PLUGIN_GOOGLE_VALUE_NULL; }
			if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $url = 'https://plus.google.com/'.SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE; $rel = SZ_PLUGIN_GOOGLE_VALUE_NULL; }

			// Elimino dal path i riferimenti aggiunti ai link di navigazione e 
			// riporto il link originale di google plus, senza /u/0/b etc etc

			$url = $this->getCanonicalURL($url);

			// Preparazione codice HTML per il badge di google plus

			$HTML  = '<div class="g-follow"';
			$HTML .= ' data-href="'      .$url       .'"';
			$HTML .= ' data-annotation="'.$annotation.'"';

			if ($size  == 'small')     $HTML .= ' data-height="15"';
			if ($size  == 'medium')    $HTML .= ' data-height="20"';
			if ($size  == 'large')     $HTML .= ' data-height="24"';
			if ($width != '')          $HTML .= ' data-width="'.$width.'"';
			if ($align == 'right')     $HTML .= ' data-align="right"';
			if ($rel   == 'author')    $HTML .= ' data-rel="author"';
			if ($rel   == 'publisher') $HTML .= ' data-rel="publisher"';

			$HTML .= '></div>';

			$HTML = SZGoogleCommonButton::getButton(array(
				'html'         => $HTML,
				'text'         => $text,
				'image'        => $img,
				'content'      => $content,
				'float'        => $float,
				'align'        => $align,
				'position'     => $position,
				'margintop'    => $margintop,
				'marginright'  => $marginright,
				'marginbottom' => $marginbottom,
				'marginleft'   => $marginleft,
				'marginunit'   => $marginunit,
				'class'        => SZ_PLUGIN_GOOGLE_PLUS_CLASS_FOLLOW,
			));

			// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
			// viene aggiungo anche dalla sidebar però viene inserito una sola volta

			$this->addCodeJavascriptFooter();

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}

		/**
		 * Funzione per esecuzione shortcode google+ comments con 
		 * passaggio delle opzioni e richiamo della funzione generale
		 *
		 * @return string
		 */
		function getPlusCommentsShortcode($atts,$content=null) 
		{
			return $this->getPlusCommentsCode(shortcode_atts(array(
				'url'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'id'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'title'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'class0' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'class1' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'class2' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action' => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
			),$atts),$content);
		}

		/**
		 * Funzione per esecuzione codice google+ comments con 
		 * creazione codice HTML sia per shortcode che per widget
		 *
		 * @return string
		 */
		function getPlusCommentsCode($atts=array(),$content=null) 
		{
			if (!is_array($atts)) $atts = array();

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave
			
			extract(shortcode_atts(array(
				'url'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'id'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'title'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'class0' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'class1' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'class2' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$atts));

			// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
			// stringa minuscolo per il controllo di valori speciali come "auto"

			$options = $this->getOptions();

			$uniqueID = 'sz-google-comments-'.md5(uniqid(),false);

			$url    = trim($url);
			$title  = trim($title);
			$class0 = trim($class0);
			$class1 = trim($class1);
			$class2 = trim($class2);

			$width  = strtolower(trim($width));
			$align  = strtolower(trim($align));

			// Controllo opzione per dimensione fissa da applicare se esiste 
			// un valore specificato e il parametro width non è stato specificato. 

			if (!is_numeric($width) and $width != 'auto') $width = SZ_PLUGIN_GOOGLE_VALUE_NULL;

			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_comments_fixed_size'];
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

			if (!is_numeric($width) and $width != 'auto') $width = SZ_PLUGIN_GOOGLE_VALUE_NULL;

			// Controllo opzione per dimensione fissa da applicare se esiste 
			// un valore specificato e il parametro width non è stato specificato. 

			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = "'+w+'";
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = "'+w+'";

			// Se non specifico un URL fisso imposto il permalink attuale

			if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) $url = get_permalink();

			// Elimino dal path i riferimenti aggiunti ai link di navigazione e 
			// riporto il link originale di google plus, senza /u/0/b etc etc

			$url = $this->getCanonicalURL($url);

			// Controllo il valore del titolo per i commenti di google plus
			// ignoro il parametro se il componente appartiene ad un widget

			if ($action == SZ_PLUGIN_GOOGLE_VALUE_TEXT_TEMPLATE) 
			{
				if (empty($title)) $title = trim($options['plus_comments_title']);
				if (empty($title)) $title = '<h3>{title}</h3>';

				$title = str_ireplace('{title}',ucfirst(SZGoogleCommon::getTranslate('leave a Reply')),$title);
			}

			// Controllo i valori delle classi eventuali da aggiungere ai wrapper
			// del codice HTML generato e controllo eventuale ID di divisione

			if (!empty($id))     $id     = 'id="'.$id.'" ';
			if (!empty($class0)) $class0 = ' '.$class0;
			if (!empty($class1)) $class1 = ' '.$class1;
			if (!empty($class2)) $class2 = ' '.$class2;

			// Creazione codice HTML per embed code da inserire nella pagina wordpress
			// Questo codice deve essere usato sia dallo shortcode, dal widget e dalla funzione

			$HTML  = '<div '.$id.'class="sz-google-comments'.$class0.$class1.'">';
			if (!empty($title)) $HTML .= $title;
			$HTML .= '<div class="sz-google-comments-wrap'.$class2.'">';
			$HTML .= '<div class="sz-google-comments-iframe" id="'.$uniqueID.'" style="display:block;';

			if ($align == 'left')   $HTML .= 'text-align:left;';
			if ($align == 'center') $HTML .= 'text-align:center;';
			if ($align == 'right')  $HTML .= 'text-align:right;';

			$HTML .= '">';

			$HTML .= '<script type="text/javascript">';
			$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
			$HTML .= "var h='<'+'";

			$HTML .= 'div class="g-comments"';
			$HTML .= ' data-href="'.$url.'"';
			$HTML .= ' data-width="'.$width.'"';
			$HTML .= ' data-height="50"';
			$HTML .= ' data-first_party_property="BLOGGER"';
			$HTML .= ' data-view_type="FILTERED_POSTMOD"';

			$HTML .= "></'+'div'+'>';";
			$HTML .= "document.write(h);";
			$HTML .= '</script>';

			$HTML .= '</div>';
			$HTML .= '</div>';
			$HTML .= '</div>';

			// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
			// viene aggiungo anche dalla sidebar però viene inserito una sola volta

			$this->addCodeJavascriptFooter();

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}

		/**
		 * Funzione per esecuzione shortcode google+ post con 
		 * passaggio delle opzioni e richiamo della funzione generale
		 *
		 * @return string
		 */
		function getPlusPostShortcode($atts,$content=null) 
		{
			return $this->getPlusPostCode(shortcode_atts(array(
				'url'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action' => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
			),$atts),$content);
		}

		/**
		 * Funzione per esecuzione codice google+ post con 
		 * creazione codice HTML sia per shortcode che per widget
		 *
		 * @return string
		 */
		function getPlusPostCode($atts=array(),$content=null) 
		{
			if (!is_array($atts)) $atts = array();

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			extract(shortcode_atts(array(
				'url'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$atts));

			// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
			// stringa minuscolo per il controllo di valori speciali come "auto"

			$url   = trim($url);
			$align = strtolower(trim($align));

			// Se non specifico un URL valido per la creazione del bottone
			// esco dalla funzione e ritorno una stringa vuota

			if (empty($url)) { return SZ_PLUGIN_GOOGLE_VALUE_NULL; }

			// Elimino dal path i riferimenti aggiunti ai link di navigazione e 
			// riporto il link originale di google plus, senza /u/0/b etc etc

			$url = $this->getCanonicalURL($url);

			// Creazione codice HTML per embed code da inserire nella pagina wordpress

			$HTML  = '<div class="sz-google-post">';
			$HTML .= '<div class="sz-google-post-wrap"';
			$HTML .= ' style="display:block;';

			if ($align == 'left')   $HTML .= 'text-align:left;';
			if ($align == 'center') $HTML .= 'text-align:center;';
			if ($align == 'right')  $HTML .= 'text-align:right;';

			$HTML .= '">';

			$HTML .= '<div class="g-post" ';
			$HTML .= 'data-href="'.$url.'"';
			$HTML .= '></div>';

			$HTML .= '</div>';
			$HTML .= '</div>';

			// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
			// viene aggiungo anche dalla sidebar però viene inserito una sola volta

			$this->addCodeJavascriptFooter();

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}

		/**
		 * Funzione per modifica URL passato alla funzione in quanto viene
		 * specificato molte volte la stringa URL non canonical
		 *
		 * @return string
		 */
		function getCanonicalURL($url=null) 
		{
			$url = str_ireplace('://plus.google.com/b/'    ,'://plus.google.com/',$url);
			$url = str_ireplace('://plus.google.com/u/0/b/','://plus.google.com/',$url);
			$url = str_ireplace('://plus.google.com/u/0/'  ,'://plus.google.com/',$url);

			return $url;
		}

		/**
		 * Funzione per attivazione delle regole di rewrite in base
		 * alle opzioni indicate nel pannello di amministrazione 
		 *
		 * @return void
		 */
		function addPlusRewriteRules() 
		{
			global $wp;
			
			$options = $this->getOptions();

			// Se trovo almeno una opzione di redirect attiva ma il permalink
			// risulta disattivo mando un messaggio di informazione in bacheca

			if ($options['plus_redirect_sign'] == SZ_PLUGIN_GOOGLE_VALUE_YES or
				$options['plus_redirect_plus'] == SZ_PLUGIN_GOOGLE_VALUE_YES or
				$options['plus_redirect_curl'] == SZ_PLUGIN_GOOGLE_VALUE_YES) 
			{
				if (!get_option('permalink_structure')) { 
					if (is_admin()) add_action('admin_notices',array($this,'addAdminNoticesRewrite'));
				} 
			}

			// Controllo REDIRECT per url con la stringa "+"

			if ($options['plus_redirect_sign'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
				add_rewrite_rule('^\+$','index.php?szgoogleplusredirectsign=1','top');		
				$wp->add_query_var('szgoogleplusredirectsign');
			}

			// Controllo REDIRECT per url con la stringa "plus"

			if ($options['plus_redirect_plus'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
				add_rewrite_rule('^plus$','index.php?szgoogleplusredirectplus=1','top');		
				$wp->add_query_var('szgoogleplusredirectplus');
			}

			// Controllo REDIRECT per url con la stringa "URL"

			if ($options['plus_redirect_curl'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
				if (trim($options['plus_redirect_curl_dir']) != SZ_PLUGIN_GOOGLE_VALUE_NULL and 
					trim($options['plus_redirect_curl_url']) != SZ_PLUGIN_GOOGLE_VALUE_NULL) {
					add_rewrite_rule('^'. preg_quote(trim($options['plus_redirect_curl_dir'])).'$','index.php?szgoogleplusredirectcurl=1','top');		
					$wp->add_query_var('szgoogleplusredirectcurl');
				}
			}

			// Se opzione di flush è disattivata eseguo il flush_rules ed eseguo
			// la modifica dell'opzione al valore "1" per non ripetere l'operazione

			if ($options['plus_redirect_flush'] == SZ_PLUGIN_GOOGLE_VALUE_NO) 
			{
				$options['plus_redirect_flush'] = SZ_PLUGIN_GOOGLE_VALUE_YES;
				update_option('sz_google_options_plus',$options);
				add_action('wp_loaded',array('SZGoogleCommon','rewriteFlushRules'));
			}

			// Aggiungo variabile QUERY URL e controllo personalizzato di redirect
	
			add_action('parse_request',array($this,'modulePlusParseQuery'));
		}

		/**
		 * Funzione per attivazione delle regole di rewrite in base
		 * alle opzioni indicate nel pannello di amministrazione 
		 *
		 * @return void
		 */
		function modulePlusParseQuery(&$wp)
		{
			$options = $this->getOptions();

			// Controllo REDIRECT per url con la stringa "+"

			if (array_key_exists('szgoogleplusredirectsign',$wp->query_vars)) {
				if (trim($options['plus_redirect_sign_url']) != SZ_PLUGIN_GOOGLE_VALUE_NULL) {   
					header('HTTP/1.1 301 Moved Permanently');
 					header('Location:'.trim($options['plus_redirect_sign_url']));
					exit();
				}
			}

			// Controllo REDIRECT per url con la stringa "plus"
	
			if (array_key_exists('szgoogleplusredirectplus',$wp->query_vars)) {
				if (trim($options['plus_redirect_plus_url']) != SZ_PLUGIN_GOOGLE_VALUE_NULL) {   
					header('HTTP/1.1 301 Moved Permanently');
					header('Location:'.trim($options['plus_redirect_plus_url']));
					exit();
				}
			}

			// Controllo REDIRECT per url con la stringa "URL"
	
			if (array_key_exists('szgoogleplusredirectcurl',$wp->query_vars)) {
				if (trim($options['plus_redirect_curl_url']) != SZ_PLUGIN_GOOGLE_VALUE_NULL) {   
					header('HTTP/1.1 301 Moved Permanently');
					header('Location:'.trim($options['plus_redirect_curl_url']));
					exit();
				}
			}
		}

		/**
		 * Funzione per attivazione delle regole di rewrite in base
		 * alle opzioni indicate nel pannello di amministrazione 
		 *
		 * @return void
		 */
		function addAdminNoticesRewrite() {
			echo '<div class="error"><p>(<b>sz-google</b>) - ';
			echo __('Google+ Rewrite option is enable but wordpress permalink is disable. Please disable option for rewrite.','szgoogleadmin');
			echo '</p></div>';
		}

		/**
		 * Funzione per aggiungere il codice javascript dei vari
		 * componenti di google plus nel footer e controllo se 
		 * la richiesta è stata eseguita già in qualche parte diversa
		 *
		 * @return void
		 */
		function addCodeJavascriptFooter()
		{
			// Se ho già inserito il codice javascript nella sezione footer
			// esco dalla funzione altrimenti setto la variabile e continuo

			if ($this->setJavascriptPlusone) return;
				else $this->setJavascriptPlusone = true;

			// Caricamento azione nel footer del plugin per il caricamento
			// del framework javascript messo a disposizione da google

			add_action('SZ_FOOT',array($this,'setJavascriptPlusOne'));
		}
	}

	/**
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 */

	@require_once(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/functions/SZGoogleFunctionsPlus.php');
}