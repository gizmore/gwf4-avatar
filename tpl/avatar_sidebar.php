<md-toolbar class="md-theme-indigo"layout-align="right">
<h1 class="md-toolbar-tools"><?php echo $lang->lang('bar_title_avatar'); ?></h1>
	<md-content layout-margin ng-controller="AvatarSidebarCtrl" class="gwf-avatar-bar">

		<div><?php echo $lang->lang('info_your_avatar'); ?></div>
		<?php echo GWF_Avatar::userAvatar($user); ?>

		<section layout="row" flex>
			<md-button href="<?php echo $href_upload; ?>">Upload</md-button>
		</section>
	</md-content>
</md-toolbar>
