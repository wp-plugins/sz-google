<?php
/**
 * Codice HTML per il form di impostazione collegato 
 * al widget presente nella parte di amministrazione, questo
 * codice è su file separato per escluderlo dal frontend
 *
 * @package SZGoogle
 * @subpackage SZGoogleWidgets
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Definizione e inizializzazione array che sarà
// usato per la creazione di variabili automatiche

$variables = array();

// Lettura array e creazione identificativi nome
// con il prefisso convenzionale ID_ NAME_ VALUE_

foreach($array as $item=>$value) 
{
	$PREFIX_I = 'ID_'   .$item;
	$PREFIX_N = 'NAME_' .$item;
	$PREFIX_V = 'VALUE_'.$item;

	$variables[$PREFIX_I] = $this->get_field_id($item);
	$variables[$PREFIX_N] = $this->get_field_name($item);
	$variables[$PREFIX_V] = esc_attr(${$item});
}

// Estrazione array per la creazione di variabili
// con nome indicato nella chiave e valore associato

extract($variables,EXTR_OVERWRITE);