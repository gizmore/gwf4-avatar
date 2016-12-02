function GWF_Avatar(user) {
	
//	user = user || {};
//	user.JSON = user.JSON || {};
//	user.JSON.avatar = user.JSON.avatar || {};

	this.USER = user;
	
//	this.validMode = function(mode) { return GWF_Avatar.MODES.indexOf(mode) >= 0; };

	this.display = function() {
		var gender = this.USER.gender();
		var name = this.USER.displayName();
		var alt = sprintf('Avatar of %s', name);
		var href = this.avatarHREF();
		return sprintf('<gwf-avatar ng-click="openProfile($event, msg.USER)"><%s><img src="%s" alt="%s" /></%1$s></gwf-avatar>', gender, href, alt);
	};
	
	this.avatarHREF = function() {
		var mode = this.USER.JSON.avatar.avatar_mode;
		var file = this.USER.JSON.avatar.avatar_file;
		
//		if (!this.validMode(mode)) {
//			mode = 'none';
//		}
		
		if (mode === 'none') {
			mode = 'default';
			file = 'default.jpeg';
		}
		if (mode === 'custom') {
			var user_id = this.USER.JSON.avatar.avatar_user_id;
			var version = this.USER.JSON.avatar.avatar_version;
			var user_id = this.USER.id();
			return sprintf('%savatar/%s/%s/%s?v=%s', GWF_WEB_ROOT, mode, user_id, file, version);
		}
		else {
			return sprintf('%savatar/%s/%s', GWF_WEB_ROOT, mode, file);
		}
	};
	

}

//GWF_Avatar.MODES = ['none', 'custom', 'default'];