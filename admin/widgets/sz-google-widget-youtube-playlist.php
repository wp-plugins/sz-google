<?php
/**
 * Codice HTML per il form di impostazione collegato 
 * al widget presente nella parte di amministrazione, questo
 * codice è su file separato per escluderlo dal frontend
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Definizione dei nome per le variabili CSS id

$ID_title          = $this->get_field_id('title');
$ID_id             = $this->get_field_id('id');
$ID_width          = $this->get_field_id('width');
$ID_width_auto     = $this->get_field_id('width_auto');
$ID_height         = $this->get_field_id('height');
$ID_height_auto    = $this->get_field_id('height_auto');

// Definizione dei nome per le variabili CSS name

$NAME_title        = $this->get_field_name('title');
$NAME_id           = $this->get_field_name('id');
$NAME_width        = $this->get_field_name('width');
$NAME_width_auto   = $this->get_field_name('width_auto');
$NAME_height       = $this->get_field_name('height');
$NAME_height_auto  = $this->get_field_name('height_auto');

// Definizione dei nome per le variabili contenuto

$VALUE_title       = esc_attr($title);
$VALUE_id          = esc_attr($id);
$VALUE_width       = esc_attr($width);
$VALUE_width_auto  = esc_attr($width_auto);
$VALUE_height      = esc_attr($height);
$VALUE_height_auto = esc_attr($height_auto);

?>
<!-- WIDGETS (Tabella per contenere il FORM del widget) -->

<table style="width:100%">

<!-- WIDGETS (Campo con inserimento del titolo widget) -->

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_title ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_title ?>" name="<?php echo $NAME_title ?>" type="text" value="<?php echo $VALUE_title ?>" placeholder="<?php echo __('insert title for widget','szgoogleadmin') ?>"/></td>
</tr>

<!-- WIDGETS (Campo per inserimento URL specifico) -->

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_id ?>"><?php echo ucfirst(__('playlist ID','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_id ?>" name="<?php echo $NAME_id ?>" type="text" value="<?php echo $VALUE_id ?>" placeholder="<?php echo __('insert playlist ID','szgoogleadmin') ?>"/></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per specificare il parametro width & height) -->

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_width ?>"><?php echo ucfirst(__('width','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input id="<?php echo $ID_width ?>" class="sz-google-checks-width" name="<?php echo $NAME_width ?>" type="number" step="1" min="0"  value="<?php echo $VALUE_width ?>"/></td>
	<td colspan="1" class="sz-cell-vals"><input id="<?php echo $ID_width_auto ?>" class="sz-google-checks-hidden checkbox" data-switch="sz-google-checks-width" onchange="szgoogle_checks_hidden(this);" name="<?php echo $NAME_width_auto ?>" type="checkbox" value="1" <?php echo checked($VALUE_width_auto) ?>>&nbsp;<?php echo ucfirst(__('auto','szgoogleadmin')) ?></td>
</tr>


<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_height ?>"><?php echo ucfirst(__('height','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input id="<?php echo $ID_height ?>" class="sz-google-checks-height" name="<?php echo $NAME_height ?>" type="number" step="1" min="0" value="<?php echo $VALUE_height ?>"/></td>
	<td colspan="1" class="sz-cell-vals"><input id="<?php echo $ID_height_auto ?>" class="sz-google-checks-hidden checkbox" data-switch="sz-google-checks-height" onchange="szgoogle_checks_hidden(this);" name="<?php echo $NAME_height_auto ?>" type="checkbox" value="1" <?php echo checked($VALUE_height_auto) ?>>&nbsp;<?php echo ucfirst(__('auto','szgoogleadmin')) ?></td>
</tr>

<!-- WIDGETS (Chiusura tabella principale widget form) -->

</table>

<!-- WIDGETS (Codice javascript per funzioni UI) -->

<script type="text/javascript">
	jQuery(document).ready(function(){
		szgoogle_checks_hidden_ready();
	});
</script>
