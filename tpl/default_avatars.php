<md-input-container>
	<label>Default Avatar</label>
	<md-select name="default_avatar" ng-model="data.defaultAvatar">
	<md-option value="default.jpeg">None</md-option>
<?php
foreach (GWF_Avatar::defaultAvatars() as $key => $data)
{
	list($label, $wwwPath, $filePath, $fileName) = $data;
	printf('<md-option value="%s">%s</md-option>', $fileName, $label);
}
?>
	</md-select>
</md-input-container>
