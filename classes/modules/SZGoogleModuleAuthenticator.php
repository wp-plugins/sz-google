<?php
/**
 * Modulo GOOGLE AUTHENTICATOR per la definizione delle funzioni che riguardano
 * sia i widget che i shortcode ma anche filtri e azioni che il modulo
 * può integrare durante l'aggiunta di funzionalità a wordpress.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Prima della definizione della classe controllo se esiste
 * una definizione con lo stesso nome o già definita la stessa.
 */
if (!class_exists('SZGoogleModuleAuthenticator'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleModule
	 * dove bisogna ridefinire il metodo per il calcolo delle opzioni.
	 */
	class SZGoogleModuleAuthenticator extends SZGoogleModule
	{
		protected $_codeLength = 6;		

		/**
		 * Definizione della funzione costruttore che viene richiamata
		 * nel momento della creazione di un'istanza con questa classe
		 */
		function __construct() 
		{
			parent::__construct('SZGoogleModuleAuthenticator');

			// Esecuzione dei componenti esistenti legati al modulo come
			// le azioni generali e la generazione di shortcode e widget.

			$this->moduleAddActions();
		}

		/**
		 * Calcolo le opzioni legate al modulo con esecuzione dei 
		 * controlli formali di coerenza e impostazione dei default
		 *
		 * @return array
		 */
		function getOptions()
		{
			$options = get_option('sz_google_options_authenticator');

			// Controllo delle opzioni in caso di valori non esistenti
			// richiamo della funzione per il controllo isset()

			$options = $this->checkOptionIsSet($options,array(
				'authenticator_login_enable' => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'authenticator_login_type'   => SZ_PLUGIN_GOOGLE_VALUE_ONE,
				'authenticator_discrepancy'  => SZ_PLUGIN_GOOGLE_VALUE_ONE,
			));

			// Controllo delle opzioni in caso di valori non conformi
			// richiamo della funzione per il controllo yes or no

			$options = $this->checkOptionIsYesNo($options,array(
				'authenticator_login_enable' => SZ_PLUGIN_GOOGLE_VALUE_NO,
			));	

			// Ritorno indietro il gruppo di opzioni corretto dai
			// controlli formali della funzione di reperimento opzioni

			return $options;
		}

		/**
		 * Aggiungo le azioni del modulo corrente, questa funzione deve
		 * essere implementate per ogni modulo in maniera personalizzata
		 * non è possibile creare una funzione di standardizzazione
		 *
		 * @return void
		 */
		function moduleAddActions()
		{
			$options = $this->getOptions();

			// Controllo se opzione autenticazione di login risulta attiva.
			// In questo caso aggiungo filtri e azioni su fase di login.

			if ($options['authenticator_login_enable']) 
			{
				add_action('login_form'  ,array($this,'addAuthenticatorToLoginForm'));
				add_action('login_footer',array($this,'addAuthenticatorToLoginJavascript'));
				add_filter('authenticate',array($this,'addAuthenticatorCheckCode'),30,3);
			}

			// Aggiungo le opzioni al profilo che vengono viste solo se user=current nelle
			// opzioni verranno inseriti i bottone per creare una configurazione di sincronizzazione

			add_action('profile_personal_options',array($this,'addAuthenticatorProfileField'));
		    add_action('personal_options_update' ,array($this,'addAuthenticatorProfileFieldUpdate'));
			add_action('edit_user_profile'       ,array($this,'addAuthenticatorEditProfileField'));
			add_action('edit_user_profile_update',array($this,'addAuthenticatorEditProfileFieldUpdate'));

			// Se sto eseguendo una richiesta AJAX aggiungo un'azione per eseguire
			// la funzione di generazione codice secret tramite bottone e javascript

			if (defined('DOING_AJAX') && DOING_AJAX) {
				add_action( 'wp_ajax_SZGoogleAuthenticatorSecret',array($this,'getAuthenticatorCreateSecretAjax'));
			}

			// Aggiungo il file javascript per la creazione di un codice QR Code 
			// rispetto ad un contenitore <div> usando il nome hook per un caricamento mirato

			add_action('admin_enqueue_scripts', array($this,'addAuthenticatorQRCodeScript'));
		}

		/**
		 * Funzione per il controllo di autorizzazione da aggiungere
		 * come filtro principale al controllo di utente e password.
		 *
		 * @return void
		 */
		function addAuthenticatorCheckCode($userobj,$username,$password) 
		{
			// Se opzione a livello di utente è disattiva esco dalla procedura
			// senza fare ulteriori controlli sul codice di verifica doppio

			if (!isset($userobj->ID) or trim(get_user_option('sz_google_authenticator_enabled',$userobj->ID)) != SZ_PLUGIN_GOOGLE_VALUE_YES) {
				return $userobj;
			}

			// Controllo e impostazione delle variabili secret e codice inserito.
			// Una é memorizzata in anagrafica profilo e l'altra viene passata da login

			if (empty($_POST['googleauthotp'] )) $authenticator = SZ_PLUGIN_GOOGLE_VALUE_NULL;
				else $authenticator = trim($_POST['googleauthotp']);

			$options = $this->getOptions();
			$secrets = trim(get_user_option('sz_google_authenticator_secret',$userobj->ID));

			// Controllo il codice inserito nel form di login con quello
			// calcolato dalla routine interna della classe authenticator

			if ($this->verifyAuthenticatorCode($secrets,$authenticator,$options['authenticator_discrepancy']) === true) return $userobj;
				else return new WP_Error( 'invalid_google_authenticator_password', SZGooglePluginCommon::getTranslate( '<strong>ERROR</strong>: Authenticator code is incorrect.','szgoogleadmin'));
		}

		/**
		 * Calculate the code, with given secret and point in time
		 *
		 * @param string $secret
		 * @param int|null $timeSlice
		 * @return string
		 */
		public function getAuthenticatorCode($secret,$timeSlice=null)
		{
			if ($timeSlice === null) {
				$timeSlice = floor(time() / 30);
			}

			$secretkey = $this->_base32Decode($secret);

			$time     = chr(0).chr(0).chr(0).chr(0).pack('N*', $timeSlice);	// Pack time into binary string
			$hm       = hash_hmac('SHA1', $time, $secretkey, true);			// Hash it with users secret key
			$offset   = ord(substr($hm, -1)) & 0x0F;						// Use last nipple of result as index/offset
			$hashpart = substr($hm, $offset, 4);							// grab 4 bytes of the result
			$value    = unpack('N', $hashpart);								// Unpak binary value
			$value    = $value[1];											// Unpak binary value
			$value    = $value & 0x7FFFFFFF;								// Only 32 bits
			$modulo   = pow(10, $this->_codeLength);

			return str_pad($value % $modulo, $this->_codeLength, '0', STR_PAD_LEFT);
		}

		/**
		 * Check if the code is correct. This will accept codes starting 
		 * from $discrepancy*30sec ago to $discrepancy*30sec from now
		 *
		 * @param string $secret
		 * @param string $code
		 * @param int $discrepancy This is the allowed time drift in 30 second units (8 means 4 minutes before or after)
		 * @return bool
		 */
		public function verifyAuthenticatorCode($secret,$code,$discrepancy=1)
		{
			if (strlen($code) != 6) return false;

			// Esecuzione procedura per il calcolo del codice e confronto
			// con codice inserito nel form del login (verifica)

			if (!is_numeric($discrepancy)) $discrepancy=1;
				else $discrepancy = (int) $discrepancy;

			$currentTimeSlice = floor(time()/30);

			for ($i = -$discrepancy; $i <= $discrepancy; $i++) {
				if ($code == $this->getAuthenticatorCode($secret,$currentTimeSlice+$i)) {
					return true;
				}
			}

			return false;
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
		 * Funzione per la creazione di alcune chiavi di backup che
		 * devono essere utilizzate in caso di smarrimento del device
		 * fisico o comunque non momentanemente disponibile.
		 */ 
		function getAuthenticatorCreateSecretBackup() 
		{
			return array();
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
			if ($hook == 'profile.php' or $hook == 'user-edit.php') 
			{
				wp_enqueue_script('jquery');
				wp_register_script('sz_google_qrcode_script',SZ_PLUGIN_GOOGLE_PATH_ADMIN_JS.'jquery.qrcode.min.js',array('jquery'));
				wp_enqueue_script('sz_google_qrcode_script');
			}
		}

		/**
		 * Aggiungo il campo di input che riguarda il codice di sicurezza
		 * che viene generato dall'applicazione di google authenticator,
		 * in questo caso viene scelta la modalità di inserimento nel login.
		 *
		 * @return void
		 */
		function addAuthenticatorToLoginForm() {
			echo $this->addAuthenticatorGetLoginForm();
		}

		/**
		 * Aggiungo il campo di input che riguarda il codice di sicurezza
		 * che viene generato dall'applicazione di google authenticator,
		 * in questo caso viene scelta la modalità di inserimento nel login.
		 *
		 * @return string
		 */
		function addAuthenticatorGetLoginForm() 
		{
			$HTML  = '<p><label title="'.SZGooglePluginCommon::getTranslate("If you don't use Authenticator leave this field empty.",'szgoogleadmin').'">'.ucwords(SZGooglePluginCommon::getTranslate('google authenticator code','szgoogleadmin')).'<br/>';
			$HTML .= '<input type="text" name="googleauthotp" id="googleauthotp" class="input" value="" size="20"/></label></p>';

			return $HTML;
		}

		/**
		 * Funzione per aggiungere un codice javascript in fondo al form
		 * di login in maniera da disattivare la funzione autocomplete.
		 *
		 * @return void
		 */
		function addAuthenticatorToLoginJavascript() 
		{
			echo '<script type="text/javascript">';
			echo "document.getElementById('googleauthotp').setAttribute('autocomplete','off');";
			echo '</script>';
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

			if (trim(get_user_option('sz_google_authenticator_hidden',$user->ID)) == SZ_PLUGIN_GOOGLE_VALUE_YES) {
				return;
			}

			// Lettura delle opzioni utente per caricare i valori del form

			$sz_google_authenticator_enabled     = trim(get_user_option('sz_google_authenticator_enabled',$user->ID));
			$sz_google_authenticator_description = trim(get_user_option('sz_google_authenticator_description',$user->ID));
			$sz_google_authenticator_secret      = trim(get_user_option('sz_google_authenticator_secret',$user->ID));

			// Controllo valori di fefault nel caso non venga specificato niente il valore
			// secret viene rigenerato mentre la descrizione viene presa dalla configurazione

			if ($sz_google_authenticator_secret == SZ_PLUGIN_GOOGLE_VALUE_NULL) {
				$sz_google_authenticator_secret = $this->getAuthenticatorCreateSecret();
			}

			if ($sz_google_authenticator_description == SZ_PLUGIN_GOOGLE_VALUE_NULL) {
				$sz_google_authenticator_description = ucfirst($user->display_name);
			}

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

			if (trim(get_user_option('sz_google_authenticator_hidden',$user)) == SZ_PLUGIN_GOOGLE_VALUE_YES) {
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
		 * Helper class to decode base32
		 *
		 * @param $secret
		 * @return bool|string
		 */
		protected function _base32Decode($secret)
		{
			if (empty($secret)) return '';

			$base32chars = $this->_getBase32LookupTable();
			$base32charsFlipped = array_flip($base32chars);

			$paddingCharCount = substr_count($secret, $base32chars[32]);
			$allowedValues = array(6, 4, 3, 1, 0);

			if (!in_array($paddingCharCount, $allowedValues)) return false;

			for ($i = 0; $i < 4; $i++) {
				if ($paddingCharCount == $allowedValues[$i] &&
				substr($secret, -($allowedValues[$i])) != str_repeat($base32chars[32], $allowedValues[$i])) return false;
			}

			$secret = str_replace('=','', $secret);
			$secret = str_split($secret);
			$binaryString = "";

			for ($i = 0; $i < count($secret); $i = $i+8) {
				$x = "";
				if (!in_array($secret[$i], $base32chars)) return false;
				for ($j = 0; $j < 8; $j++) {
					$x .= str_pad(base_convert(@$base32charsFlipped[@$secret[$i + $j]], 10, 2), 5, '0', STR_PAD_LEFT);
				}
				$eightBits = str_split($x, 8);
				for ($z = 0; $z < count($eightBits); $z++) {
					$binaryString .= ( ($y = chr(base_convert($eightBits[$z], 2, 10))) || ord($y) == 48 ) ? $y:"";
				}
			}
			return $binaryString;
		}

		/**
		 * Helper class to encode base32
		 *
		 * @param string $secret
		 * @param bool $padding
		 * @return string
		 */
		protected function _base32Encode($secret,$padding=true)
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
		 * Get array with all 32 characters for decoding from/encoding to base32
		 *
		 * @return array
		 */
		protected function _getBase32LookupTable()
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

	/**
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 */

	if (!function_exists('szgoogle_authenticator_get_object')) {
		function szgoogle_authenticator_get_object() { 
			if (!is_a(SZGoogleModule::$SZGoogleModuleAuthenticator,'SZGoogleModuleAuthenticator')) return false;
				else return SZGoogleModule::$SZGoogleModuleAuthenticator;
		}
	}

	/**
	 * Funzione per reperire il valore della chiave segreta assegnata
	 * ad un profilo utente che deve essere passato alla funzione come ID.
	 *
	 * @param int $user
	 * @return string
	 */
	if (!function_exists('szgoogle_authenticator_get_secret')) {
		function szgoogle_authenticator_get_secret($user) { 
			return trim(get_user_option('sz_google_authenticator_secret',$user));
		}
	}

	/**
	 * Funzione per reperire il codice HTML da inserire in un form di login.
	 * Utilizzare questa funzionalità per personalizzare il login e disattivare
	 * l'inserimento automatico da parte del plugin nel pannello di amministrazione.
	 *
	 * @return string
	 */
	if (!function_exists('szgoogle_authenticator_get_login_field')) {
		function szgoogle_authenticator_get_login_field() {
			if (!$object = szgoogle_authenticator_get_object()) return false;
				else return $object->addAuthenticatorGetLoginForm();
		}
	}

	/**
	 * Funzione per controllare la validità di un codice authenticator,
	 * bisogna specificare un ID utente per associazione con secret code.
	 *
	 * @param int $user
	 * @param string $code
	 * @param int $discrepancy in 30 second units (8 means 4 minutes before or after)
	 * @return bool
	 */
	if (!function_exists('szgoogle_authenticator_verify_code')) {
		function szgoogle_authenticator_verify_code($user,$code,$discrepancy=1) {
			if (!$object = szgoogle_authenticator_get_object()) return false;
				else return $object->verifyAuthenticatorCode(szgoogle_authenticator_get_secret($user),$code,$discrepancy);
		}
	}

	/**
	 * Funzione per la creazione di una chiave segreta random da utilizzare
	 * nella propria applicazione. Ogni volta che viene creata una chiave bisogna
	 * eseguire l'operazione di sincronizzazione per utilizzarla sul device.
	 *
	 * @return string
	 */
	if (!function_exists('szgoogle_authenticator_create_secret')) {
		function szgoogle_authenticator_create_secret() { 
			if (!$object = szgoogle_authenticator_get_object()) return false;
				else return $object->getAuthenticatorCreateSecret();
		}
	}

	/**
	 * Funzione per la creazione di alcune chiavi di backup che
	 * devono essere utilizzate in caso di smarrimento del device
	 * fisico o comunque non momentanemente disponibile.
	 *
	 * @return array
	 */
	if (!function_exists('szgoogle_authenticator_create_secret_backup')) {
		function szgoogle_authenticator_create_secret_backup() { 
			if (!$object = szgoogle_authenticator_get_object()) return false;
				else return $object->getAuthenticatorCreateSecretBackup();
		}
	}
}