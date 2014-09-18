<?php
/**
 * Codice HTML per il form di impostazione collegato 
 * al widget presente nella parte di amministrazione, questo
 * codice è su file separato per escluderlo dal frontend
 *
 * @package SZGoogle
 * @subpackage SZGoogleTinyMCE
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Chiusura del FORM per contenere i parametri che devono essere
// indicati nello shortcode che andremmo a comporre con OK

echo '<div style="text-align:right">';
echo '<input type="submit" onclick="javascript:SZGoogleDialog.insert(SZGoogleDialog.local_ed)" style="margin-left:5px" class="button button-primary" value="'  .ucfirst(__('confirm','szgoogleadmin')).'"/>';
echo '<input type="submit" onclick="javascript:SZGoogleDialog.cancel(SZGoogleDialog.local_ed)" style="margin-left:5px" class="button button-secondary" value="'.ucfirst(__('cancel' ,'szgoogleadmin')).'"/>';
echo '</div>';

echo "</form>\n";

// Caricamento Footer comune della parte di amministrazione
// in maniera tale da caricare i stili che servono per FORM

require(ABSPATH.'/wp-admin/admin-footer.php');