<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULE') or !SZ_PLUGIN_GOOGLE_MODULE) die();

// Definizione dei nome per le varibili per CSS id

$ID_title         = $this->get_field_id('title');
$ID_template      = $this->get_field_id('template');
$ID_width         = $this->get_field_id('width');
$ID_width_auto    = $this->get_field_id('width_auto');
$ID_height        = $this->get_field_id('height');
$ID_user          = $this->get_field_id('user');
$ID_group         = $this->get_field_id('group');
$ID_tag           = $this->get_field_id('tag');

// Definizione dei nome per le varibili per CSS name

$NAME_title       = $this->get_field_name('title');
$NAME_template    = $this->get_field_name('template');
$NAME_width       = $this->get_field_name('width');
$NAME_width_auto  = $this->get_field_name('width_auto');
$NAME_height      = $this->get_field_name('height');
$NAME_user        = $this->get_field_name('user');
$NAME_group       = $this->get_field_name('group');
$NAME_tag         = $this->get_field_name('tag');

// Definizione dei nome per le varibili contenuto

$VALUE_title      = esc_attr($title);
$VALUE_template   = esc_attr($template);
$VALUE_width      = esc_attr($width);
$VALUE_width_auto = esc_attr($width_auto);
$VALUE_height     = esc_attr($height);
$VALUE_user       = esc_attr($user);
$VALUE_group      = esc_attr($group);
$VALUE_tag        = esc_attr($tag);

?>

<!-- WIDGETS (Tabella per contenere il FORM del widget) -->

<table style="width:100%">

<!-- WIDGETS (Campo con inserimento del titolo widget) -->

<tr><td colspan="3">
	<label for="<?php echo $ID_title ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label>
	<input class="widefat" id="<?php echo $ID_title ?>" name="<?php echo $NAME_title ?>" type="text" value="<?php echo $VALUE_title ?>"/>
</td></tr>

<!-- WIDGETS (Campo per selezione ID di configurazione o specifico) -->

<tr><td colspan="3">
	<select class="widefat" id="<?php echo $ID_template ?>" name="<?php echo $NAME_template ?>">
		<option value="photo" <?php selected("photo",$VALUE_template) ?>><?php echo ucfirst(__('template photo','szgoogleadmin')) ?></option>
		<option value="slideshow" <?php selected("slideshow",$VALUE_template) ?>><?php echo ucfirst(__('template slideshow','szgoogleadmin')) ?></option>
		<option value="list" <?php selected("list",$VALUE_template) ?>><?php echo ucfirst(__('template list','szgoogleadmin')) ?></option>
		<option value="photo_list" <?php selected("photo_list",$VALUE_template) ?>><?php echo ucfirst(__('template photo_list','szgoogleadmin')) ?></option>
	</select>
</td></tr>

<!-- WIDGETS (Campo per selezione campi di ricerca fotografie nel widget) -->

<tr><td colspan="3"><hr></td></tr>

<tr>
	<td><label for="<?php echo $ID_user ?>"><?php echo ucfirst(__('user','szgoogleadmin')) ?>:</label></td>
	<td colspan="2"><input class="widefat" id="<?php echo $ID_user ?>" name="<?php echo $NAME_user ?>" type="text" value="<?php echo $VALUE_user ?>" placeholder="<?php echo __('specify search user','szgoogleadmin') ?>"/></td>
</tr>

<tr>
	<td><label for="<?php echo $ID_group ?>"><?php echo ucfirst(__('group','szgoogleadmin')) ?>:</label></td>
	<td colspan="2"><input class="widefat" id="<?php echo $ID_group ?>" name="<?php echo $NAME_group ?>" type="text" value="<?php echo $VALUE_group ?>" placeholder="<?php echo __('specify search group','szgoogleadmin') ?>"/></td>
</tr>

<tr>
	<td><label for="<?php echo $ID_tag ?>"><?php echo ucfirst(__('tag','szgoogleadmin')) ?>:</label></td>
	<td colspan="2"><input class="widefat" id="<?php echo $ID_tag ?>" name="<?php echo $NAME_tag ?>" type="text" value="<?php echo $VALUE_tag ?>" placeholder="<?php echo __('specify search tag','szgoogleadmin') ?>"/></td>
</tr>

<!-- WIDGETS (Campo per specificare la dimensione) -->

<tr><td colspan="3"><hr></td></tr>

<tr>
	<td><label for="<?php echo $ID_width ?>"><?php echo ucfirst(__('width','szgoogleadmin')) ?>:</label></td>
	<td><input id="<?php echo $ID_width ?>" class="sz-google-checks-width" name="<?php echo $NAME_width ?>" type="number" size="5" step="1" min="180" max="450" value="<?php echo $VALUE_width ?>"/></td>
	<td><input id="<?php echo $ID_width_auto ?>" class="sz-google-checks-hidden checkbox" data-switch="sz-google-checks-width" onchange="szgoogle_checks_hidden(this);" name="<?php echo $NAME_width_auto ?>" type="checkbox" value="1" <?php echo checked($VALUE_width_auto) ?>>&nbsp;<?php echo ucfirst(__('auto','szgoogleadmin')) ?></td>
</tr>

<tr>
	<td><label for="<?php echo $ID_height ?>"><?php echo ucfirst(__('height','szgoogleadmin')) ?>:</label></td>
	<td><input id="<?php echo $ID_height ?>" name="<?php echo $NAME_height ?>" type="number" size="5" step="1" min="180" max="450" value="<?php echo $VALUE_height ?>"/></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Chiusura tabella principale widget form) -->

</table>

<!-- WIDGETS (Codice javascript per funzioni UI) -->

<script type="text/javascript">
	jQuery(document).ready(function(){
		szgoogle_switch_hidden_ready();
		szgoogle_checks_hidden_ready();
	});
</script>
