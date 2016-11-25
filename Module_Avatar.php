<?php
final class Module_Avatar extends GWF_Module
{
	public function getVersion() { return 4.00; }
	public function getDefaultPriority() { return 50; }
	public function getDefaultAutoLoad() { return false; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/avatar'); }

	public function onInstall($dropTables)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'allow_guest_avatars' => array('1', 'bool'),
		));
	}
	
	# Guest avatars
	public function cfgGuestAvatars() { return $this->getModuleVarBool('allow_guest_avatars', '1'); }

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
		$tVars = array(
				'user' => GWF_User::getStaticOrGuest(),
				'href_upload' => GWF_WEB_ROOT.'index.php?mo=GWF&amp;me=UploadAvatar',
		);
		return $this->template('avatar_sidebar.php', $tVars);
	}

}
