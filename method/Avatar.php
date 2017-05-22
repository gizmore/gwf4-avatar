<?php
final class Avatar_Avatar extends GWF_Method
{
	private $path;
	
	public function getHTAccess()
	{
		return
			'RewriteRule ^avatar/custom/([^/]+)/([^/]+)/?$ index.php?mo=Avatar&me=Avatar&mode=custom&user=$1&file=$2 [QSA]'.PHP_EOL.
			'RewriteRule ^avatar/default/([^/]+)/?$ index.php?mo=Avatar&me=Avatar&mode=default&file=$1 [QSA]'.PHP_EOL;
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
		$mode = Common::getGetString('mode');
		$file = preg_replace('#[/\\\\]#', '', Common::getGetString('file'));
		
		if ($mode === 'custom')
		{
			$user = preg_replace('/[^a-z0-9]/i', '', Common::getGetString('user'));
			$this->path = sprintf('%sdbimg/avatar/user/%s/%s', GWF_PATH, $user, $file);
		}
		else
		{
			$this->path = sprintf('%sthemes/%s/img/default/default_avatars/%s', GWF_PATH, GWF_DEFAULT_DESIGN, $file);
		}
		
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