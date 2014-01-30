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
 * Creazione HTML CSS (id) per tutte le variabili 
 * elencate sopra e presenti nelle opzioni del widget.
 */
$ID_title         = $this->get_field_id('title');
$ID_method        = $this->get_field_id('method');
$ID_specific      = $this->get_field_id('specific');
$ID_width         = $this->get_field_id('width');
$ID_width_auto    = $this->get_field_id('width_auto');
$ID_layout        = $this->get_field_id('layout');
$ID_theme         = $this->get_field_id('theme');
$ID_cover         = $this->get_field_id('cover');
$ID_tagline       = $this->get_field_id('tagline');
$ID_publisher     = $this->get_field_id('publisher');
$ID_align         = $this->get_field_id('align');

/**
 * Creazione HTML CSS (name) per tutte le variabili 
 * elencate sopra e presenti nelle opzioni del widget.
 */
$NAME_title       = $this->get_field_name('title');
$NAME_method      = $this->get_field_name('method');
$NAME_specific    = $this->get_field_name('specific');
$NAME_width       = $this->get_field_name('width');
$NAME_width_auto  = $this->get_field_name('width_auto');
$NAME_layout      = $this->get_field_name('layout');
$NAME_theme       = $this->get_field_name('theme');
$NAME_cover       = $this->get_field_name('cover');
$NAME_tagline     = $this->get_field_name('tagline');
$NAME_publisher   = $this->get_field_name('publisher');
$NAME_align       = $this->get_field_name('align');

/**
 * Creazione HTML CSS (value) per tutte le variabili 
 * elencate sopra e presenti nelle opzioni del widget.
 */
$VALUE_title      = esc_attr($title);
$VALUE_method     = esc_attr($method);
$VALUE_specific   = esc_attr($specific);
$VALUE_width      = esc_attr($width);
$VALUE_width_auto = esc_attr($width_auto);
$VALUE_layout     = esc_attr($layout);
$VALUE_theme      = esc_attr($theme);
$VALUE_cover      = esc_attr($cover);
$VALUE_tagline    = esc_attr($tagline);
$VALUE_publisher  = esc_attr($publisher);
$VALUE_align      = esc_attr($align);

?>
<!-- WIDGETS (Tabella per contenere il FORM del widget) -->
<p><table class="sz-google-table-widget">

<!-- WIDGETS (Campo con inserimento del titolo widget) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_title ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_title ?>" name="<?php echo $NAME_title ?>" type="text" value="<?php echo $VALUE_title ?>" placeholder="<?php echo __('insert title for widget','szgoogleadmin') ?>"/></td>
</td></tr>

<!-- WIDGETS (Campo per selezione ID di configurazione o specifico) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_method ?>"><?php echo ucfirst(__('page ID','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="sz-google-switch-hidden widefat" data-switch="sz-google-switch-specific" data-close="1" onchange="szgoogle_switch_hidden(this);" id="<?php echo $ID_method ?>" name="<?php echo $NAME_method ?>">
			<option value="1" <?php selected("1",$VALUE_method) ?>><?php echo ucfirst(__('configuration ID','szgoogleadmin')) ?></option>
			<option value="2" <?php selected("2",$VALUE_method) ?>><?php echo ucfirst(__('specific ID','szgoogleadmin')) ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Campo per inserimento di uno specifico ID) -->
<tr class="sz-google-switch-specific">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_specific ?>"><?php echo ucfirst(__('page ID','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_specific ?>" name="<?php echo $NAME_specific ?>" type="text" value="<?php echo $VALUE_specific ?>" placeholder="<?php echo __('insert specific ID','szgoogleadmin') ?>"/></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per specificare la dimensione) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_width ?>"><?php echo ucfirst(__('width','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input id="<?php echo $ID_width ?>" class="sz-google-checks-width" name="<?php echo $NAME_width ?>" type="number" size="5" step="1" min="180" max="450" value="<?php echo $VALUE_width ?>"/></td>
	<td colspan="1" class="sz-cell-vals"><input id="<?php echo $ID_width_auto ?>" class="sz-google-checks-hidden checkbox" data-switch="sz-google-checks-width" onchange="szgoogle_checks_hidden(this);" name="<?php echo $NAME_width_auto ?>" type="checkbox" value="1" <?php echo checked($VALUE_width_auto) ?>>&nbsp;<?php echo ucfirst(__('auto','szgoogleadmin')) ?></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per specificare il parametro layout -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_layout ?>"><?php echo ucfirst(__('layout','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_layout ?>" value="portrait"  <?php if ($VALUE_layout == 'portrait') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('portrait','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_layout ?>" value="landscape" <?php if ($VALUE_layout != 'portrait') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('landscape','szgoogleadmin')) ?></td>
</tr>

<!-- WIDGETS (Campo per specificare il parametro theme -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_theme ?>"><?php echo ucfirst(__('theme','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_theme ?>" value="light" <?php if ($VALUE_theme == 'light') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('light','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_theme ?>" value="dark"  <?php if ($VALUE_theme != 'light') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('dark','szgoogleadmin')) ?></td>
</tr>

<!-- WIDGETS (Campo per specificare il parametro cover -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_cover ?>"><?php echo ucfirst(__('cover','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_cover ?>" value="true"  <?php if ($VALUE_cover == 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('enabled','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_cover ?>" value="false" <?php if ($VALUE_cover != 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('disabled','szgoogleadmin')) ?></td>
</tr>

<!-- WIDGETS (Campo per specificare il parametro tagline -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_tagline ?>"><?php echo ucfirst(__('tagline','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_tagline ?>" value="true"  <?php if ($VALUE_tagline == 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('enabled','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_tagline ?>" value="false" <?php if ($VALUE_tagline != 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('disabled','szgoogleadmin')) ?></td>
</tr>

<!-- WIDGETS (Campo per specificare il parametro publisher -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_publisher ?>"><?php echo ucfirst(__('publisher','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_publisher ?>" value="true"  <?php if ($VALUE_publisher == 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('enabled','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_publisher ?>" value="false" <?php if ($VALUE_publisher != 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('disabled','szgoogleadmin')) ?></td>
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