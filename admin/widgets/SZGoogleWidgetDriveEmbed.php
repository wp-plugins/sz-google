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
$id                = trim($instance['id']);
$title             = trim(strip_tags($instance['title']));
$type              = trim(strip_tags($instance['type']));
$folderview        = trim(strip_tags($instance['folderview']));
$single            = trim(strip_tags($instance['single']));
$gid               = trim(strip_tags($instance['gid']));
$range             = trim(strip_tags($instance['range']));
$start             = trim(strip_tags($instance['start']));
$loop              = trim(strip_tags($instance['loop']));
$delay             = trim(strip_tags($instance['delay']));
$width             = trim(strip_tags($instance['width']));
$width_auto        = trim(strip_tags($instance['width_auto']));
$height            = trim(strip_tags($instance['height']));
$height_auto       = trim(strip_tags($instance['height_auto']));

/**
 * Creazione HTML CSS (id) per tutte le variabili 
 * elencate sopra e presenti nelle opzioni del widget.
 */
$ID_id             = $this->get_field_id('id');
$ID_title          = $this->get_field_id('title');
$ID_type           = $this->get_field_id('type');
$ID_folderview     = $this->get_field_id('folderview');
$ID_single         = $this->get_field_id('single');
$ID_gid            = $this->get_field_id('gid');
$ID_range          = $this->get_field_id('range');
$ID_start          = $this->get_field_id('start');
$ID_loop           = $this->get_field_id('loop');
$ID_delay          = $this->get_field_id('delay');
$ID_width          = $this->get_field_id('width');
$ID_width_auto     = $this->get_field_id('width_auto');
$ID_height         = $this->get_field_id('height');
$ID_height_auto    = $this->get_field_id('height_auto');

/**
 * Creazione HTML CSS (name) per tutte le variabili 
 * elencate sopra e presenti nelle opzioni del widget.
 */
$NAME_id           = $this->get_field_name('id');
$NAME_title        = $this->get_field_name('title');
$NAME_type         = $this->get_field_name('type');
$NAME_folderview   = $this->get_field_name('folderview');
$NAME_single       = $this->get_field_name('single');
$NAME_gid          = $this->get_field_name('gid');
$NAME_range        = $this->get_field_name('range');
$NAME_start        = $this->get_field_name('start');
$NAME_loop         = $this->get_field_name('loop');
$NAME_delay        = $this->get_field_name('delay');
$NAME_width        = $this->get_field_name('width');
$NAME_width_auto   = $this->get_field_name('width_auto');
$NAME_height       = $this->get_field_name('height');
$NAME_height_auto  = $this->get_field_name('height_auto');

/**
 * Creazione HTML CSS (value) per tutte le variabili 
 * elencate sopra e presenti nelle opzioni del widget.
 */
$VALUE_id          = esc_attr($id);
$VALUE_title       = esc_attr($title);
$VALUE_type        = esc_attr($type);
$VALUE_folderview  = esc_attr($folderview);
$VALUE_single      = esc_attr($single);
$VALUE_gid         = esc_attr($gid);
$VALUE_range       = esc_attr($range);
$VALUE_start       = esc_attr($start);
$VALUE_loop        = esc_attr($loop);
$VALUE_delay       = esc_attr($delay);
$VALUE_width       = esc_attr($width);
$VALUE_width_auto  = esc_attr($width_auto);
$VALUE_height      = esc_attr($height);
$VALUE_height_auto = esc_attr($height_auto);

?>
<!-- WIDGETS (Tabella per contenere il FORM del widget) -->
<p><table id="SZGoogleWidgetDriveEmbed" class="sz-google-table-widget">

<!-- WIDGETS (Campo con inserimento del titolo widget) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_title ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_title ?>" name="<?php echo $NAME_title ?>" type="text" value="<?php echo $VALUE_title ?>" placeholder="<?php echo __('insert title for widget','szgoogleadmin') ?>"/></td>
</tr>

<!-- WIDGETS (Campo per inserimento tipo documento) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_type ?>"><?php echo ucfirst(__('type','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select onchange="szgoogle_switch_select_onchange(this);" class="sz-google-row-select widefat" id="<?php echo $ID_type ?>" name="<?php echo $NAME_type ?>">
			<option data-open="1" value="document"     <?php echo selected("document"    ,$VALUE_type) ?>><?php echo __('document'    ,'szgoogleadmin') ?></option>
			<option data-open="2" value="presentation" <?php echo selected("presentation",$VALUE_type) ?>><?php echo __('presentation','szgoogleadmin') ?></option>
			<option data-open="3" value="spreadsheet"  <?php echo selected("spreadsheet" ,$VALUE_type) ?>><?php echo __('spreadsheet' ,'szgoogleadmin') ?></option>
			<option data-open="4" value="forms"        <?php echo selected("forms"       ,$VALUE_type) ?>><?php echo __('forms'       ,'szgoogleadmin') ?></option>
			<option data-open="5" value="pdf"          <?php echo selected("pdf"         ,$VALUE_type) ?>><?php echo __('pdf'         ,'szgoogleadmin') ?></option>
			<option data-open="6" value="video"        <?php echo selected("video"       ,$VALUE_type) ?>><?php echo __('video'       ,'szgoogleadmin') ?></option>
			<option data-open="7" value="folder"       <?php echo selected("folder"      ,$VALUE_type) ?>><?php echo __('folder'      ,'szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Campo per inserimento ID specifico) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_id ?>"><?php echo ucfirst(__('ID','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_id ?>" name="<?php echo $NAME_id ?>" type="text" value="<?php echo $VALUE_id ?>" placeholder="<?php echo __('insert document ID','szgoogleadmin') ?>"/></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per specificare la dimensione) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_width ?>"><?php echo ucfirst(__('width','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input  id="<?php echo $ID_width ?>" class="sz-google-checks-width" name="<?php echo $NAME_width ?>" type="number" size="5" step="1" min="180" max="450" value="<?php echo $VALUE_width ?>"/></td>
	<td colspan="1" class="sz-cell-vals"><input  id="<?php echo $ID_width_auto ?>" class="sz-google-checks-hidden checkbox" data-switch="sz-google-checks-width" onchange="szgoogle_checks_hidden_onchange(this);" name="<?php echo $NAME_width_auto ?>" type="checkbox" value="1" <?php echo checked($VALUE_width_auto) ?>>&nbsp;<?php echo ucfirst(__('auto','szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_height ?>"><?php echo ucfirst(__('height','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input  id="<?php echo $ID_height ?>" class="sz-google-checks-height" name="<?php echo $NAME_height ?>" type="number" size="5" step="1" min="180" max="450" value="<?php echo $VALUE_height ?>"/></td>
	<td colspan="1" class="sz-cell-vals"><input  id="<?php echo $ID_height_auto ?>" class="sz-google-checks-hidden checkbox" data-switch="sz-google-checks-height" onchange="szgoogle_checks_hidden_onchange(this);" name="<?php echo $NAME_height_auto ?>" type="checkbox" value="1" <?php echo checked($VALUE_height_auto) ?>>&nbsp;<?php echo ucfirst(__('auto','szgoogleadmin')) ?></td>
</tr>

<!-- WIDGETS (Campo per specificare i valori di presentazione) -->

<tr class="sz-google-row-tab sz-google-row-tab-2"><td colspan="3"><hr></td></tr>

<tr class="sz-google-row-tab sz-google-row-tab-2">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_start ?>"><?php echo ucfirst(__('start','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_start ?>" value="true"  <?php if ($VALUE_start == 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('enabled','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_start ?>" value="false" <?php if ($VALUE_start != 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('disabled','szgoogleadmin')) ?></td>
</tr>

<tr class="sz-google-row-tab sz-google-row-tab-2">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_loop ?>"><?php echo ucfirst(__('loop','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_loop ?>" value="true"  <?php if ($VALUE_loop == 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('enabled','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_loop ?>" value="false" <?php if ($VALUE_loop != 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('disabled','szgoogleadmin')) ?></td>
</tr>

<tr class="sz-google-row-tab sz-google-row-tab-2"><td colspan="3"><hr></td></tr>

<tr class="sz-google-row-tab sz-google-row-tab-2">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_delay ?>"><?php echo ucfirst(__('delay sec','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_delay ?>" name="<?php echo $NAME_delay ?>">
			<option value="1"  <?php echo selected("1" ,$VALUE_delay) ?>>01</option>
			<option value="2"  <?php echo selected("2" ,$VALUE_delay) ?>>02</option>
			<option value="3"  <?php echo selected("3" ,$VALUE_delay) ?>>03</option>
			<option value="4"  <?php echo selected("4" ,$VALUE_delay) ?>>04</option>
			<option value="5"  <?php echo selected("5" ,$VALUE_delay) ?>>05</option>
			<option value="10" <?php echo selected("10",$VALUE_delay) ?>>10</option>
			<option value="15" <?php echo selected("15",$VALUE_delay) ?>>15</option>
			<option value="30" <?php echo selected("30",$VALUE_delay) ?>>30</option>
			<option value="60" <?php echo selected("60",$VALUE_delay) ?>>60</option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Campo per specificare i valori di spreadsheet) -->

<tr class="sz-google-row-tab sz-google-row-tab-3"><td colspan="3"><hr></td></tr>

<tr class="sz-google-row-tab sz-google-row-tab-3">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_single ?>"><?php echo ucfirst(__('single','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_single ?>" value="true"  <?php if ($VALUE_single == 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('enabled','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_single ?>" value="false" <?php if ($VALUE_single != 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('disabled','szgoogleadmin')) ?></td>
</tr>

<tr class="sz-google-row-tab sz-google-row-tab-3"><td colspan="3"><hr></td></tr>

<tr class="sz-google-row-tab sz-google-row-tab-3">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_gid ?>"><?php echo ucfirst(__('sheet','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_gid ?>" name="<?php echo $NAME_gid ?>">
			<option value="1" <?php echo selected("1",$VALUE_gid) ?>>01</option>
			<option value="2" <?php echo selected("2",$VALUE_gid) ?>>02</option>
			<option value="3" <?php echo selected("3",$VALUE_gid) ?>>03</option>
			<option value="4" <?php echo selected("4",$VALUE_gid) ?>>04</option>
			<option value="5" <?php echo selected("5",$VALUE_gid) ?>>05</option>
			<option value="6" <?php echo selected("6",$VALUE_gid) ?>>06</option>
			<option value="7" <?php echo selected("7",$VALUE_gid) ?>>07</option>
			<option value="8" <?php echo selected("8",$VALUE_gid) ?>>08</option>
			<option value="9" <?php echo selected("9",$VALUE_gid) ?>>09</option>
		</select>
	</td>
</tr>

<tr class="sz-google-row-tab sz-google-row-tab-3">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_range ?>"><?php echo ucfirst(__('range','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_range ?>" name="<?php echo $NAME_range ?>" type="text" value="<?php echo $VALUE_range ?>" placeholder="<?php echo __('range of cells','szgoogleadmin') ?>"/></td>
</tr>

<!-- WIDGETS (Campo per specificare il folder view) -->

<tr class="sz-google-row-tab sz-google-row-tab-7"><td colspan="3"><hr></td></tr>

<tr class="sz-google-row-tab sz-google-row-tab-7">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_folderview ?>"><?php echo ucfirst(__('folder view','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_folderview ?>" name="<?php echo $NAME_folderview ?>">
			<option value="list" <?php echo selected("list",$VALUE_folderview) ?>><?php echo __('list','szgoogleadmin') ?></option>
			<option value="grid" <?php echo selected("grid",$VALUE_folderview) ?>><?php echo __('grid','szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Chiusura tabella principale widget form) -->
</table></p>

<!-- WIDGETS (Codice javascript per funzioni UI) -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		szgoogle_checks_hidden_onload('SZGoogleWidgetDriveEmbed');
		szgoogle_switch_hidden_onload('SZGoogleWidgetDriveEmbed');
		szgoogle_switch_select_onload('SZGoogleWidgetDriveEmbed');
	});
</script>