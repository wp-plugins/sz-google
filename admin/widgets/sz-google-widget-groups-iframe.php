<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULE') or !SZ_PLUGIN_GOOGLE_MODULE) die();

// Definizione dei nome per le varibili per CSS id

$ID_title             = $this->get_field_id('title');
$ID_name              = $this->get_field_id('name');
$ID_width             = $this->get_field_id('width');
$ID_width_auto        = $this->get_field_id('width_auto');
$ID_height            = $this->get_field_id('height');
$ID_height_auto       = $this->get_field_id('height_auto');
$ID_showsearch        = $this->get_field_id('showsearch');
$ID_showtabs          = $this->get_field_id('showtabs');
$ID_hideforumtitle    = $this->get_field_id('hideforumtitle');
$ID_hidesubject       = $this->get_field_id('hidesubject ');
$ID_hl                = $this->get_field_id('hl');

// Definizione dei nome per le varibili per CSS name

$NAME_title           = $this->get_field_name('title');
$NAME_name            = $this->get_field_name('name');
$NAME_width           = $this->get_field_name('width');
$NAME_width_auto      = $this->get_field_name('width_auto');
$NAME_height          = $this->get_field_name('height');
$NAME_height_auto     = $this->get_field_name('height_auto');
$NAME_showsearch      = $this->get_field_name('showsearch');
$NAME_showtabs        = $this->get_field_name('showtabs');
$NAME_hideforumtitle  = $this->get_field_name('hideforumtitle');
$NAME_hidesubject     = $this->get_field_name('hidesubject ');
$NAME_hl              = $this->get_field_name('hl');

// Definizione dei nome per le varibili contenuto

$VALUE_title          = esc_attr($title);
$VALUE_name           = esc_attr($name);
$VALUE_width          = esc_attr($width);
$VALUE_width_auto     = esc_attr($width_auto);
$VALUE_height         = esc_attr($height);
$VALUE_height_auto    = esc_attr($height_auto);
$VALUE_showsearch     = esc_attr($showsearch);
$VALUE_showtabs       = esc_attr($showtabs);
$VALUE_hideforumtitle = esc_attr($hideforumtitle);
$VALUE_hidesubject    = esc_attr($hidesubject);
$VALUE_hl             = esc_attr($hl);

?>
<!-- WIDGETS (Tabella per contenere il FORM del widget) -->

<table style="width:100%">

<!-- WIDGETS (Campo con inserimento del titolo widget) -->

<tr><td colspan="3">
	<label for="<?php echo $ID_title ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label>
	<input class="widefat" id="<?php echo $ID_title ?>" name="<?php echo $NAME_title ?>" type="text" value="<?php echo $VALUE_title ?>"/>
</td></tr>

<!-- WIDGETS (Campo con inserimento nome del gruppo) -->

<tr><td colspan="3">
	<label for="<?php echo $ID_name ?>"><?php echo ucfirst(__('group name','szgoogleadmin')) ?>:</label>
	<input class="widefat" id="<?php echo $ID_name ?>" name="<?php echo $NAME_name ?>" type="text" value="<?php echo $VALUE_name ?>"/>
</td></tr>

<!-- WIDGETS (Campo per specificare la dimensione) -->

<tr><td colspan="3"><hr></td></tr>

<tr>
	<td><label for="<?php echo $ID_width ?>"><?php echo ucfirst(__('width','szgoogleadmin')) ?>:</label></td>
	<td><input id="<?php echo $ID_width ?>" class="sz-google-checks-width" name="<?php echo $NAME_width ?>" type="number" size="5" step="1" min="180" max="450" value="'.$VALUE_width.'"/></td>
	<td><input id="<?php echo $ID_width_auto ?>" class="sz-google-checks-hidden checkbox" data-switch="sz-google-checks-width" onchange="szgoogle_checks_hidden(this);" name="<?php echo $NAME_width_auto ?>" type="checkbox" value="1" <?php echo checked($VALUE_width_auto) ?>>&nbsp;<?php echo ucfirst(__('auto','szgoogleadmin')) ?></td>
</tr>

<tr>
	<td><label for="<?php echo $ID_height ?>"><?php echo ucfirst(__('height','szgoogleadmin')) ?>:</label></td>
	<td><input id="<?php echo $ID_height ?>" class="sz-google-checks-height" name="<?php echo $NAME_height ?>" type="number" size="5" step="1" min="180" max="450" value="'.$VALUE_height.'"/></td>
	<td><input id="<?php echo $ID_height_auto ?>" class="sz-google-checks-hidden checkbox" data-switch="sz-google-checks-height" onchange="szgoogle_checks_hidden(this);" name="<?php echo $NAME_height_auto ?>" type="checkbox" value="1" <?php echo checked($VALUE_height_auto) ?>>&nbsp;<?php echo ucfirst(__('auto','szgoogleadmin')) ?></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per specificare il parametro showsearch -->

<tr>
	<td><label for="<?php echo $ID_showsearch ?>"><?php echo ucfirst(__('show search','szgoogleadmin')) ?>:</label></td>
	<td><input type="radio" name="<?php echo $NAME_showsearch ?>" value="true"  <?php if ($VALUE_showsearch == 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('enabled','szgoogleadmin')) ?></td>
	<td><input type="radio" name="<?php echo $NAME_showsearch ?>" value="false" <?php if ($VALUE_showsearch != 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('disabled','szgoogleadmin')) ?></td>
</tr>

<!-- WIDGETS (Campo per specificare il parametro showtabs -->

<tr>
	<td><label for="<?php echo $ID_showtabs ?>"><?php echo ucfirst(__('show tabs','szgoogleadmin')) ?>:</label></td>
	<td><input type="radio" name="<?php echo $NAME_showtabs ?>" value="true"  <?php if ($VALUE_showtabs == 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('enabled','szgoogleadmin')) ?></td>
	<td><input type="radio" name="<?php echo $NAME_showtabs ?>" value="false" <?php if ($VALUE_showtabs != 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('disabled','szgoogleadmin')) ?></td>
</tr>

<!-- WIDGETS (Campo per specificare il parametro hideforumtitle -->

<tr>
	<td><label for="<?php echo $ID_hideforumtitle ?>"><?php echo ucfirst(__('hide title','szgoogleadmin')) ?>:</label></td>
	<td><input type="radio" name="<?php echo $NAME_hideforumtitle ?>" value="true"  <?php if ($VALUE_hideforumtitle == 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('enabled','szgoogleadmin')) ?></td>
	<td><input type="radio" name="<?php echo $NAME_hideforumtitle ?>" value="false" <?php if ($VALUE_hideforumtitle != 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('disabled','szgoogleadmin')) ?></td>
</tr>

<!-- WIDGETS (Campo per specificare il parametro hidesubject -->

<tr>
	<td><label for="<?php echo $ID_hidesubject ?>"><?php echo ucfirst(__('hide subject','szgoogleadmin')) ?>:</label></td>
	<td><input type="radio" name="<?php echo $NAME_hidesubject ?>" value="true"  <?php if ($VALUE_hidesubject == 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('enabled','szgoogleadmin')) ?></td>
	<td><input type="radio" name="<?php echo $NAME_hidesubject ?>" value="false" <?php if ($VALUE_hidesubject != 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('disabled','szgoogleadmin')) ?></td>
</tr>

<!-- WIDGETS (Chiusura tabella principale widget form) -->

</table>

<!-- WIDGETS (Codice javascript per funzioni UI) -->

<script type="text/javascript">
	jQuery(document).ready(function(){
		szgoogle_checks_hidden_ready();
	});
</script>
