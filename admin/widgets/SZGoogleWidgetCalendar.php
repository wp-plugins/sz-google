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
$title         = trim($instance['title']);
$calendars     = trim($instance['calendars']);
$calendarT     = trim($instance['calendarT']);

$mode          = trim(strip_tags($instance['mode']));
$weekstart     = trim(strip_tags($instance['weekstart']));
$language      = trim(strip_tags($instance['language']));
$timezone      = trim(strip_tags($instance['timezone']));
$width         = trim(strip_tags($instance['width']));
$height        = trim(strip_tags($instance['height']));
$showtitle     = trim(strip_tags($instance['showtitle']));
$shownavs      = trim(strip_tags($instance['shownavs']));
$showdate      = trim(strip_tags($instance['showdate']));
$shownavs      = trim(strip_tags($instance['shownavs']));
$showprint     = trim(strip_tags($instance['showprint']));
$showcalendars = trim(strip_tags($instance['showcalendars']));
$showtimezone  = trim(strip_tags($instance['showtimezone']));
$width_auto    = trim(strip_tags($instance['width_auto']));
$height_auto   = trim(strip_tags($instance['height_auto']));

/**
 * Creazione HTML CSS (id) per tutte le variabili 
 * elencate sopra e presenti nelle opzioni del widget.
 */
$ID_title         = $this->get_field_id('title');
$ID_calendars     = $this->get_field_id('calendars');
$ID_calendarT     = $this->get_field_id('calendarT');
$ID_mode          = $this->get_field_id('mode');
$ID_weekstart     = $this->get_field_id('weekstart');
$ID_language      = $this->get_field_id('language');
$ID_timezone      = $this->get_field_id('timezone');
$ID_width         = $this->get_field_id('width');
$ID_height        = $this->get_field_id('height');
$ID_showtitle     = $this->get_field_id('showtitle');
$ID_shownavs      = $this->get_field_id('shownavs');
$ID_showdate      = $this->get_field_id('showdate');
$ID_shownavs      = $this->get_field_id('shownavs');
$ID_showprint     = $this->get_field_id('showprint');
$ID_showcalendars = $this->get_field_id('showcalendars');
$ID_showtimezone  = $this->get_field_id('showtimezone');
$ID_width_auto    = $this->get_field_id('width_auto');
$ID_height_auto   = $this->get_field_id('height_auto');

/**
 * Creazione HTML CSS (name) per tutte le variabili 
 * elencate sopra e presenti nelle opzioni del widget.
 */
$NAME_title         = $this->get_field_name('title');
$NAME_calendars     = $this->get_field_name('calendars');
$NAME_calendarT     = $this->get_field_name('calendarT');
$NAME_mode          = $this->get_field_name('mode');
$NAME_weekstart     = $this->get_field_name('weekstart');
$NAME_language      = $this->get_field_name('language');
$NAME_timezone      = $this->get_field_name('timezone');
$NAME_width         = $this->get_field_name('width');
$NAME_height        = $this->get_field_name('height');
$NAME_showtitle     = $this->get_field_name('showtitle');
$NAME_shownavs      = $this->get_field_name('shownavs');
$NAME_showdate      = $this->get_field_name('showdate');
$NAME_shownavs      = $this->get_field_name('shownavs');
$NAME_showprint     = $this->get_field_name('showprint');
$NAME_showcalendars = $this->get_field_name('showcalendars');
$NAME_showtimezone  = $this->get_field_name('showtimezone');
$NAME_width_auto    = $this->get_field_name('width_auto');
$NAME_height_auto   = $this->get_field_name('height_auto');

/**
 * Creazione HTML CSS (value) per tutte le variabili 
 * elencate sopra e presenti nelle opzioni del widget.
 */
$VALUE_title         = esc_attr($title);
$VALUE_calendars     = esc_attr($calendars);
$VALUE_calendarT     = esc_attr($calendarT);
$VALUE_mode          = esc_attr($mode);
$VALUE_weekstart     = esc_attr($weekstart);
$VALUE_language      = esc_attr($language);
$VALUE_timezone      = esc_attr($timezone);
$VALUE_width         = esc_attr($width);
$VALUE_height        = esc_attr($height);
$VALUE_showtitle     = esc_attr($showtitle);
$VALUE_shownavs      = esc_attr($shownavs);
$VALUE_showdate      = esc_attr($showdate);
$VALUE_shownavs      = esc_attr($shownavs);
$VALUE_showprint     = esc_attr($showprint);
$VALUE_showcalendars = esc_attr($showcalendars);
$VALUE_showtimezone  = esc_attr($showtimezone);
$VALUE_width_auto    = esc_attr($width_auto);
$VALUE_height_auto   = esc_attr($height_auto);

?>
<!-- WIDGETS (Tabella per contenere il FORM del widget) -->
<p><table id="SZGoogleWidgetCalendar" class="sz-google-table-widget">

<!-- WIDGETS (Campo con inserimento del titolo widget) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_title ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_title ?>" name="<?php echo $NAME_title ?>" type="text" value="<?php echo $VALUE_title ?>" placeholder="<?php echo __('widget title','szgoogleadmin') ?>"/></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_calendars ?>"><?php echo ucfirst(__('calendars','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_calendars ?>" name="<?php echo $NAME_calendars ?>" type="text" value="<?php echo $VALUE_calendars ?>" placeholder="<?php echo __('configuration','szgoogleadmin') ?>"/></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_calendarT ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_calendarT ?>" name="<?php echo $NAME_calendarT ?>" type="text" value="<?php echo $VALUE_calendarT ?>" placeholder="<?php echo __('configuration','szgoogleadmin') ?>"/></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per specificare la dimensione) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_width ?>"><?php echo ucfirst(__('width','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input  id="<?php echo $ID_width ?>" class="sz-google-checks-width" name="<?php echo $NAME_width ?>" type="number" size="5" step="1" min="100" max="900" value="<?php echo $VALUE_width ?>"/></td>
	<td colspan="1" class="sz-cell-vals"><input  id="<?php echo $ID_width_auto ?>" class="sz-google-checks-hidden checkbox" data-switch="sz-google-checks-width" onchange="szgoogle_checks_hidden_onchange(this);" name="<?php echo $NAME_width_auto ?>" type="checkbox" value="1" <?php echo checked($VALUE_width_auto) ?>>&nbsp;<?php echo ucfirst(__('auto','szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_height ?>"><?php echo ucfirst(__('height','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input  id="<?php echo $ID_height ?>" class="sz-google-checks-height" name="<?php echo $NAME_height ?>" type="number" size="5" step="1" min="100" max="900" value="<?php echo $VALUE_height ?>"/></td>
	<td colspan="1" class="sz-cell-vals"><input  id="<?php echo $ID_height_auto ?>" class="sz-google-checks-hidden checkbox" data-switch="sz-google-checks-height" onchange="szgoogle_checks_hidden_onchange(this);" name="<?php echo $NAME_height_auto ?>" type="checkbox" value="1" <?php echo checked($VALUE_height_auto) ?>>&nbsp;<?php echo ucfirst(__('auto','szgoogleadmin')) ?></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo con inserimento dei valori SHOW) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_showtitle ?>"><?php echo ucfirst(__('show title','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_showtitle ?>" value="y" <?php if ($VALUE_showtitle == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_showtitle ?>" value="n" <?php if ($VALUE_showtitle != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_showdate ?>"><?php echo ucfirst(__('show date','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_showdate ?>" value="y" <?php if ($VALUE_showdate == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_showdate ?>" value="n" <?php if ($VALUE_showdate != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_shownavs ?>"><?php echo ucfirst(__('show navigation','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_shownavs ?>" value="y" <?php if ($VALUE_shownavs == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_shownavs ?>" value="n" <?php if ($VALUE_shownavs != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_showprint ?>"><?php echo ucfirst(__('show print','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_showprint ?>" value="y" <?php if ($VALUE_showprint == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_showprint ?>" value="n" <?php if ($VALUE_showprint != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_showcalendars ?>"><?php echo ucfirst(__('show list','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_showcalendars ?>" value="y" <?php if ($VALUE_showcalendars == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_showcalendars ?>" value="n" <?php if ($VALUE_showcalendars != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_showtimezone ?>"><?php echo ucfirst(__('show time zone','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_showtimezone ?>" value="y" <?php if ($VALUE_showtimezone == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_showtimezone ?>" value="n" <?php if ($VALUE_showtimezone != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per inserimento tipologia view) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_mode ?>"><?php echo ucfirst(__('mode','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_mode ?>" name="<?php echo $NAME_mode ?>">
			<option value="MONTH"   <?php echo selected("MONTH" ,$VALUE_mode) ?>><?php echo __('monthly','szgoogleadmin') ?></option>
			<option value="WEEK"    <?php echo selected("WEEK"  ,$VALUE_mode) ?>><?php echo __('weekly' ,'szgoogleadmin') ?></option>
			<option value="AGENDA"  <?php echo selected("AGENDA",$VALUE_mode) ?>><?php echo __('agenda' ,'szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_weekstart ?>"><?php echo ucfirst(__('week start','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_weekstart ?>" name="<?php echo $NAME_weekstart ?>">
			<option value="1" <?php echo selected("1",$VALUE_weekstart) ?>><?php echo __('sunday'  ,'szgoogleadmin') ?></option>
			<option value="2" <?php echo selected("2",$VALUE_weekstart) ?>><?php echo __('monday'  ,'szgoogleadmin') ?></option>
			<option value="7" <?php echo selected("7",$VALUE_weekstart) ?>><?php echo __('saturday','szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_language ?>"><?php echo ucfirst(__('language','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_language ?>" name="<?php echo $NAME_language ?>">
<?php foreach (SZGooglePluginCommon::getLanguages() as $key=>$value): ?>
			<option value="<?php echo $key ?>" <?php echo selected($key,$VALUE_language) ?>><?php echo $value ?></option>
<?php endforeach; ?>
		</select>
	</td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_timezone ?>"><?php echo ucfirst(__('timezone','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_timezone ?>" name="<?php echo $NAME_timezone ?>">
<?php foreach (SZGooglePluginCommon::getTimeZone() as $key=>$value): ?>
			<option value="<?php echo $key ?>" <?php echo selected($key,$VALUE_timezone) ?>><?php echo $value ?></option>
<?php endforeach; ?>
		</select>
	</td>
</tr>

<!-- WIDGETS (Chiusura tabella principale widget form) -->
</table></p>

<!-- WIDGETS (Codice javascript per funzioni UI) -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		szgoogle_switch_hidden_onload('SZGoogleWidgetCalendar');
		szgoogle_checks_hidden_onload('SZGoogleWidgetCalendar');
	});
</script>