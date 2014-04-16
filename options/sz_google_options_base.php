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
	'plus'          => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'analytics'     => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'authenticator' => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'calendar'      => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'drive'         => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'fonts'         => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'groups'        => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'hangouts'      => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'panoramio'     => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'translate'     => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'youtube'       => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'documentation' => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
);