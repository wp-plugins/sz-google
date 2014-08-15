<?php
/**
 * Modulo YOUTUBE per la definizione delle funzioni che riguardano
 * sia i widget che i shortcode ma anche i filtri e le azioni che il modulo
 * può integrare durante l'aggiunta di funzionalità particolari a wordpress
 *
 * @package SZGoogle
 * @subpackage SZGoogleModule
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome

if (!class_exists('SZGoogleModuleYoutube'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleModule
	 */
	class SZGoogleModuleYoutube extends SZGoogleModule
	{
		protected $setJavascriptPlusone  = false;
		protected $SZ_GOOGLE_YOUTUBE_API = array();
	
		/**
		 * Definizione delle variabili iniziali su array che servono
		 * ad indentificare il modulo e le opzioni ad esso collegate
		 */
		function moduleAddSetup()
		{
			$this->moduleSetClassName(__CLASS__);
			$this->moduleSetOptionSet('sz_google_options_youtube');

			$this->moduleSetShortcodes(array(
				'youtube_shortcode'          => array('sz-ytvideo'   ,array(new SZGoogleActionYoutubeVideo()   ,'getShortcode')),
				'youtube_shortcode_playlist' => array('sz-ytplaylist',array(new SZGoogleActionYoutubePlaylist(),'getShortcode')),
				'youtube_shortcode_badge'    => array('sz-ytbadge'   ,array(new SZGoogleActionYoutubeBadge()   ,'getShortcode')),
				'youtube_shortcode_button'   => array('sz-ytbutton'  ,array($this,'getYoutubeButtonShortcode')),
				'youtube_shortcode_link'     => array('sz-ytlink'    ,array($this,'getYoutubeLinkShortcode')),
			));

			$this->moduleSetWidgets(array(
				'youtube_widget'             => 'SZGoogleWidgetYoutubeVideo',
				'youtube_widget_playlist'    => 'SZGoogleWidgetYoutubePlaylist',
				'youtube_widget_badge'       => 'SZGoogleWidgetYoutubeBadge',
			));
		}

		/**
		 * Funzione per esecuzione shortcode youtube button con 
		 * passaggio delle opzioni e richiamo della funzione generale
		 *
		 * @return string
		 */
		function getYoutubeButtonShortcode($atts,$content=null) 
		{
			return $this->getYoutubeButtonCode(shortcode_atts(array(
				'channel' => '',
				'layout'  => '',
				'theme'   => '',
				'action'  => 'shortcode',
			),$atts),$content);
		}

		/**
		 * Funzione per esecuzione codice youtube button con 
		 * creazione codice HTML sia per shortcode che per widget
		 *
		 * @return string
		 */
		function getYoutubeButtonCode($atts=array(),$content=null) 
		{
			$options = $this->getOptions();

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			if (!is_array($atts)) $atts = array();

			extract(shortcode_atts(array(
				'channel' => '',
				'layout'  => '',
				'theme'   => '',
				'action'  => '',
			),$atts));

			// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
			// stringa minuscolo per il controllo di valori speciali come "auto"

			$channel = trim($channel);
			$layout  = trim($layout);
			$theme   = trim($theme);

			// Se non sono riuscito ad assegnare nessun valore con le istruzioni
			// precedenti metto dei default assoluti che possono essere cambiati

			if ($channel == '') $channel = $options['youtube_channel'];
			if ($layout  == '') $layout  = 'default';
			if ($theme   == '') $theme   = 'default';

			// Se non sono riuscito ad assegnare nessun valore con le istruzioni
			// precedenti metto dei default assoluti che possono essere cambiati

			if (!in_array($layout,array('default','full'))) $layout = 'default'; 
			if (!in_array($theme, array('default','dark'))) $theme  = 'default'; 

			// Verifico se canale è un nome o identificativo univoco 
			// come ad esempio il canale wordpress italy+ UCJqiM61oRRvhTD5il2n56xg

			$channel_type = $this->youtubeCheckChannel($channel);

			// Creazione codice HTML per embed code da inserire nella pagina wordpress

			$HTML  = '<div class="g-ytsubscribe" ';

			if ($channel_type == 'ID') $HTML .= 'data-channelid="'.$channel.'" ';
				else $HTML .= 'data-channel="'.$channel.'" ';

			$HTML .= 'data-layout="'.$layout.'" ';
			$HTML .= 'data-theme="'.$theme.'"';
			$HTML .= '></div>';

			// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
			// viene aggiungo anche dalla sidebar però viene inserito una sola volta

			$this->addCodeJavascriptFooter();

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento di un video youtube 

			return $HTML;
		}

		/**
		 * Funzione per esecuzione shortcode youtube link con 
		 * passaggio delle opzioni e richiamo della funzione generale
		 *
		 * @return string
		 */
		function getYoutubeLinkShortcode($atts,$content=null) 
		{
			return $this->getYoutubeLinkCode(shortcode_atts(array(
				'channel'      => '',
				'subscription' => '',
				'text'         => '',
				'action'       => 'shortcode',
			),$atts),$content);
		}

		/**
		 * Funzione per esecuzione codice youtube link con 
		 * creazione codice HTML sia per shortcode che per widget
		 *
		 * @return string
		 */
		function getYoutubeLinkCode($atts=array(),$content=null) 
		{
			$options = $this->getOptions();

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			if (!is_array($atts)) $atts = array();

			extract(shortcode_atts(array(
				'channel'      => '',
				'subscription' => '',
				'text'         => '',
				'action'       => '',
			),$atts));

			// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
			// stringa minuscolo per il controllo di valori speciali come "auto"

			$channel      = trim($channel);
			$subscription = trim($subscription);
			$text         = trim($text);

			// Se non sono riuscito ad assegnare nessun valore con le istruzioni
			// precedenti metto dei default assoluti che possono essere cambiati

			if ($channel      == '') $channel = $options['youtube_channel'];
			if ($subscription == '') $subscription  = '1';
			if ($text         == '') $text = SZGoogleCommon::getTranslate('channel youtube');

			// Conversione dei valori specificati direttamete nei parametri con
			// i valori usati per la memorizzazione dei valori di default

			if ($subscription == 'yes' or $subscription == 'y') $subscription = '1'; 
			if ($subscription == 'no'  or $subscription == 'n') $subscription = '0'; 

			// Se non sono riuscito ad assegnare nessun valore con le istruzioni
			// precedenti metto dei default assoluti che possono essere cambiati

			$YESNO = array('1','0');

			if (!in_array($subscription,$YESNO)) $subscription = '1'; 

			// Verifico se canale è un nome o identificativo univoco 
			// come ad esempio il canale wordpress italy+ UCJqiM61oRRvhTD5il2n56xg

			$channel_type = $this->youtubeCheckChannel($channel);

			if ($channel_type == 'ID') $ytURL = 'http://www.youtube.com/channel/';
				else $ytURL = 'http://www.youtube.com/user/';

			// Creazione codice HTML per embed code da inserire nella pagina wordpress

			if (empty($content)) 
			{
				$HTML  = '<a href="'.$ytURL.$channel.'?sub_confirmation='.$subscription.'">';
				$HTML .= $text;
				$HTML .= '</a>';

			} else {

				$HTML  = '<a href="'.$ytURL.$channel.'?sub_confirmation='.$subscription.'">';
				$HTML .= $content;
				$HTML .= '</a>';
			}

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento di un video youtube 

			return $HTML;
		}

		/**
		 * Funzione per controllare dalla stringa se il canale 
		 * è rappresentato tramite ID o nome in chiaro
		 *
		 * @return void
		 */
		function youtubeCheckChannel($channel) {
			if (strlen($channel) == 24 and substr($channel,0,2) == 'UC') return "ID";
				else return "NAME";
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

		/**
		 * Funzione per aggiungere le opzioni in un array globale che
		 * verrà utilizzato nella creazione di codice javascript sul footer
		 *
		 * @return string
		 */
		function addYoutubeVideoAPI($opts=array())
		{
			if (is_array($opts)) {
				$this->SZ_GOOGLE_YOUTUBE_API[] = $opts;
				add_action('SZ_FOOT',array($this,'addYoutubeScriptFooter'));
			}
		}

		/**
		 * Creazione codice javascript in footer per inserire il codice embed
		 * di youtube con tutti i parametri di personalizzazione richiesti
		 *
		 * @return string
		 */
		function addYoutubeScriptFooter()
		{
			if (isset($this->SZ_GOOGLE_YOUTUBE_API) and is_array($this->SZ_GOOGLE_YOUTUBE_API)) 
			{
				// Codice javascript per il rendering iframe tramite API
	
				$HTML  = '<script type="text/javascript">';
				$HTML .= "var element = document.createElement('script');";
				$HTML .= 'element.src = "https://www.youtube.com/player_api";';
				$HTML .= "var myscript = document.getElementsByTagName('script')[0];";
				$HTML .= 'myscript.parentNode.insertBefore(element,myscript);';

				// Creazione variabile per ogni player inserito nella pagina web
				// utilizzo l'identificativo univoco per il nome variabile
 
				foreach ($this->SZ_GOOGLE_YOUTUBE_API as $value) {
					if (is_array($value) and isset($value['video'])) { 
						$HTML .= 'var myplayer_'.$value['unique'].';';
					}
				}

				// Creazione funzione per caricamento dei player inseriti nella
				// pagina web. creazione del codice javascript per ogni player univoco

				$HTML .= 'function onYouTubePlayerAPIReady() {';

				foreach ($this->SZ_GOOGLE_YOUTUBE_API as $value) {
					if (is_array($value) and isset($value['video'])) { 
						if (!isset($value['delayed']) or $value['delayed'] == '0') { 
							$HTML .= 'onYouTubePlayerAPIReady_'.$value['unique'].'();';
						}
					}
				}

				$HTML .= '}';

				// Creazione funzione per caricamento dei player inseriti nella
				// pagina web. creazione del codice javascript per ogni player univoco

				foreach ($this->SZ_GOOGLE_YOUTUBE_API as $value) 
				{
					// Creazione codice per inserimento in embed del video specificato
					// nelle opzioni passate senza utilizzare la tecnica iframe

					if (is_array($value) and isset($value['video'])) 
					{ 
						$HTML .= 'function onYouTubePlayerAPIReady_'.$value['unique'].'() {';
						$HTML .=		"myplayer_".$value['unique']." = new YT.Player('".$value['keyID']."', {";
						$HTML .=			"width:'100%',";
						$HTML .=			"height:'100%',";
						$HTML .=			"videoId:'".$value['video']."',";
						$HTML .=			'playerVars: {';
						$HTML .= 			"'controls':1,";
						$HTML .= 			"'iv_load_policy':3,";
						$HTML .= 			"'autoplay':".$value['autoplay'].",";
						$HTML .= 			"'loop':".$value['loop'].",";
						$HTML .= 			"'rel':".$value['disablerelated'].",";
						$HTML .= 			"'fs':".$value['fullscreen'].",";
						$HTML .= 			"'disablekb':".$value['disablekeyboard'].",";
						$HTML .= 			"'theme':'".$value['theme']."',";
						$HTML .= 			"'start':'".$value['start']."',";
						$HTML .= 			"'wmode':'opaque'";
						$HTML .=			'},';     			
						$HTML .=			'events: {';
						$HTML .= 			"'onStateChange':callbackPlayerStatus_".$value['unique'];
						$HTML .=			'}';     			
						$HTML .= 	'});';
						$HTML .= '}';
					}

					// Creazione codice per inserimento in embed della playlist
					// nelle opzioni passate senza utilizzare la tecnica iframe

					if (is_array($value) and isset($value['playlist'])) 
					{ 
						$HTML .= 'function onYouTubePlayerAPIReady_'.$value['unique'].'() {';
						$HTML .=		"myplayer_".$value['unique']." = new YT.Player('".$value['keyID']."', {";
						$HTML .=			"width:'100%',";
						$HTML .=			"height:'100%',";
						$HTML .=			'playerVars: {';
						$HTML .= 			"'listType':'playlist',";
						$HTML .= 			"'list':'".$value['playlist']."',";
						$HTML .= 			"'controls':1,";
						$HTML .= 			"'iv_load_policy':3,";
						$HTML .= 			"'autoplay':".$value['autoplay'].",";
						$HTML .= 			"'loop':".$value['loop'].",";
						$HTML .= 			"'rel':".$value['disablerelated'].",";
						$HTML .= 			"'fs':".$value['fullscreen'].",";
						$HTML .= 			"'disablekb':".$value['disablekeyboard'].",";
						$HTML .= 			"'theme':'".$value['theme']."',";
						$HTML .= 			"'wmode':'opaque'";
						$HTML .=			'},';     			
						$HTML .=			'events: {';
						$HTML .= 			"'onStateChange':callbackPlayerStatus_".$value['unique'];
						$HTML .=			'}';     			
						$HTML .= 	'});';
						$HTML .= '}';
					}
				}

				// Creazione funzione per caricamento codice google analytics da
				// collegare ad ogni singolo player presente sulla pagina web

				foreach ($this->SZ_GOOGLE_YOUTUBE_API as $value) 
				{
					// Creazione codice per inserimento in embed del video specificato
					// nelle opzioni passate senza utilizzare la tecnica iframe

					if (is_array($value) and isset($value['video'])) 
					{ 
						$HTML .= 'function callbackPlayerStatus_'.$value['unique'].'(event) {';

						if (isset($value['analytics']) and $value['analytics'] == '1') 
						{
							$HTML .=		'switch (event.data){';
							$HTML .=			'case YT.PlayerState.PLAYING:';
							$HTML .=				"_gaq.push(['_trackEvent','Video','Playing',myplayer_".$value['unique'].".getVideoUrl()]);";
							$HTML .=				'break;';
							$HTML .= 		'case YT.PlayerState.ENDED:';
							$HTML .=				"_gaq.push(['_trackEvent','Video','Ended',myplayer_".$value['unique'].".getVideoUrl()]);";
							$HTML .=				'break;';
							$HTML .=			'case YT.PlayerState.PAUSED:';
							$HTML .=				"_gaq.push(['_trackEvent','Video','Paused',myplayer_".$value['unique'].".getVideoUrl()]);";
							$HTML .=			"break;";
							$HTML .=		'}';
						}

						$HTML .= '}';
					}

					// Creazione codice per inserimento in embed del video specificato
					// nelle opzioni passate senza utilizzare la tecnica iframe

					if (is_array($value) and isset($value['playlist'])) 
					{ 
						$HTML .= 'function callbackPlayerStatus_'.$value['unique'].'(event) {';

						if (isset($value['analytics']) and $value['analytics'] == '1') 
						{
							$HTML .=		'switch (event.data){';
							$HTML .=			'case YT.PlayerState.PLAYING:';
							$HTML .=				"_gaq.push(['_trackEvent','Playlist','Playing',myplayer_".$value['unique'].".getVideoUrl()]);";
							$HTML .=				'break;';
							$HTML .= 		'case YT.PlayerState.ENDED:';
							$HTML .=				"_gaq.push(['_trackEvent','Playlist','Ended',myplayer_".$value['unique'].".getVideoUrl()]);";
							$HTML .=				'break;';
							$HTML .=			'case YT.PlayerState.PAUSED:';
							$HTML .=				"_gaq.push(['_trackEvent','Playlist','Paused',myplayer_".$value['unique'].".getVideoUrl()]);";
							$HTML .=			"break;";
							$HTML .=		'}';
						}

						$HTML .= '}';
					}
				}

				$HTML .= '</script>'."\n";
	
				// Scrittura codice javascript creato per youtube API

				echo $HTML;
			}
		}
	}

	/**
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 */

	@require_once(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/functions/SZGoogleFunctionsYoutube.php');
}
