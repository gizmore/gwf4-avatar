<md-input-container ng-controller="SelectCtrl">
	<label><?php echo $lang->lang('th_default_avatar'); ?></label>
	<md-select name="<?php echo $key; ?>" ng-model="data.selected">
<?php
foreach (GWF_Avatar::defaultAvatars($user) as $key => $avatar)
{
	list($label, $wwwPath, $filePath, $fileName, $selected) = $avatar;
	$selected = $selected ? ' selected="selected"' : '';
	$avatarImage = GWF_Avatar::defaultAvatar($avatar);
	printf('<md-option value="%s"%s><label>%s</label>%s</md-option>', $fileName, '', $label, $label);
}
?>
	</md-select>
</md-input-container>
