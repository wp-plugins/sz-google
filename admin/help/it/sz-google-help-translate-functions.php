<?php
/**
 * Controllo se il file viene richiamato direttamente senza
 * essere incluso dalla procedura standard del plugin.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die(); 

/**
 * Definizione variabili per calcolare percorsi, immagini
 * e qualsiasi risorsa che debba essere specificata in EOD
 */
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-translate-php.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>Il plugin <b>SZ-Google</b> mette a disposizione delle funzioni per inserire automaticamente il codice del selettore di lingua
nel proprio tema, però se per qualche esigenza particolare volete utilizzare l'inserimento del codice manualmente sul vostro sito 
ma continuando ad utilizzare il pannello di amministrazione per i parametri relativi all'account, potete utilizzare le funzioni 
PHP messe a disposizione dal plugin e implementarle con il vostro codice. Le funzioni messe a disposizione sono le seguenti:</p>

<ul>
<li>szgoogle_get_translate_code()</li>
<li>szgoogle_get_translate_meta()</li>
<li>szgoogle_get_translate_meta_ID()</li>
</ul>

<p>Ad esempio se volessimo inserire il codice nel nostro tema e prendere solo le opzioni che riguardano l'account potremmo utilizzare
un codice PHP simile al seguente dove viene utilizzata la funzione <b>szgoogle_get_translate_meta_ID()</b>.</p>
<pre>
&lt;meta name="google-translate-customization" content="&lt;?php echo szgoogle_get_translate_meta_ID() ?&gt"/&gt;
</pre>

<p>Se invece volessimo inserire il codice generato automaticamente dal plugin ma in una posizione ben definita del nostro tema possiamo
utilizzare la funzione PHP <b>szgoogle_get_translate_meta()</b> e inserirla nel punto preciso che desideriamo.</p>

<pre>
&lt;head&gt;
  if (function_exists('szgoogle_get_translate_meta')) {
    echo szgoogle_get_translate_meta();
  }
&lt;/head&gt;
</pre>

<h2>Schermata</h2>

<p>In questa immagine potete vedere il componente inserito in un post di wordpress, la dimensione e alcune opzioni legate all'aspetto
possono essere modificate con i parametri di configurazione. La zona più adatta alla pubblicazione di queste informazioni 
sono le sidebar, ma alcune volte può essere utile inserirli in un'articolo per sponsorizzare una determinata risorsa.</p>

<img class="screen" src="$IMAGE1" alt=""/>

<h2>Avvertenze</h2>

<p>Il plugin <b>SZ-Google</b> è stato sviluppato con una tecnica di caricamento moduli singoli per ottimizzare le performance generali, 
quindi prima di utilizzare uno shortcode, un widget o una funzione PHP bisogna controllare che il modulo generale e l'opzione specifica 
risulti attivata tramite il campo opzione dedicato che trovate nel pannello di amministrazione.</p>

EOD;

/**
 * Definizione array per la creazione del navigatore di fondo
 * con i link seguenti e precedenti della documentazione
 */
$prev = array('title'=>__('analytics setup','szgoogleadmin'),'slug'=>'sz-google-help-translate-setup.php');
$next = array('title'=>__('youtube video'  ,'szgoogleadmin'),'slug'=>'sz-google-help-youtube-video.php');

$HTML .= $this->moduleAddHelpNavs($prev,$next);

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonForm(__('translate PHP functions','szgoogleadmin'),NULL,NULL,false,$HTML);