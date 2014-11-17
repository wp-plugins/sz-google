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
	'hangouts_start_widget'    => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'hangouts_start_shortcode' => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'hangouts_start_logged'    => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'hangouts_start_guest'     => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
);