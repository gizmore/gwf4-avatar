<md-input-container ng-controller="SelectCtrl" ng-init="data.selected='<?php echo $selectedValue; ?>'">
	<label><?php echo $lang->lang('th_default_avatar'); ?></label>
	<md-select name="<?php echo $key; ?>" ng-model="data.selected">
<?php
	printf('<md-option value="custom">%s</md-option>', 'Custom');
?>
<?php
foreach (GWF_Avatar::defaultAvatars($user) as $key => $avatar)
{
	list($label, $wwwPath, $filePath, $fileName, $selected) = $avatar;
	$avatarImage = GWF_Avatar::defaultAvatar($avatar);
	printf('<md-option value="%s">%s</md-option>', $fileName, $label);
}
?>
	</md-select>
</md-input-container>
