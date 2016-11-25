<?php
final class GWF_Avatar extends GWF_Method
{
	private $path;
	
	public function getHTAccess()
	{
		return 'RewriteRule ^gavatar/([^/]+)/([^/]+)$ index.php?mo=GWF&me=Avatar&dir=$1&file=$2 [QSA]'.PHP_EOL;
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
		$dir = Common::getGetString('dir');
		if ($dir === 'default')
		{
			$this->path = sprintf('%sthemes/%s/img/default/default_avatars/%s', GWF_PATH, GWF_DEFAULT_DESIGN, Common::getGetString('file'));
		}
		else
		{
			$this->path = sprintf('%sdbimg/gavatar/%s/%s', GWF_PATH, Common::getGetString('dir'), Common::getGetString('file'));
		}
		
		if (!GWF_File::isFile($this->path))
		{
			GWF_HTTPHeader::statuscode(404);
			die($this->module->lang('err_avatar_not_found'));
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
		
	}
	
}