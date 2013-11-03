<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULE') or !SZ_PLUGIN_GOOGLE_MODULE) die();

// Definizione dei nome per le variabili CSS id

$ID_title         = $this->get_field_id('title');
$ID_url           = $this->get_field_id('url');
$ID_align         = $this->get_field_id('align');

// Definizione dei nome per le variabili CSS name

$NAME_title       = $this->get_field_name('title');
$NAME_url         = $this->get_field_name('url');
$NAME_align       = $this->get_field_name('align');

// Definizione dei nome per le variabili contenuto

$VALUE_title      = esc_attr($title);
$VALUE_url        = esc_attr($url);
$VALUE_align      = esc_attr($align);

?>
<!-- WIDGETS (Tabella per contenere il FORM del widget) -->

<table style="width:100%">

<!-- WIDGETS (Campo con inserimento del titolo widget) -->

<tr><td colspan="2">
	<label for="<?php echo $ID_title ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label>
	<input class="widefat" id="<?php echo $ID_title ?>" name="<?php echo $NAME_title ?>" type="text" value="<?php echo $VALUE_title ?>"/>
</td></tr>

<!-- WIDGETS (Campo per inserimento URL specifico) -->

<tr><td colspan="2">
	<input class="widefat" id="<?php echo $ID_url ?>" name="<?php echo $NAME_url ?>" type="text" value="<?php echo $VALUE_url ?>" placeholder="<?php echo __('insert google+ post URL','szgoogleadmin') ?>"/>
</td></tr>

<!-- WIDGETS (Campo per specificare il parametro align -->

<tr>
	<td><label for="<?php echo $ID_align ?>"><?php echo ucfirst(__('align','szgoogleadmin')) ?>:</label></td>
	<td><select class="widefat" id="<?php echo $ID_align ?>" name="<?php echo $NAME_align ?>">
		<option value="none"   <?php echo selected("none"  ,$VALUE_align) ?>><?php echo __('none'  ,'szgoogleadmin') ?></option>
		<option value="left"   <?php echo selected("left"  ,$VALUE_align) ?>><?php echo __('left'  ,'szgoogleadmin') ?></option>
		<option value="center" <?php echo selected("center",$VALUE_align) ?>><?php echo __('center','szgoogleadmin') ?></option>
		<option value="right"  <?php echo selected("right" ,$VALUE_align) ?>><?php echo __('right' ,'szgoogleadmin') ?></option>
	</select></td>
</tr>

<!-- WIDGETS (Chiusura tabella principale widget form) -->

</table>

<!-- WIDGETS (Codice javascript per funzioni UI) -->

<script type="text/javascript">
	jQuery(document).ready(function(){
		szgoogle_switch_hidden_ready();
	});
</script>
