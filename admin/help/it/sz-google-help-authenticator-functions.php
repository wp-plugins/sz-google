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

<p>Ci possono essere dei casi dove non sia possibile inserire automaticamente i campi e le funzioni di controllo del codice authenticator
automaticamente, ad esempio quando sono state apportate al tema corrente delle forti personalizzazioni. In questo caso lo sviluppatore
può continuare ad utilizzare il plugin ma deve implementare le funzioni PHP direttamente nel suo tema o plugin.</p>

<p>Quando utilizzate le funzioni PHP messe a disposizione del plugin usate sempre prima un controllo per vedere se la funzione esiste,
infatti se il plugin <b>SZ-Google</b> risultasse disattivato o disinstallato il vostro tema o il vostro plugin non andrà in errore.
Ovviamente dovrete prevedere nel flusso logico del programma le condizioni di queste funzioni quando non vengono richiamate.</p>

<h2>Funzioni PHP</h2>

<table>
	<tr><td>szgoogle_authenticator_get_object()</td><td>Riferimento oggetto SZGoogleModuleAuthenticator.</td></tr>
	<tr><td>szgoogle_authenticator_get_secret(\$user)</td><td>Reperimento codice segreto per utente.</td></tr>
	<tr><td>szgoogle_authenticator_get_login_field()</td><td>Reperimento HTML per campo da aggiungere al login.</td></tr>
	<tr><td>szgoogle_authenticator_verify_code(\$user,\$code)</td><td>Verifica del codice authenticator.</td></tr>
	<tr><td>szgoogle_authenticator_create_secret()</td><td>Creazione di una chiave segreta.</td></tr>
	<tr><td>szgoogle_authenticator_create_secret_backup()</td><td>Creazione chiavi segrete di backup.</td></tr>
</table>

<h2>Codice PHP di esempio</h2>

<p>In questo esempio richiamiamo la funzione di verifica codice e lo memorizziamo in una variabile chiamata \$check che possiamo
utilizzare per i controlli nel nostro programma. La funzione ritorna un valore booleano con true o false.</p>

<pre>
if (function_exists('szgoogle_authenticator_verify_code')) {
    \$check = szgoogle_authenticator_verify_code(\$user,'289597');
}
</pre>

<p>Qui di seguito vediamo un'esempio di come inserire il campo del codice authenticator in un form personalizzato, ovviamente potete
anche utilizzare un nome e un formato HTML personalizzato senza utilizzare questa funzione, l'importante è che poi passate
l'informazione corretta alla funzione PHP per la verifica del codice <b>szgoogle_authenticator_verify_code()</b>.</p>

<pre>
&lt;form id="login"&gt;
    &lt;input id="username" type="text"/&gt;
    &lt;input id="password" type="password"/&gt;
&lt;?php
    if (function_exists('szgoogle_authenticator_get_login_field')) {
        echo szgoogle_authenticator_get_login_field();
    }
?&gt;
&lt;/form&gt;
</pre>


<h2>Avvertenze</h2>

<p>Il plugin <b>SZ-Google</b> è stato sviluppato con una tecnica di caricamento moduli singoli per ottimizzare le performance generali, 
quindi prima di utilizzare uno shortcode, un widget o una funzione PHP bisogna controllare che il modulo generale e l'opzione specifica 
risulti attivata tramite il campo opzione dedicato che trovate nel pannello di amministrazione.</p>

EOD;

/**
 * Definizione array per la creazione del navigatore di fondo
 * con i link seguenti e precedenti della documentazione
 */
$prev = array('title'=>__('authenticator setup','szgoogleadmin') ,'slug'=>'sz-google-help-authenticator-setup.php');
$next = array('title'=>__('authenticator device','szgoogleadmin'),'slug'=>'sz-google-help-authenticator-device.php');

$HTML .= $this->moduleAddHelpNavs($prev,$next);

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonForm(__('authenticator PHP','szgoogleadmin'),NULL,NULL,false,$HTML);
