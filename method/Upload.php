<?php
final class Avatar_Upload extends GWF_Method
{
	public function isLoginRequired()
	{
		return !$this->module->cfgGuestAvatars();
	}
	
	public function execute()
	{
		$this->form()->onFlowUpload();

		if (isset($_POST['upload']))
		{
			return $this->onUpload();
		}
		
		return $this->templateUpload();
	}
	
	private function onUpload()
	{
		$form = $this->form();
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error.$this->templateUpload();
		}
		
		if (!GWF_Avatar::saveFlowAvatar(GWF_User::getStaticOrGuest(), $form->getVar('custom_avatar'), $form->getVar('default_avatar')))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$form->cleanup();
		return $this->module->message('msg_uploaded');
	}
	
	private function form()
	{
		$data = array();
		$data['custom_avatar'] = array(GWF_Form::FILE_IMAGE, '', $this->module->lang('th_avatar'));
		$data['default_avatar'] = array(GWF_Form::SELECT, $this->module->template('default_avatars.php'));
		$data['only_one_kind'] = array(GWF_Form::VALIDATOR);
		$data['upload'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_upload'));
		return new GWF_Form($this, $data);
	}
	
	private function templateUpload()
	{
		$tVars = array(
			'form' => $this->form()->templateY($this->module->lang('ft_upload_avatar')),
		);
		return $this->module->template('upload_avatar.php', $tVars);
	}
	
	public function validate_custom_avatar(Module_Avatar $m, $arg)
	{
		return GWF_Avatar::validateCustomAvatar($arg, $m->cfgAvatarMaxSize(), explode(',', $m->cfgImageFormats()));
	}
	
	public function validate_default_avatar(Module_Avatar $m, $arg)
	{
		return GWF_Avatar::validateDefaultAvatar($arg);
	}

	public function validate_only_one_kind(Module_Avatar $m, $arg)
	{
		$form = $this->form();
		$has_custom = $form->getVar('custom_avatar') !== null;
		$has_default = $form->getVar('default_avatar') !== '';
		if ($has_custom !== $has_default)
		{
			return false; # all fine
		}
		else if ($has_custom)
		{
			return $this->module->lang('err_avatar_only_custom_or_default');
		}
		else
		{
			return $this->module->lang('err_avatar_choose_custom_or_default');
		}
	}
	
}
