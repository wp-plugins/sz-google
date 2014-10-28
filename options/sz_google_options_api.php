<?php

/**
 * Definizione array per le opzioni del plugin legate al modulo
 * corrispondente con cui sviluppare la funzione getOptions() e
 * le operazioni legate alla fase di attivazione del plugin.
 *
 * @package SZGoogle
 * @subpackage SZGoogleOptions
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Definizione array() con tutte le opzioni collegate al modulo che
// dovranno essere richiamate tramite un include(setoptions)

return array(
	'API_token'         => array('N'=>'0','Y'=>'0','Z'=>'0','value' => ''),
	'API_token_access'  => array('N'=>'0','Y'=>'0','Z'=>'0','value' => ''),
	'API_token_refresh' => array('N'=>'0','Y'=>'0','Z'=>'0','value' => ''),
);