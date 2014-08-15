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
	'authenticator_login_enable'   => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'authenticator_login_type'     => array('N'=>'1','Y'=>'0','Z'=>'0','value' => '1'),
	'authenticator_discrepancy'    => array('N'=>'1','Y'=>'0','Z'=>'0','value' => '1'),
	'authenticator_emergency'      => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'authenticator_emergency_file' => array('N'=>'0','Y'=>'0','Z'=>'0','value' => '' ),
);