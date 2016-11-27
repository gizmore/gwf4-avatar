<?php
final class Avatar_UserAvatar extends GWF_Method
{
	private $path;
	
	public function getHTAccess()
	{
		return
			'RewriteRule ^avatar/custom/([^/]+)/([^/]+)/([^/]+)/?$ index.php?mo=Avatar&me=UserAvatar&mode=custom&dir=$1&id=$2&file=$3 [QSA]'.PHP_EOL.
			'RewriteRule ^avatar/default/([^/]+)/?$ index.php?mo=Avatar&me=UserAvatar&mode=default&file=$1 [QSA]'.PHP_EOL;
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
		$file = Common::getGetString('file');
		
		if ($mode === 'custom')
		{
			$dir = Common::getGetString('dir');
			$id = Common::getGetString('id');
			$this->path = sprintf('%sdbimg/avatar/%s/%s/%s', GWF_PATH, $dir, $id, $file);
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