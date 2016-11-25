<?php
final class Avatar_Upload extends GWF_Method
{
	public function isLoginRequired()
	{
		return !$this->module->cfgGuestAvatars();
	}
	
	public function execute()
	{
		if (isset($_POST['upload'])) {
			return $this->onUpload();
		}
		return $this->templateUpload();
	}
	
	private function form()
	{
		$data = array();
		$data['avatar'] = array(GWF_Form::FILE_OPT, '', $this->module->lang('th_avatar'));
		$data['default_avatars'] = $this->module->template('default_avatars.php');
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
	
}