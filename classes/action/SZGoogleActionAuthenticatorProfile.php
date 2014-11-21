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

if (!class_exists('SZGoogleActionAuthenticatorProfile'))
{
	/**
	 * Definizione della classe principale da utilizzare per questa
	 * azione. La classe deve essere una extends di SZGoogleAction
	 */
	class SZGoogleActionAuthenticatorProfile extends SZGoogleAction
	{
		/**
		 * Aggiungo nella fase del costruttore i filtri e le azioni
		 * necessarie a controllare il login con codice a tempo
		 */
		function __construct() 
		{
			// Aggiungo le opzioni al profilo che vengono viste solo se user=current nelle
			// opzioni verranno inseriti i bottone per creare una configurazione di sincronizzazione

			add_action('profile_personal_options',array($this,'addAuthenticatorProfileField'));
		    add_action('personal_options_update' ,array($this,'addAuthenticatorProfileFieldUpdate'));
			add_action('edit_user_profile'       ,array($this,'addAuthenticatorEditProfileField'));
			add_action('edit_user_profile_update',array($this,'addAuthenticatorEditProfileFieldUpdate'));

			// Se sto eseguendo una richiesta AJAX aggiungo un'azione per eseguire
			// la funzione di generazione codice secret tramite bottone e javascript

			if (defined('DOING_AJAX') && DOING_AJAX) {
				add_action('wp_ajax_SZGoogleAuthenticatorCodes' ,array($this,'getAuthenticatorCreateCodesAjax'));
				add_action('wp_ajax_SZGoogleAuthenticatorSecret',array($this,'getAuthenticatorCreateSecretAjax'));
			}

			// Aggiungo il file javascript per la creazione di un codice QR Code 
			// rispetto ad un contenitore <div> usando il nome hook per un caricamento mirato

			add_action('admin_enqueue_scripts', array($this,'addAuthenticatorQRCodeScript'));
		}

		/**
		 * Funzione per aggiungere i campi di attivazione di google authenticator
		 * a livello utente, queste opzioni sono visibili dall'utente corrente.
		 *
		 * @return void
		 */
		function addAuthenticatorProfileField($user) 
		{
			// Se amministratore nasconde le informazioni di google authenticator
			// per questo profilo utente non eseguo nessun aggiornamento database

			if (trim(get_user_option('sz_google_authenticator_hidden',$user->ID)) == '1') {
				return;
			}

			// Caricamento opzioni per le variabili di configurazione che
			// contengono le opzioni che devono essere attivate o disattivate

			$options = (object) $this->getModuleOptions('SZGoogleModuleAuthenticator');

			// Lettura delle opzioni utente per caricare i valori del form
			// Dopo il caricamento eseguo alcuni controlli di coerenza sui dati

			$sz_google_authenticator_codes       = trim(get_user_option('sz_google_authenticator_codes'      ,$user->ID));
			$sz_google_authenticator_enabled     = trim(get_user_option('sz_google_authenticator_enabled'    ,$user->ID));
			$sz_google_authenticator_description = trim(get_user_option('sz_google_authenticator_description',$user->ID));
			$sz_google_authenticator_secret      = trim(get_user_option('sz_google_authenticator_secret'     ,$user->ID));

			// Controllo valori di default nel caso non venga specificato niente il valore
			// secret viene rigenerato mentre la descrizione viene presa dalla configurazione

			if ($sz_google_authenticator_secret == '') {
				$sz_google_authenticator_secret = $this->getAuthenticatorCreateSecret();
			}

			if ($sz_google_authenticator_description == '') {
				$sz_google_authenticator_description = ucfirst($user->display_name);
			}

			// Controllo i codici di emergenza. Se non è specificato niente o il valore
			// ritornato non contiene un'array chiamo la funzione per una nuova generazione

			if ($sz_google_authenticator_codes == '') {
				$sz_google_authenticator_codes = serialize($this->getAuthenticatorCreateCodes());
			}

			if (!is_array(unserialize($sz_google_authenticator_codes))) {
				$sz_google_authenticator_codes = serialize($this->getAuthenticatorCreateCodes());
			}

			// Deserializzo il contenuto dei codici di emergenza per associare
			// alla tabella i valori iniziali e definire quelli utilizzati

			$em = unserialize($sz_google_authenticator_codes);
			$ec = array_keys($em);

			// Creazione codic e HTML per la creazione della sezione profile

			echo '<h3>'.ucwords(__( 'google authenticator','szgoogleadmin' )).'</h3>';
			echo '<table class="form-table">';
			echo '<tbody>';

			// Aggiungo opzione per abilitare authenticator su utente attuale

			echo '<tr>';
			echo '<th scope="row">'.ucfirst(__('active','szgoogleadmin')).'</th>';
			echo '<td><input name="sz_google_authenticator_enabled" id="sz_google_authenticator_enabled" class="tog" type="checkbox" value="1" '.checked($sz_google_authenticator_enabled,'1',false ).'/>'; echo '</td>';
			echo '</tr>';

			// Aggiungo opzione per la descrizione da utilizzare su applicazione device

			echo '<tr>';
			echo '<th><label for="sz_google_authenticator_description">'.ucfirst(__('description','szgoogleadmin')).'</label></th>';
			echo '<td><input name="sz_google_authenticator_description" id="sz_google_authenticator_description" value="'.$sz_google_authenticator_description.'" type="text" size="25" class="sz-google-input"/></td>';
			echo '</tr>';

			// Aggiungo opzione per la stringa de codice segreto da utilizzare in sincronizzazione
			// Vicino il campo inserisco i due bottone per azioni di generazione codice

			echo '<tr><th><label for="sz_google_authenticator_secret">'.ucfirst(__('secret','szgoogleadmin')).'</label></th><td>';
			echo '<input name="sz_google_authenticator_generate" id="sz_google_authenticator_generate" value="'.ucfirst(__('create new code','szgoogleadmin')).'" type="button" class="sz-google-input button"/><br/>';
			echo '<input name="sz_google_authenticator_shqrcode" id="sz_google_authenticator_shqrcode" value="'.__('SHOW/HIDE','szgoogleadmin').'" type="button" class="sz-google-input button" onclick="SZGoogleSwitchQRCode();"/>';
			echo '</td></tr>';

			// Aggiungo la sessione nascosta per la visualizzazione del QR Code

			echo '<tr id="sz_google_authenticator_wrap" style="display:none">';
			echo '<th>'.__('QR Code','szgoogleadmin').'</th><td>';
			echo '<input name="sz_google_authenticator_secret" id="sz_google_authenticator_secret" value="'.$sz_google_authenticator_secret.'" readonly="readonly" type="text" size="25" class="sz-google-input"/><br/><br/>';
			echo '<div id="sz_google_authenticator_qrcode"/></div>';
			echo '<span class="description"><br/> '.ucfirst(__( 'scan this QR Code with<br/> the Google Authenticator App.','szgoogleadmin')).'</span></td>';
			echo '</tr>';

			// Aggiungo opzione per la generazione e la visualizzazione dei codici di
			// emergenza da utilizzare al posto della password a tempo generata dal device

			if ($options->authenticator_emergency_codes == '1') {

				echo '<tr><th><label for="sz_google_authenticator_codes">'.ucfirst(__('emergency codes','szgoogleadmin')).'</label></th><td>';
				echo '<input name="sz_google_authenticator_codeg" id="sz_google_authenticator_codeg" value="'.ucfirst(__('create new codes','szgoogleadmin')).'" type="button" class="sz-google-input button"/><br/>';
				echo '<input name="sz_google_authenticator_coded" id="sz_google_authenticator_coded" value="'.__('SHOW/HIDE','szgoogleadmin').'" type="button" class="sz-google-input button" onclick="SZGoogleSwitchTableCode();"/>';
				echo '</td></tr>';

				// Controllo array dei codici di emergenza se contengono il valore false o
				// la data di utilizzo. In base al controllo imposto il colore rosso per usato.

				if ($em[$ec[0]]  == false) $style01 = ''; else $style01 = ' style="color:red;"';
				if ($em[$ec[1]]  == false) $style02 = ''; else $style02 = ' style="color:red;"';
				if ($em[$ec[2]]  == false) $style03 = ''; else $style03 = ' style="color:red;"';
				if ($em[$ec[3]]  == false) $style04 = ''; else $style04 = ' style="color:red;"';
				if ($em[$ec[4]]  == false) $style05 = ''; else $style05 = ' style="color:red;"';
				if ($em[$ec[5]]  == false) $style06 = ''; else $style06 = ' style="color:red;"';
				if ($em[$ec[6]]  == false) $style07 = ''; else $style07 = ' style="color:red;"';
				if ($em[$ec[7]]  == false) $style08 = ''; else $style08 = ' style="color:red;"';
				if ($em[$ec[8]]  == false) $style09 = ''; else $style09 = ' style="color:red;"';
				if ($em[$ec[9]]  == false) $style10 = ''; else $style10 = ' style="color:red;"';
				if ($em[$ec[10]] == false) $style11 = ''; else $style11 = ' style="color:red;"';
				if ($em[$ec[11]] == false) $style12 = ''; else $style12 = ' style="color:red;"';

				// Aggiungo la tabella nascosta da visualizzare sotto richiesta che contiene
				// tutti i codici di emergenza generati manualmente o caricati dal profilo

				echo '<tr id="sz_google_authenticator_table" style="display:none">';
				echo '<th>'.ucfirst(__('table codes','szgoogleadmin')).'</th><td>';
				echo '<table class="sz-google-codes">';
				echo '<tr><td><div id="szga01"'.$style01.'>'.$ec[0].'</div></td><td><div id="szga02"'.$style02.'>'.$ec[1] .'</div></td><td><div id="szga03"'.$style03.'>'.$ec[2] .'</div></td></tr>';
				echo '<tr><td><div id="szga04"'.$style04.'>'.$ec[3].'</div></td><td><div id="szga05"'.$style05.'>'.$ec[4] .'</div></td><td><div id="szga06"'.$style06.'>'.$ec[5] .'</div></td></tr>';
				echo '<tr><td><div id="szga07"'.$style07.'>'.$ec[6].'</div></td><td><div id="szga08"'.$style08.'>'.$ec[7] .'</div></td><td><div id="szga09"'.$style09.'>'.$ec[8] .'</div></td></tr>';
				echo '<tr><td><div id="szga10"'.$style10.'>'.$ec[9].'</div></td><td><div id="szga11"'.$style11.'>'.$ec[10].'</div></td><td><div id="szga12"'.$style12.'>'.$ec[11].'</div></td></tr>';
				echo '</table>';
				echo '<div style="display:none"><input name="sz_google_authenticator_codes" id="sz_google_authenticator_codes" value="'.$sz_google_authenticator_codes.'" readonly="readonly" type="text" size="25" class="sz-google-input"/></div>';
				echo '</td></tr>';

			} else {

				echo '<tr id="sz_google_authenticator_table" style="display:none"><th></th>';
				echo '<td><div style="display:none"><input name="sz_google_authenticator_codes" id="sz_google_authenticator_codes" value="'.$sz_google_authenticator_codes.'" readonly="readonly" type="text" size="25" class="sz-google-input"/></div></td>';
				echo '</tr>';
			}	

			echo '</tbody></table>'."\n";

			// Inizio codice javascript per eseguire le azioni sui bottoni aggiunti
			// nel profilo utente che riguardano la generazione del codice e il QR Code.

			echo '<script type="text/javascript">'."\n";
			echo "var SZGAction='SZGoogleAuthenticatorSecret';\n";
			echo "var SZHAction='SZGoogleAuthenticatorCodes';\n";
			echo "var SZGAnonce='".wp_create_nonce('SZGoogleAuthenticatorSecret')."';\n";
			echo "var SZHAnonce='".wp_create_nonce('SZGoogleAuthenticatorCodes')."';\n";

echo <<<ENDOFJS

				// Evento CLICK sulla generazione del codice segreto con QR Code
				// chiamata AJAX alla funzione Wordpress precedentemente definita

				jQuery('#sz_google_authenticator_generate').bind('click', function() {

					jQuery('#sz_google_authenticator_qrcode').html('');

					var data=new Object();

					data['action'] = SZGAction;
					data['nonce']  = SZGAnonce;

					jQuery.post(ajaxurl,data,function(response) {
						jQuery('#sz_google_authenticator_secret').val(response['secret']);
						var qrcode="otpauth://totp/WordPress:"+escape(jQuery('#sz_google_authenticator_description').val())+"?secret="+jQuery('#sz_google_authenticator_secret').val()+"&issuer=WordPress";
						jQuery('#sz_google_authenticator_qrcode').qrcode(qrcode);
						jQuery('#sz_google_authenticator_wrap').show('slow');
					});  	

				});

				// Funzione legata all'evento click del bottone legato alla
				// richiesta della generazione di un nuovo codici segreto

				function SZGoogleSwitchQRCode() {
					if (jQuery('#sz_google_authenticator_wrap').is(':hidden')) {
						var qrcode="otpauth://totp/WordPress:"+escape(jQuery('#sz_google_authenticator_description').val())+"?secret="+jQuery('#sz_google_authenticator_secret').val()+"&issuer=WordPress";
						jQuery('#sz_google_authenticator_qrcode').qrcode(qrcode);
						jQuery('#sz_google_authenticator_wrap').show('slow');
					} else {
						jQuery('#sz_google_authenticator_wrap').hide('slow');
						jQuery('#sz_google_authenticator_qrcode').html('');
					}
				}

				// Evento CLICK sulla generazione dei codici segreti di emergenza
				// chiamata AJAX alla funzione Wordpress precedentemente definita

				jQuery('#sz_google_authenticator_codeg').bind('click', function() {

					var prog = 0;
					var data = new Object();

					data['action'] = SZHAction;
					data['nonce']  = SZHAnonce;

					jQuery.post(ajaxurl,data,function(response) {
						for (i in response['codici']) { 
							prog = prog + 1; if (prog < 10) chars = '0' + prog; else chars = prog;
							jQuery('#szga'+chars).html(i);

						};
						jQuery('#sz_google_authenticator_codes').val(response['serial']);
						jQuery('#sz_google_authenticator_table').show('slow');
					});  	
				});

				// Funzione legata all'evento click del bottone legato alla
				// richiesta della generazione di nuovi codici di emergenza

				function SZGoogleSwitchTableCode() {
					if (jQuery('#sz_google_authenticator_table').is(':hidden')) {
						jQuery('#sz_google_authenticator_table').show('slow');
					} else {
						jQuery('#sz_google_authenticator_table').hide('slow');
					}
				}

			</script>
ENDOFJS;

		}

		/**
		 * Funzione per aggiornare i campi di google authenticator
		 * sul database wordpress per il record dell'utente modificato.
		 *
		 * @return void
		 */
		function addAuthenticatorProfileFieldUpdate($user) 
		{
			// Se amministratore nasconde le informazioni di google authenticator
			// per questo profilo utente non eseguo nessun aggiornamento database

			if (trim(get_user_option('sz_google_authenticator_hidden',$user)) == '1') {
				return;
			}

			// Se utente corrente può modificare il profilo eseguo update
			// che riguardano le opzioni del profilo utente modificato.

			if (current_user_can('edit_user',$user))
			{
				if (!isset($_POST['sz_google_authenticator_codes']))   $_POST['sz_google_authenticator_codes']   = '';
				if (!isset($_POST['sz_google_authenticator_enabled'])) $_POST['sz_google_authenticator_enabled'] = '0';

				$sz_google_authenticator_codes	     = trim($_POST['sz_google_authenticator_codes']);
				$sz_google_authenticator_enabled	 = trim($_POST['sz_google_authenticator_enabled']);
				$sz_google_authenticator_secret	     = trim($_POST['sz_google_authenticator_secret']);

				$sz_google_authenticator_description = trim(sanitize_text_field($_POST['sz_google_authenticator_description']));

				update_user_option($user,'sz_google_authenticator_codes'      ,$sz_google_authenticator_codes      ,true);
				update_user_option($user,'sz_google_authenticator_enabled'    ,$sz_google_authenticator_enabled    ,true);
				update_user_option($user,'sz_google_authenticator_description',$sz_google_authenticator_description,true);
				update_user_option($user,'sz_google_authenticator_secret'     ,$sz_google_authenticator_secret     ,true);
			}
		}

		/**
		 * Funzione per aggiungere i campi di attivazione di google authenticator
		 * a livello utente, queste opzioni sono visibili dall'utente amministratore.
		 *
		 * @return void
		 */
		function addAuthenticatorEditProfileField($user) 
		{
			$sz_google_authenticator_hidden  = trim(get_user_option('sz_google_authenticator_hidden' ,$user->ID));
			$sz_google_authenticator_enabled = trim(get_user_option('sz_google_authenticator_enabled',$user->ID));

			echo '<h3>'.ucfirst(__('Google Authenticator Settings','szgoogleadmin')).'</h3>';
			echo '<table class="form-table">';
			echo '<tbody>';
			echo '<tr>';
			echo '<th scope="row">'.ucfirst(__('hide settings from user','szgoogleadmin')).'</th>';
			echo '<td><div><input name="sz_google_authenticator_hidden" id="sz_google_authenticator_hidden" class="tog" type="checkbox" value="1" '.checked($sz_google_authenticator_hidden,'1',false).'/></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<th scope="row">'.ucfirst(__('active','szgoogleadmin')).'</th>';
			echo '<td><input name="sz_google_authenticator_enabled" id="sz_google_authenticator_enabled" class="tog" type="checkbox" value="1" '.checked($sz_google_authenticator_enabled,'1',false ).'/>'; echo '</td>';
			echo '</tr>';
			echo '</tbody>';
			echo '</table>';
		}

		/**
		 * Funzione per aggiornare i campi di google authenticator
		 * sul database wordpress per il record dell'utente modificato.
		 *
		 * @return void
		 */
		function addAuthenticatorEditProfileFieldUpdate($user) 
		{
			if (current_user_can('edit_user',$user)) 
			{
				if (!isset($_POST['sz_google_authenticator_hidden']))  $_POST['sz_google_authenticator_hidden']  = '0';
				if (!isset($_POST['sz_google_authenticator_enabled'])) $_POST['sz_google_authenticator_enabled'] = '0';

				$sz_google_authenticator_hidden	 = trim($_POST['sz_google_authenticator_hidden']);
				$sz_google_authenticator_enabled = trim($_POST['sz_google_authenticator_enabled']);

				update_user_option($user,'sz_google_authenticator_hidden' ,$sz_google_authenticator_hidden ,true);
				update_user_option($user,'sz_google_authenticator_enabled',$sz_google_authenticator_enabled,true);
			}
		}

		/**
		 * Funzione per la creazione di una chiave secret in maniera random
		 * utilizzando 16 caratteri e la funzione nativa di wordpress
		 */ 
		function getAuthenticatorCreateSecret($secretLength=16) 
		{
			$validChars = $this->_getBase32LookupTable();
			$secret = ''; unset($validChars[32]);

			for ($i = 0; $i < $secretLength; $i++) {
				$secret .= $validChars[array_rand($validChars)];
			}

			return $secret;
		}

		/**
		 * Funzione per la creazione di una chiave secret in maniera random
		 * tramite una chiamata AJAX per la richiesta di rigenerazione.
		 */ 
		function getAuthenticatorCreateSecretAjax() 
		{
			check_ajax_referer('SZGoogleAuthenticatorSecret','nonce');

			header('Content-Type: application/json');
			echo json_encode(array('secret' => $this->getAuthenticatorCreateSecret()));

			die(); 
		}

		/**
		 * Funzione per la creazione dei codici di emergenza da utilizzare
		 * nel caso di problemi con il device che genera la password a tempo
		 */ 
		function getAuthenticatorCreateCodes() 
		{
			$codes = array();

			// Creazione di dieci codici di emergenza
			// e memorizzazione in array da serializzare

			while (count($codes) < 12) {
				$random = rand(100000,999999);
				$codes[$random] = false;
			}

			// Ordinamento array per chiave in cui sono
			// memorizzati i codici di emergenza per il login

			ksort($codes);

			return $codes;
		}

		/**
		 * Funzione per la creazione di una chiave secret in maniera random
		 * tramite una chiamata AJAX per la richiesta di rigenerazione.
		 */ 
		function getAuthenticatorCreateCodesAjax() 
		{
			check_ajax_referer('SZGoogleAuthenticatorCodes','nonce');

			$codici = $this->getAuthenticatorCreateCodes();

			header('Content-Type: application/json');
			echo json_encode(array('codici' => $codici,'serial' => serialize($codici)));

			die(); 
		}

		/**
		 * Aggiungo libreria jquery per la creazione di un codice QR Code.
		 * La libreria viene utilizzata per il bottone presente sulla scheda
		 * profilo che visualizza il QR Code di sincronizzazione.
		 *
		 * @return void
		 */
		function addAuthenticatorQRCodeScript($hook)
		{
			if ($hook == 'profile.php' or $hook == 'user-edit.php') {
				wp_enqueue_script('jquery');
				wp_register_script('sz_google_qrcode_script',plugin_dir_url(SZ_PLUGIN_GOOGLE_MAIN).'admin/files/js/jquery.qrcode.min.js',array('jquery'));
				wp_enqueue_script('sz_google_qrcode_script');
			}
		}

		/**
		 * Helper class to encode base32
		 *
		 * @param string $secret
		 * @param bool $padding
		 * @return string
		 */
		private function _base32Encode($secret,$padding=true)
		{
			if (empty($secret)) return '';

			$base32chars = $this->_getBase32LookupTable();

			$secret = str_split($secret);
			$binaryString = "";

			for ($i = 0; $i < count($secret); $i++) {
				$binaryString .= str_pad(base_convert(ord($secret[$i]), 10, 2), 8, '0', STR_PAD_LEFT);
			}

			$fiveBitBinaryArray = str_split($binaryString, 5);
			$base32 = "";
			$i = 0;

			while ($i < count($fiveBitBinaryArray)) {
				$base32 .= $base32chars[base_convert(str_pad($fiveBitBinaryArray[$i], 5, '0'), 2, 10)];
				$i++;
			}

			if ($padding && ($x = strlen($binaryString) % 40) != 0) {
				if ($x == 8) $base32 .= str_repeat($base32chars[32], 6);
					elseif ($x == 16) $base32 .= str_repeat($base32chars[32], 4);
					elseif ($x == 24) $base32 .= str_repeat($base32chars[32], 3);
					elseif ($x == 32) $base32 .= $base32chars[32];
			}

			return $base32;
		}

		/**
		 * Tabella di 32 caratteri con il set che deve essere utilizzato
		 * durante la funzione di codifica o decodifica in base32()
		 *
		 * @return array
		 */
		private function _getBase32LookupTable()
		{
			return array(
				'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', //  7
				'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', // 15
				'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', // 23
				'Y', 'Z', '2', '3', '4', '5', '6', '7', // 31
				'='  // padding char
			);
		}		
	}
}