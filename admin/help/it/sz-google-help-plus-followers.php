<?php
/**
 * Controllo se il file viene richiamato direttamente senza
 * essere incluso dalla procedura standard del plugin.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die(); 

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<h2>Descrizione</h2>

<p>Tramite questa feature è possibile inserire in una pagina web un badge contenente la lista dei followers collegati ad una pagina
o ad un profilo presente su google+. Nel badge verranno visualizzate le miniature dei profili che seguono la risorsa su google+ e viene
anche inserito un bottone per aggiungere la pagina o il profilo direttamente ad una cerchia. In questo momento il badge rilasciato
da google non è responsive, però il plugin <b>SZ-Google</b> aggiunge un parametro di width="auto" che tramite javascript 
cercherà di calcolare la larghezza del contenitore e passarla al codice di google+. Ovviamente non funzionerà in caso di
ridimensionamento finestra.</p>

<p>Per inserire questo badge dovete usare lo shortcode <b>[sz-gplus-followers]</b>, se invece desiderate utilizzarlo
in una sidebar allora dovete utilizzare il widget sviluppato per questa funzione che trovate nel menu aspetto -> widgets. Per i più 
esigenti esiste anche un'altra possibilità, infatti basta utilizzare una funzione PHP messa a disposizione dal plugin 
<b>szgoogle_gplus_get_badge_followers(\$options)</b>.</p>

<h2>Parametri e opzioni</h2>

<table>
	<tr><th>Parametro</th> <th>Descrizione</th>      <th>Valori ammessi</th>         <th>Default</th></tr>
	<tr><td>id</td>        <td>pagina o profilo</td> <td>stringa</td>                <td>configurazione</td></tr>
	<tr><td>align</td>     <td>allineamento</td>     <td>left,center,right,none</td> <td>none</td></tr>
	<tr><td>width</td>     <td>larghezza</td>        <td>valore,auto</td>            <td>configurazione</td></tr>
	<tr><td>height</td>    <td>altezza</td>          <td>valore,auto</td>            <td>configurazione</td></tr>
</table>

<h2>Esempio shortcode</h2>

<p>Gli shortcode sono delle macro che vengono inserite nei post per richiede alcune elaborazioni aggiuntive che sono state messe a 
disposizione dai plugin, dai temi o direttamente dal core. Anche il plugin <b>SZ-Google</b> mette a disposizione parecchi shortcode che
possono esseri utilizzati nella forma classica e con le opzioni di personalizzazione permesse. Per inserire uno shortcode nel nostro 
post dobbiamo utilizzare il codice in questa forma:</p>

<pre>[sz-gplus-followers url="https://plus.google.com/+wpitalyplus"/]</pre>

<h2>Esempio codice PHP</h2>

<p>Se volete utilizzare le funzioni PHP messe a disposizione dal plugin dovete accertarvi che il modulo corrispondente sia attivo, una 
volta verificato inserite nel punto desiderato del vostro tema un codice simile al seguente esempio, quindi preparate un array con le
opzioni desiderate e richiamate la funzione richiesta. É consigliabile utilizzare prima della funzione il controllo se questa esista,
in questa maniera non si avranno errori PHP in caso di plugin disattivato o disinstallato.</p> 

<pre>
\$options = array(
  'url'    => 'https://plus.google.com/+wpitalyplus',
  'width'  => 'auto',
  'height' => 'auto',
);

if (function_exists('szgoogle_gplus_get_badge_followers')) {
  echo szgoogle_gplus_get_badge_followers(\$options);
}
</pre>

<h2>Avvertenze</h2>

<p>Il plugin <b>SZ-Google</b> è stato sviluppato con una tecnica di caricamento moduli singoli per ottimizzare le performance generali, quindi prima di 
utilizzare uno shortcode, un widget o una funzione PHP bisogna controllare che il modulo generale e l'opzione specifica risulti 
attivata tramite il campo opzione dedicato che trovate nel pannello di amministrazione.</p>

EOD;

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonFormHelp(__('google+ badge followers','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));