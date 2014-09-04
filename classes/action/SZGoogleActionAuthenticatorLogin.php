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

if (!class_exists('SZGoogleActionAuthenticatorLogin'))
{
	/**
	 * Definizione della classe principale da utilizzare per questa
	 * azione. La classe deve essere una extends di SZGoogleAction
	 */
	class SZGoogleActionAuthenticatorLogin extends SZGoogleAction
	{
		/**
		 * Aggiungo nella fase del costruttore i filtri e le azioni
		 * necessarie a controllare il login con codice a tempo
		 */
		function __construct() 
		{
			add_action('login_form'  ,array($this,'addAuthenticatorLoginForm'));
			add_action('login_footer',array($this,'addAuthenticatorLoginJavascript'));
			add_filter('authenticate',array($this,'addAuthenticatorCheckCode'),30,3);
		}

		/**
		 * Aggiungo il campo di input che riguarda il codice di sicurezza
		 * che viene generato dall'applicazione di google authenticator,
		 *
		 * @return string
		 */
		function addAuthenticatorLoginForm() 
		{
			echo '<p><label title="'.SZGoogleCommon::getTranslate("If you don't use Authenticator leave this field empty.",'szgoogleadmin').'">'.ucwords(SZGoogleCommon::getTranslate('google authenticator code','szgoogleadmin')).'<br/>';
			echo '<input type="text" name="googleauthotp" id="googleauthotp" class="input" value="" size="20"/></label></p>';
		}

		/**
		 * Funzione per aggiungere un codice javascript in fondo al form
		 * di login in maniera da disattivare la funzione autocomplete.
		 *
		 * @return void
		 */
		function addAuthenticatorLoginJavascript() 
		{
			echo '<script type="text/javascript">';
			echo "document.getElementById('googleauthotp').setAttribute('autocomplete','off');";
			echo '</script>';
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

			if (!isset($userobj->ID) or trim(get_user_option('sz_google_authenticator_enabled',$userobj->ID)) != '1') {
				return $userobj;
			}

			// Controllo e impostazione delle variabili secret e codice inserito.
			// Una é memorizzata in anagrafica profilo e l'altra viene passata da login

			if (empty($_POST['googleauthotp'] )) $authenticator = '';
				else $authenticator = trim($_POST['googleauthotp']);

			$options = $this->getModuleOptions('SZGoogleModuleAuthenticator');
			$secrets = trim(get_user_option('sz_google_authenticator_secret',$userobj->ID));

			// Controllo il codice inserito nel form di login con quelli
			// presenti nella tabella dei codici segreti di emergenza

			if ($options['authenticator_emergency_codes'] == '1') 
			{
				$em = unserialize(trim(get_user_option('sz_google_authenticator_codes',$userobj->ID)));

				if (is_array($em) and isset($em[$authenticator]) and $em[$authenticator] == false ) 
				{
					$em[$authenticator] = time();
					update_user_option($userobj->ID,'sz_google_authenticator_codes',serialize($em),true);
					return $userobj;
				}
			}

			// Controllo il codice inserito nel form di login con quello
			// calcolato dalla routine interna della classe authenticator

			if ($this->checkAuthenticatorCode($secrets,$authenticator,$options['authenticator_discrepancy']) === true) return $userobj;
				else return new WP_Error('invalid_google_authenticator_password',SZGoogleCommon::getTranslate('<strong>ERROR</strong>: Authenticator code is incorrect.','szgoogleadmin'));
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
		function checkAuthenticatorCode($secret,$code,$discrepancy=1)
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
		 * Calculate the code, with given secret and point in time
		 *
		 * @param string $secret
		 * @param int|null $timeSlice
		 * @return string
		 */
		function getAuthenticatorCode($secret,$timeSlice=null)
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
			$modulo   = pow(10,6);

			return str_pad($value % $modulo,6,'0',STR_PAD_LEFT);
		}

		/**
		 * Helper class to decode base32
		 *
		 * @param $secret
		 * @return bool|string
		 */
		private function _base32Decode($secret)
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