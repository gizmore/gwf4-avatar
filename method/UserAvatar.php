<?php
final class Avatar_UserAvatar extends GWF_Method
{
	private $path;
	
	public function getHTAccess()
	{
		return
			'RewriteRule ^avatar/user/([^/]+)/?$ index.php?mo=Avatar&me=UserAvatar&uid=$1 [QSA]'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== ($error = $this->validate())) {
			return $error;
		}
		return $this->serveAvatar();
	}
	
	private function validate()
	{
		if (!($user = GWF_User::getByID(Common::getRequestInt('uid'))))
		{
			return GWF_HTML::err('ERR_USER');
		}
		if (!($avatar = GWF_Avatar::avatarForUser($user)))
		{
			return $this->module->error('err_avatar');
		}
		
		$this->path = GWF_Avatar::filePathForUser($user);
		
		if (!GWF_File::isFile($this->path))
		{
			GWF_HTTPHeader::statuscode(404);
			die($this->module->lang('err_avatar_not_found').':'.$this->path);
		}
		return false;
	}
	
	private function serveAvatar()
	{
		$this->setImageHeaders();
		die(file_get_contents($this->path));
	}
	
	private function setImageHeaders()
	{
		header('Content-Type: '.mime_content_type($this->path));
	}
	
}