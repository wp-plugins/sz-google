<?php
/**
 * Definizione di una classe che identifica un'azione richiamata dal
 * modulo principale in base alle opzioni che sono state attivate
 * nel pannello di amministrazione o nella configurazione del plugin
 *
 * @package SZGoogle
 * @subpackage SZGoogleActions
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome

if (!class_exists('SZGoogleActionPlusComments'))
{
	/**
	 * Definizione della classe principale da utilizzare per questa
	 * azione. La classe deve essere una extends di SZGoogleAction
	 */
	class SZGoogleActionPlusComments extends SZGoogleAction
	{
		private $Module = false;

		function __construct($module) {
			$this->Module = $module;
		}

		/**
		 * Definizione della funzione che viene normalmente richiamata
		 * dagli hook presenti in add_action e add_filter di wordpress.
		 */
		function addAction() 
		{ 
			$options = $this->Module->getOptions();

			// Se è specificata opzione dopo il contenuto applico il filtro a the_content
			// altrimenti applico il filtro alla funzione di comment_template

			if ($options['plus_comments_ac_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) 
			{
				// Applicazione di un filtro al contenuto principale in quanto è
				// stato specificato di inserire i contenuti subito dopo il contenuto

				add_filter('the_content',array($this,'addPlusCommentsSystemContent'));

				// Se i commenti di wordpress standard non sono attivati e quindi non
				// è stato specificato il sistema doppio di commenti aggiungo un dummy

				if ($options['plus_comments_wp_enable'] != SZ_PLUGIN_GOOGLE_VALUE_YES)   
					add_filter('comments_template',array($this,'addPlusCommentsSystemDummy'));

			} else {

				// Applicazione di un filtro al template standard di disegno commenti
				// definito nel tema di wordpress, sempre che questo seguo lo standard

				add_filter('comments_template',array($this,'addPlusCommentsSystemTemplate'));
			}

		}
		/**
		 * Funzione per aggiungere il sistema dei commenti di google plus
		 * in fondo al post standard di wordpress, sono ammesse diverse
		 * tecniche e diversi posizionamenti, leggere la documentazione
		 *
		 * @return void
		 */
		function addPlusCommentsSystemContent($content) 
		{
			global $post,$comments;

			if (!(is_singular() && (have_comments() || 'open' == $post->comment_status))) { return $content; }

			// Creazione codice HTML per sistema di commenti richiamando
			// la funzione standard usata dallo shortcode e dal widget

			$HTML = $this->Module->getPlusCommentsCode(array(
				'url'    => get_permalink(),
				'id'     => SZ_PLUGIN_GOOGLE_PLUS_ID_COMMENTS_CONTENT,
				'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'title'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'class0' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'class1' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'class2' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action' => SZ_PLUGIN_GOOGLE_VALUE_TEXT_TEMPLATE,
			));

			// Aggiunta del codice javascript per il rendering dei widget		 
			// Questo codice viene aggiungo anche dalla sidebar però viene inserito una sola volta

			$this->Module->addCodeJavascriptFooter();

			return $content.$HTML;
		}

		/**
		 * Funzione per aggiungere il sistema dei commenti di google plus
		 * usando un template dummy che non esegua i commenti standard
		 *
		 * @return string
		 */
		function addPlusCommentsSystemDummy($include) {
			return SZ_PLUGIN_GOOGLE_BASENAME_TEMPLATE_FRONT.'sz-google-module-plus-comments-dummy.php';
		}

		/**
		 * Funzione per aggiungere il sistema dei commenti di google plus
		 * in fondo al post standard di wordpress, sono ammesse diverse
		 * tecniche e diversi posizionamenti, leggere la documentazione
		 *
		 * @return void
		 */
		function addPlusCommentsSystemTemplate($include) 
		{
			global $post,$comments;

			if (!(is_singular() && (have_comments() || 'open' == $post->comment_status))) { return; }

			// Aggiornamento delle variabili che contengono le opzioni		 
			// di eleborazione commenti e loro posizione nella pagina

			$checkdt = '00000000';
			$checkid = get_the_date('Ymd');

			$options = $this->Module->getOptions();

			// Calcolo la data di confronto per la funzione dei commenti

			if ($options['plus_comments_dt_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) 
			{
				$checkdt  = sprintf('%04d',$options['plus_comments_dt_year']);
				$checkdt .= sprintf('%02d',$options['plus_comments_dt_month']);
				$checkdt .= sprintf('%02d',$options['plus_comments_dt_day']);

				// Se devo controllare la data e non rientra nel range giusto non eseguo
				// l'elaborazione del sistema commenti e rimando a quello originale

				if ($checkid <= $checkdt) {
					return $include;
				}
			}

			// Controllo se devo mantenere i commenti standard di wordpress		 
			// in caso affermativo eseguo il file prima dei commenti di google plus

			if ($options['plus_comments_wp_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES and 
				$options['plus_comments_aw_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) 
			{   
				if (file_exists($include)) @require($include);
			}

			// Creazione codice HTML per inserimento widget commenti		 

			$HTML = $this->Module->getPlusCommentsCode(array(
				'url'    => get_permalink(),
				'id'     => SZ_PLUGIN_GOOGLE_PLUS_ID_COMMENTS_TEMPLATE,
				'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'title'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'class0' => SZ_PLUGIN_GOOGLE_PLUS_CLASS_COMMENTS,
				'class1' => trim($options['plus_comments_css_class_1']),
				'class2' => trim($options['plus_comments_css_class_2']),
				'action' => SZ_PLUGIN_GOOGLE_VALUE_TEXT_TEMPLATE,
			));

			echo $HTML;

			// Aggiunta del codice javascript per il rendering dei widget		 
			// Questo codice viene aggiungo anche dalla sidebar però viene inserito una sola volta

			$this->Module->addCodeJavascriptFooter();

			// Ritorno stesso template passato alla funzione nel caso in cui
			// devo mantenere i commenti standard dopo quelli di google plus
	
			if ($options['plus_comments_wp_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES and 
				$options['plus_comments_aw_enable'] == SZ_PLUGIN_GOOGLE_VALUE_NO) 
			{   
				return $include;
			}

			// Ritorno template di commenti dummy con nessuna azione HTML
	
			return SZ_PLUGIN_GOOGLE_BASENAME_TEMPLATE_FRONT.'sz-google-module-plus-comments-dummy.php';
		}
	}
}