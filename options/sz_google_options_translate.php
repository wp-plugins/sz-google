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
	'translate_meta'         => array('N'=>'0','Y'=>'0','Z'=>'0','value' => '' ),
	'translate_mode'         => array('N'=>'1','Y'=>'0','Z'=>'0','value' => 'I1'),
	'translate_language'     => array('N'=>'1','Y'=>'0','Z'=>'0','value' => '99'),
	'translate_to'           => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'translate_widget'       => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'translate_shortcode'    => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'translate_automatic'    => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'translate_multiple'     => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'translate_analytics'    => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'translate_analytics_ua' => array('N'=>'0','Y'=>'0','Z'=>'0','value' => '' ),
);