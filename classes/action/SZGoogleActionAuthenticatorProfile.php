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

			// Lettura delle opzioni utente per caricare i valori del form

			$sz_google_authenticator_enabled     = trim(get_user_option('sz_google_authenticator_enabled',$user->ID));
			$sz_google_authenticator_description = trim(get_user_option('sz_google_authenticator_description',$user->ID));
			$sz_google_authenticator_secret      = trim(get_user_option('sz_google_authenticator_secret',$user->ID));

			// Controllo valori di fefault nel caso non venga specificato niente il valore
			// secret viene rigenerato mentre la descrizione viene presa dalla configurazione

			if ($sz_google_authenticator_secret == '') {
				$sz_google_authenticator_secret = $this->getAuthenticatorCreateSecret();
			}

			if ($sz_google_authenticator_description == '') {
				$sz_google_authenticator_description = ucfirst($user->display_name);
			}

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
			echo '<td><input name="sz_google_authenticator_description" id="sz_google_authenticator_description" value="'.$sz_google_authenticator_description.'" type="text" size="25"/></td>';
			echo '</tr>';

			// Aggiungo opzione per la stringa de codice segreto da utilizzare in sincronizzazione
			// Vicino il campo inserisco i due bottone per azioni di generazione codice

			echo '<tr>';
			echo '<th><label for="sz_google_authenticator_secret">'.ucfirst(__('secret','szgoogleadmin')).'</label></th>';
			echo '<td>';
			echo '<input name="sz_google_authenticator_secret" id="sz_google_authenticator_secret" value="'.$sz_google_authenticator_secret.'" readonly="readonly" type="text" size="25"/>';
			echo '<input name="sz_google_authenticator_generate" id="sz_google_authenticator_generate" value="'.ucfirst(__('create new secret code','szgoogleadmin')).'" type="button" class="button"/>';
			echo '</td>';
			echo '</tr>';

			echo '<tr>';
			echo '<th><label for="show_qr">'.__('QR Code','szgoogleadmin').'</label></th>';
			echo '<td>';
			echo '<input name="show_qr" id="show_qr" value="'.__('SHOW/HIDE','szgoogleadmin').'" type="button" class="button" onclick="SZGoogleswitchQRCode();"/>';
			echo '</td>';
			echo '</tr>';

			// Aggiungo la sessione nascosta per la visualizzazione del QR Code

			echo '<tr id="sz_google_authenticator_wrap" style="display:none">';
			echo '<th></th>';
			echo '<td><div id="sz_google_authenticator_qrcode"/></div>';
			echo '<span class="description"><br/> '.ucfirst(__( 'scan this QR Code with<br/> the Google Authenticator App.','szgoogleadmin')).'</span></td>';
			echo '</tr>';

			echo '</tbody></table>'."\n";

			// Inizio codice javascript per eseguire le azioni sui bottoni aggiunti
			// nel profilo utente che riguardano la generazione del codice e il QR Code.

			echo '<script type="text/javascript">'."\n";
			echo "var SZGAction='SZGoogleAuthenticatorSecret';\n";
			echo "var SZGAnonce='".wp_create_nonce('SZGoogleAuthenticatorSecret')."';\n";

echo <<<ENDOFJS

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

				function SZGoogleswitchQRCode() {
					if (jQuery('#sz_google_authenticator_wrap').is(':hidden')) {
						var qrcode="otpauth://totp/WordPress:"+escape(jQuery('#sz_google_authenticator_description').val())+"?secret="+jQuery('#sz_google_authenticator_secret').val()+"&issuer=WordPress";
						jQuery('#sz_google_authenticator_qrcode').qrcode(qrcode);
						jQuery('#sz_google_authenticator_wrap').show('slow');
					} else {
						jQuery('#sz_google_authenticator_wrap').hide('slow');
						jQuery('#sz_google_authenticator_qrcode').html('');
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
				if (!isset($_POST['sz_google_authenticator_enabled'])) $_POST['sz_google_authenticator_enabled'] = '0';

				$sz_google_authenticator_enabled	 = trim($_POST['sz_google_authenticator_enabled']);
				$sz_google_authenticator_description = trim(sanitize_text_field($_POST['sz_google_authenticator_description']));
				$sz_google_authenticator_secret	     = trim($_POST['sz_google_authenticator_secret']);

				update_user_option($user,'sz_google_authenticator_enabled',$sz_google_authenticator_enabled,true);
				update_user_option($user,'sz_google_authenticator_description',$sz_google_authenticator_description,true);
				update_user_option($user,'sz_google_authenticator_secret',$sz_google_authenticator_secret,true);
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
			$sz_google_authenticator_hidden  = trim(get_user_option('sz_google_authenticator_hidden',$user->ID));
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

				update_user_option($user,'sz_google_authenticator_hidden',$sz_google_authenticator_hidden,true);
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