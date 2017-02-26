<gwf-sidebar-item>
	<h2><?php echo $lang->lang('bar_title_avatar'); ?></h2>
	<p><?php echo $lang->lang('info_your_avatar'); ?></p>
	<?php echo GWF_Avatar::userAvatar($user); ?>
	<?php echo GWF_Button::generic($lang->lang('btn_change'), $href_upload); ?>
	</md-content>
</gwf-sidebar-item>
