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
$IMAGE1 = plugin_dir_url(SZ_PLUGIN_GOOGLE_MAIN).'admin/files/images/others/sz-google-drive-viewer.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<h2>Descrizione</h2>

<p>Google Drive Viewer è un visualizzatore di documenti universale che può essere inserito in una pagina web di wordpress, grazie a
questo componente possiamo visualizzare molti formati di file senza dover installare plugin particolari o avere flash sul proprio
browser. L'utilizzo del componente è semplicissimo, basta utilizzare lo shortcode dedicato e specificare URL del file.</p>

<p>Per inserire questo componente dovete usare lo shortcode <b>[sz-drive-viewer]</b>, se invece desiderate utilizzarlo
in una sidebar allora dovete utilizzare il widget sviluppato per questa funzione che trovate nel menu aspetto -> widgets. Per i più 
esigenti esiste anche un'altra possibilità, infatti basta utilizzare una funzione PHP messa a disposizione dal plugin 
<b>szgoogle_drive_get_viewer(\$options)</b>.</p>

<h2>Personalizzazione</h2>

<p>A prescindere dalla forma che utilizzerete, il componente potrà essere personalizzato in diverse maniere, basterà usare i parametri
messi a disposizione elencati nella tabella a seguire. Per quanto riguarda il widget i parametri vengono richiesti
direttamente dall'interfaccia grafica, mentre se utilizzate lo shortcode o la funzione PHP dovete specificarli manualmente nel 
formato opzione="valore". Se volete avere delle informazioni aggiuntive potete visitare la pagina ufficiale
<a target="_blank" href="https://docs.google.com/viewer">Drive Viewer</a>.</p>

<h2>Parametri e opzioni</h2>

<table>
	<tr><th>Parametro</th>     <th>Descrizione</th>             <th>Valori ammessi</th>    <th>Default</th></tr>
	<tr><td>url</td>           <td>indirizzo URL completo</td>  <td>stringa</td>           <td>nessuno</td></tr>
	<tr><td>width</td>         <td>larghezza</td>               <td>valore</td>            <td>configurazione</td></tr>
	<tr><td>height</td>        <td>altezza</td>                 <td>valore</td>            <td>configurazione</td></tr>
	<tr><td>title</td>         <td>aggiungere un titolo</td>    <td>stringa</td>           <td>nessuno</td></tr>
	<tr><td>titleposition</td> <td>posizione del titolo</td>    <td>top,bottom</td>        <td>configurazione</td></tr>
	<tr><td>titlealign</td>    <td>allineamento del titolo</td> <td>left,right,center</td> <td>configurazione</td></tr>
	<tr><td>margintop</td>     <td>margine alto</td>            <td>valore,none</td>       <td>none</td></tr>
	<tr><td>marginrigh</td>    <td>margine destro</td>          <td>valore,none</td>       <td>none</td></tr>
	<tr><td>marginbottom</td>  <td>margine basso</td>           <td>valore,none</td>       <td>1</td></tr>
	<tr><td>marginleft</td>    <td>margine sinistro</td>        <td>valore,none</td>       <td>none</td></tr>
	<tr><td>marginunit</td>    <td>misura per margine</td>      <td>em,pt,px</td>          <td>em</td></tr>
</table>

<h2>Formati supportati</h2>

<p>I file supportati da google sono moltissimi e vengono continuamente aggiunti di nuovi, in questo momento quelli che risultano
visualizzabili sono i seguenti. Per ulteriori informazioni andate sulla pagina del 
<a target="_blank" href="https://support.google.com/drive/answer/2423485?p=docs_viewer&rd=1">supporto ufficiale</a>.</p>

<ul>
	<li>Adobe Acrobat (PDF)</li>
	<li>Adobe Illustrator (AI)</li>
	<li>Adobe Photoshop (PSD)</li>
	<li>Apple Pages (PAGES)</li>
	<li>Archive Files (ZIP/RAR)</li>
	<li>Autodesk AutoCad (DXF)</li>
	<li>Microsoft Word (DOC/DOCX*)</li>
	<li>Microsoft PowerPoint (PPT/PPTX*)</li>
	<li>Microsoft Excel (XLS/XLSX*)</li>
	<li>OpenType/TrueType Fonts (OTF, TTF)</li>
	<li>PostScript (EPS/PS)</li>
	<li>Scalable Vector Graphics (SVG)</li>
	<li>TIFF Images (TIF, TIFF)</li>
	<li>XML Paper Specification (XPS)</li>
</ul>

<h2>Esempio shortcode</h2>

<p>Gli shortcode sono delle macro che vengono inserite nei post per richiede alcune elaborazioni aggiuntive che sono state messe a 
disposizione dai plugin, dai temi o direttamente dal core. Anche il plugin <b>SZ-Google</b> mette a disposizione parecchi shortcode che
possono esseri utilizzati nella forma classica e con le opzioni di personalizzazione permesse. Per inserire uno shortcode nel nostro 
post dobbiamo utilizzare il codice in questa forma:</p>

<pre>[sz-drive-viewer url="http://domain.com/filename.pdf" title="titolo"/]</pre>

<h2>Esempio codice PHP</h2>

<p>Se volete utilizzare le funzioni PHP messe a disposizione dal plugin dovete accertarvi che il modulo corrispondente sia attivo, una 
volta verificato inserite nel punto desiderato del vostro tema un codice simile al seguente esempio, quindi preparate un array con le
opzioni desiderate e richiamate la funzione richiesta. É consigliabile utilizzare prima della funzione il controllo se questa esista,
in questa maniera non si avranno errori PHP in caso di plugin disattivato o disinstallato.</p> 

<pre>
\$options = array(
  'url'        => 'http://domain.com/filename.pdf',
  'title'      => 'titolo di prova',
  'titlealign' => 'center',
);

if (function_exists('szgoogle_drive_get_viewer')) {
  echo szgoogle_drive_get_viewer(\$options);
}
</pre>

<h2>Schermata</h2>

<p>In questa immagine potete vedere il risultato finale di questa funzionalità. Viene visualizzato un documento PDF contenete
dei dati finanziari riguardanti euribor 2013. Come potete vedere sono presenti anche alcune funzioni di navigazione.</p>

<img class="screen" src="$IMAGE1" alt=""/>

<h2>Avvertenze</h2>

<p>Il plugin <b>SZ-Google</b> è stato sviluppato con una tecnica di caricamento moduli singoli per ottimizzare le performance generali, quindi prima di 
utilizzare uno shortcode, un widget o una funzione PHP bisogna controllare che il modulo generale e l'opzione specifica risulti 
attivata tramite il campo opzione dedicato che trovate nel pannello di amministrazione.</p>

EOD;

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonFormHelp(__('drive viewer','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));