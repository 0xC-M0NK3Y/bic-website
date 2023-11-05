
FILTER_MENU_BASE = \
'			<div class="filter checkboxes-container">\n' \
'				<div class="filter_title" onclick="toggleValues(\'%sShow\',\'%sFilter\')">\n' \
'					<span class="filter_name">%s</span>\n' \
'					<input type="checkbox" id="%s_check" onchange="removeChecks(\'%s_check\', \'%s[]\')">\n' \
'					<input type="hidden" name="%s_show" value="<?php if(!isset($_GET[\'%s_show\'])){echo \'0\';}else{echo $_GET[\'%s_show\'];}?>" id="%sShow">\n' \
'				</div>\n' \
'				<div class="filters_values" style="display: <?php if(isset($_GET[\'%s_show\'])){echo $DISPLAY_TYPES[intval($_GET[\'%s_show\'],10)];}else{echo \'none;\';} ?>" id="%sFilter">\n' \
'%s\n' \
'				</div>\n' \
'			</div>\n'

FILTER_VALUE_BASE = \
'					<label class="filter_value">\n' \
'						<label class="filter_attribute">\n' \
'							<span class="filter_label">%s</span>\n' \
'							<input type="checkbox" name="%s[]" value="%s" onchange="submitReq()" <?php if(isset($_GET[\'%s\'])&&in_array(\'%s\',$_GET[\'%s\'])){echo \'checked="checked"\';} ?>>\n' \
'						</label>\n' \
'					</label>\n'
