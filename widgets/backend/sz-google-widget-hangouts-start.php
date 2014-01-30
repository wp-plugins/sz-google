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
$ID_type          = $this->get_field_id('type');
$ID_topic         = $this->get_field_id('topic');
$ID_badge         = $this->get_field_id('badge');
$ID_text          = $this->get_field_id('text');
$ID_img           = $this->get_field_id('img');
$ID_position      = $this->get_field_id('position');
$ID_align         = $this->get_field_id('align');
$ID_width         = $this->get_field_id('width');
$ID_width_auto    = $this->get_field_id('width_auto');

/**
 * Creazione HTML CSS (name) per tutte le variabili 
 * elencate sopra e presenti nelle opzioni del widget.
 */
$NAME_title       = $this->get_field_name('title');
$NAME_type        = $this->get_field_name('type');
$NAME_topic       = $this->get_field_name('topic');
$NAME_badge       = $this->get_field_name('badge');
$NAME_text        = $this->get_field_name('text');
$NAME_img         = $this->get_field_name('img');
$NAME_position    = $this->get_field_name('position');
$NAME_align       = $this->get_field_name('align');
$NAME_width       = $this->get_field_name('width');
$NAME_width_auto  = $this->get_field_name('width_auto');

/**
 * Creazione HTML CSS (value) per tutte le variabili 
 * elencate sopra e presenti nelle opzioni del widget.
 */
$VALUE_title      = esc_attr($title);
$VALUE_type       = esc_attr($type);
$VALUE_topic      = esc_attr($topic);
$VALUE_badge      = esc_attr($badge);
$VALUE_text       = esc_attr($text);
$VALUE_img        = esc_attr($img);
$VALUE_position   = esc_attr($position);
$VALUE_align      = esc_attr($align);
$VALUE_width      = esc_attr($width);
$VALUE_width_auto = esc_attr($width_auto);

?>
<!-- WIDGETS (Tabella per contenere il FORM del widget) -->
<p><table class="sz-google-table-widget">

<!-- WIDGETS (Campo con inserimento del titolo widget) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_title ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_title ?>" name="<?php echo $NAME_title ?>" type="text" value="<?php echo $VALUE_title ?>" placeholder="<?php echo __('insert title for widget','szgoogleadmin') ?>"/></td>
</tr>

<!-- WIDGETS (Campo per inserimento tipologia hangouts) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_type ?>"><?php echo ucfirst(__('hangout','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_type ?>" name="<?php echo $NAME_type ?>">
			<option value="normal"    <?php echo selected("normal"    ,$VALUE_type) ?>><?php echo __('normal'   ,'szgoogleadmin') ?></option>
			<option value="onair"     <?php echo selected("onair"     ,$VALUE_type) ?>><?php echo __('onair'    ,'szgoogleadmin') ?></option>
			<option value="party"     <?php echo selected("party"     ,$VALUE_type) ?>><?php echo __('party'    ,'szgoogleadmin') ?></option>
			<option value="moderated" <?php echo selected("moderated" ,$VALUE_type) ?>><?php echo __('moderated','szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Campo per inserimento argomento) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_topic ?>"><?php echo ucfirst(__('topic','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_topic ?>" name="<?php echo $NAME_topic ?>" type="text" value="<?php echo $VALUE_topic ?>"/></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per specificare la dimensione) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_width ?>"><?php echo ucfirst(__('width','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input id="<?php echo $ID_width ?>" class="sz-google-checks-width" name="<?php echo $NAME_width ?>" type="number" size="5" step="1" min="180" max="450" value="<?php echo $VALUE_width ?>"/></td>
	<td colspan="1" class="sz-cell-vals"><input id="<?php echo $ID_width_auto ?>" class="sz-google-checks-hidden checkbox" data-switch="sz-google-checks-width" onchange="szgoogle_checks_hidden(this);" name="<?php echo $NAME_width_auto ?>" type="checkbox" value="1" <?php echo checked($VALUE_width_auto) ?>>&nbsp;<?php echo ucfirst(__('auto','szgoogleadmin')) ?></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per inserimento tipologia di badge) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_badge ?>"><?php echo ucfirst(__('type','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="sz-google-switch-hidden widefat" id="<?php echo $ID_badge ?>" name="<?php echo $NAME_badge ?>" onchange="szgoogle_switch_hidden(this);" data-switch="sz-google-switch-display" data-close="0">
			<option value="0" <?php echo selected("0",$VALUE_badge) ?>><?php echo __('button without badge','szgoogleadmin') ?></option>
			<option value="1" <?php echo selected("1",$VALUE_badge) ?>><?php echo __('button with badge','szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Campo per inserimento del testo da usare come badge) -->
<tr class="sz-google-switch-display">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_text ?>"><?php echo ucfirst(__('text','szgoogleadmin')) ?>:</label></td>
	<td colspan="2"><textarea class="widefat" rows="3" cols="20" id="<?php echo $ID_text ?>" name="<?php echo $NAME_text ?>" placeholder="<?php echo __('insert text for badge','szgoogleadmin') ?>"><?php echo $VALUE_text ?></textarea></td>
</tr>

<!-- WIDGETS (Campo per inserimento immagine da usare come badge) -->
<tr class="sz-google-switch-display">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_img ?>"><?php echo ucfirst(__('image','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input class="sz-upload-image-url-2 widefat" id="<?php echo $ID_img ?>" name="<?php echo $NAME_img ?>" type="text" value="<?php echo $VALUE_img ?>" placeholder="<?php echo __('choose image for badge','szgoogleadmin') ?>"/></td>
	<td colspan="1" class="sz-cell-vals"><input class="sz-upload-image-button button" type="button" value="<?php echo ucfirst(__('select file','szgoogleadmin')) ?>" data-field-url="sz-upload-image-url-2" data-title="<?php echo ucfirst(__('select or upload a file','szgoogleadmin')) ?>" data-button-text="<?php echo ucfirst(__('confirm selection','szgoogleadmin')) ?>"/></td>
</tr>

<!-- WIDGETS (Campo per inserimento della posizione) -->
<tr class="sz-google-switch-display">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_position ?>"><?php echo ucfirst(__('position','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_position ?>" name="<?php echo $NAME_position ?>">
			<option value="outside" <?php echo selected("outside",$VALUE_position) ?>><?php echo __('position outside','szgoogleadmin') ?></option>
			<option value="top"     <?php echo selected("top"    ,$VALUE_position) ?>><?php echo __('position top'    ,'szgoogleadmin') ?></option>
			<option value="center"  <?php echo selected("center" ,$VALUE_position) ?>><?php echo __('position center' ,'szgoogleadmin') ?></option>
			<option value="bottom"  <?php echo selected("bottom" ,$VALUE_position) ?>><?php echo __('position bottom' ,'szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Campo per inserimento allineamento) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_align ?>"><?php echo ucfirst(__('alignment','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_align ?>" name="<?php echo $NAME_align ?>">
			<option value="none"   <?php echo selected("none"  ,$VALUE_align) ?>><?php echo __('alignment none'  ,'szgoogleadmin') ?></option>
			<option value="left"   <?php echo selected("left"  ,$VALUE_align) ?>><?php echo __('alignment left'  ,'szgoogleadmin') ?></option>
			<option value="center" <?php echo selected("center",$VALUE_align) ?>><?php echo __('alignment center','szgoogleadmin') ?></option>
			<option value="right"  <?php echo selected("right" ,$VALUE_align) ?>><?php echo __('alignment right' ,'szgoogleadmin') ?></option>
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
		szgoogle_media_uploader();
	});
</script>