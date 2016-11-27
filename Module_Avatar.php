<?php
final class Module_Avatar extends GWF_Module
{
	public function getVersion() { return 4.00; }
	public function getDefaultPriority() { return 50; }
	public function getDefaultAutoLoad() { return true; }
	public function onLoadLanguage() { GWF_Avatar::loadLanguage(GWF_PATH.'module/Avatar/lang/default_avatars'); return $this->loadLanguage('lang/avatar'); }

	public function onInstall($dropTables)
	{
		return GWF_ModuleLoader::installVars($this, array(
			'avatar_max_size' => array('32768', 'int', '1024', '1000000'),
			'avatar_img_formats' => array('jpg,gif,png', 'text', '0', '255'),
			'avatar_for_guests' => array('1', 'bool'),
		));
	}

	public function cfgAvatarMaxSize() { return $this->getModuleVarInt('avatar_max_size', '32768'); }
	public function cfgImageFormats() { return $this->getModuleVar('avatar_img_formats', 'jpg,gif,png'); }
	public function cfgGuestAvatars() { return $this->getModuleVarBool('avatar_for_guests', '1'); }
	
	public function onStartup()
	{
		$this->addCSS("avatar.css");
		$this->addJavascript('gwf-avatar-sidebar-controller.js');
	}

	######################
	### Avatar Sidebar ###
	######################
	public function sidebarContent($bar)
	{
		if ($bar === 'left')
		{
			return $this->avatarSidebar();
		}
	}

	private function avatarSidebar()
	{
		$this->onLoadLanguage();
		$tVars = array(
			'user' => GWF_User::getStaticOrGuest(),
			'href_upload' => GWF_WEB_ROOT.'index.php?mo=Avatar&amp;me=Upload',
		);
		return $this->template('avatar_sidebar.php', $tVars);
	}

}
