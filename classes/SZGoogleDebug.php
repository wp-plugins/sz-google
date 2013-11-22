<?php
/**
 * Classe SZGoogleDebug per elaborare la richiesta di messaggio di
 * debug da visualizzare nel file di log definito nel file php.ini
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Prima della definizione della classe controllo se esiste
 * una definizione con lo stesso nome o già definita la stessa.
 */
if (!class_exists('SZGoogleDebug'))
{
	class SZGoogleDebug
	{
		/**
		 * Progressivo break point per numerazione automatica
		 *
		 * @var numeric
		*/
		private static $point = 0;

		/**
		 * Scrittura messaggio passato alla funzione tramite stringa
		 * da visualizzare nel file di log definito nel file php.ini
		 *
		 * @param  string $message
		 * @return void
		 */
		public static function log($message)
		{
			if (self::$point == 0) error_log(self::getHeader().'***** STARTER PLUGIN *****',0);
			error_log(self::getHeader().trim($message),0);
		}

		/**
		 * Composizione parte inziale del messaggio da utilizzare
		 * come prozione standard per tutti i messagi richiesti.
		 *
		 * @return string
		 */
		protected static function getHeader() {
			self::$point++;
			$header = '(szgoogle '.SZ_PLUGIN_GOOGLE_VERSION.') '.sprintf("%04d",self::$point).' ';
			return $header;
		}
	}
}
