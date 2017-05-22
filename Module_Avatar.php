<?php
/**
 * Custom and default avatars for members and guests.
 * Guest avatars are optional.
 * Default avatars have to be placed into themes folder somewhere.
 * @author gizmore
 * @license MIT
 * @since 4.06
 */
final class Module_Avatar extends GWF_Module
{
	public function getVersion() { return 4.00; }
	public function getDefaultPriority() { return 50; }
	public function getDefaultAutoLoad() { return true; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/avatar'); }

	public function onInstall($dropTables)
	{
		GWF_File::createDir($this->customAvatarDir());
		GWF_HTAccess::protect($this->customAvatarDir());
		return GWF_ModuleLoader::installVars($this, array(
			'avatar_for_guests' => array('1', 'bool'),
			'avatar_max_width' => array('64', 'int', '1', '1024'),
			'avatar_max_height' => array('64', 'int', '1', '1024'),
			'avatar_max_size' => array('32768', 'int', '1024', '1000000'),
		));
	}
	public function customAvatarDir()  { return GWF_PATH.'dbimg/avatar'; }
	
	##############
	### Config ###
	##############
	public function cfgGuestAvatars() { return $this->getModuleVarBool('avatar_for_guests', '1'); }
	public function cfgAvatarMaxWidth() { return $this->getModuleVarInt('avatar_max_width', '64'); }
	public function cfgAvatarMaxHeight() { return $this->getModuleVarInt('avatar_max_height', '64'); }
	public function cfgAvatarMaxSize() { return $this->getModuleVarInt('avatar_max_size', '32768'); }

	###############
	### Startup ###
	###############
	public function onStartup()
	{
		if (!GWF4::isInstall())
		{
			$this->addCSS("avatar.css");
			$this->addJavascript('gwf-avatar.js');
	
			if (Module_GWF::instance()->cfgAngularApp())
			{
				$this->addJavascript('gwf-avatar-sidebar-controller.js');
			}
			GWF_Avatar::loadLanguage(GWF_PATH.'module/Avatar/lang/avatar');
		}
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
			'href_upload' => GWF_WEB_ROOT.'index.php?mo=Avatar&me=Upload',
		);
		return $this->template('avatar_sidebar.php', $tVars);
	}

}
