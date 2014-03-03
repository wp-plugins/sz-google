<?php
/**
 * Codice HTML per il form di impostazione collegato 
 * al widget presente nella parte di amministrazione, questo
 * codice è su file separato per escluderlo dal frontend
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Definizione variabili che sono legata alla istanza del 
 * widget richiamato com memorizzazione delle opzioni.
 */
$url        = trim($instance['url']);
$title      = trim(strip_tags($instance['title']));
$method     = trim(strip_tags($instance['method']));
$width      = trim(strip_tags($instance['width']));
$width_auto = trim(strip_tags($instance['width_auto']));
$align      = trim(strip_tags($instance['align']));

/**
 * Creazione HTML CSS (id) per tutte le variabili 
 * elencate sopra e presenti nelle opzioni del widget.
 */
$ID_title         = $this->get_field_id('title');
$ID_method        = $this->get_field_id('method');
$ID_url           = $this->get_field_id('url');
$ID_width         = $this->get_field_id('width');
$ID_width_auto    = $this->get_field_id('width_auto');
$ID_align         = $this->get_field_id('align');

/**
 * Creazione HTML CSS (name) per tutte le variabili 
 * elencate sopra e presenti nelle opzioni del widget.
 */
$NAME_title       = $this->get_field_name('title');
$NAME_method      = $this->get_field_name('method');
$NAME_url         = $this->get_field_name('url');
$NAME_width       = $this->get_field_name('width');
$NAME_width_auto  = $this->get_field_name('width_auto');
$NAME_align       = $this->get_field_name('align');

/**
 * Creazione HTML CSS (value) per tutte le variabili 
 * elencate sopra e presenti nelle opzioni del widget.
 */
$VALUE_title      = esc_attr($title);
$VALUE_method     = esc_attr($method);
$VALUE_url        = esc_attr($url);
$VALUE_width      = esc_attr($width);
$VALUE_width_auto = esc_attr($width_auto);
$VALUE_align      = esc_attr($align);

?>
<!-- WIDGETS (Tabella per contenere il FORM del widget) -->
<p><table class="sz-google-table-widget">

<!-- WIDGETS (Campo con inserimento del titolo widget) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_title ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_title ?>" name="<?php echo $NAME_title ?>" type="text" value="<?php echo $VALUE_title ?>" placeholder="<?php echo __('insert title for widget','szgoogleadmin') ?>"/></td>
</tr>

<!-- WIDGETS (Campo per inserimento tipo di URL) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_method ?>"><?php echo ucfirst(__('URL','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="sz-google-switch-hidden widefat" id="<?php echo $ID_method ?>" name="<?php echo $NAME_method ?>" onchange="szgoogle_switch_hidden(this);" data-close="1" data-switch="sz-google-switch-url">
			<option value="1" <?php echo selected("1",$VALUE_method) ?>><?php echo __('current post address','szgoogleadmin') ?></option>
			<option value="2" <?php echo selected("2",$VALUE_method) ?>><?php echo __('specific url address','szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Campo per inserimento URL specifico) -->
<tr class="sz-google-switch-url">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_url ?>"><?php echo ucfirst(__('URL','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="sz-upload-image-url widefat" id="<?php echo $ID_url ?>" name="<?php echo $NAME_url ?>" type="text" value="<?php echo $VALUE_url ?>" placeholder="<?php echo __('insert source URL','szgoogleadmin') ?>"/></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per specificare la dimensione) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_width ?>"><?php echo ucfirst(__('width','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input id="<?php echo $ID_width ?>" class="sz-google-checks-width" name="<?php echo $NAME_width ?>" type="number" size="5" step="1" min="180" max="450" value="<?php echo $VALUE_width ?>"/></td>
	<td colspan="1" class="sz-cell-vals"><input id="<?php echo $ID_width_auto ?>" class="sz-google-checks-hidden checkbox" data-switch="sz-google-checks-width" onchange="szgoogle_checks_hidden(this);" name="<?php echo $NAME_width_auto ?>" type="checkbox" value="1" <?php echo checked($VALUE_width_auto) ?>>&nbsp;<?php echo ucfirst(__('auto','szgoogleadmin')) ?></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per specificare il parametro align -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_align ?>"><?php echo ucfirst(__('align','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_align ?>" name="<?php echo $NAME_align ?>">
			<option value="none"   <?php echo selected("none"  ,$VALUE_align) ?>><?php echo __('none'  ,'szgoogleadmin') ?></option>
			<option value="left"   <?php echo selected("left"  ,$VALUE_align) ?>><?php echo __('left'  ,'szgoogleadmin') ?></option>
			<option value="center" <?php echo selected("center",$VALUE_align) ?>><?php echo __('center','szgoogleadmin') ?></option>
			<option value="right"  <?php echo selected("right" ,$VALUE_align) ?>><?php echo __('right' ,'szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Chiusura tabella principale widget form) -->
</table></p>

<!-- WIDGETS (Codice javascript per funzioni UI) -->
<script type="text/javascript">
	jQuery(document).ready(function(){
		szgoogle_switch_hidden_ready();
		szgoogle_checks_hidden_ready();
	});
</script>