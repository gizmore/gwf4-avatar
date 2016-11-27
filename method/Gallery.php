<?php
final class Avatar_Gallery extends GWF_Method
{
	public function execute()
	{
		return $this->templateGallery();
	}

	private function templateGallery()
	{
		$tVars = array(
		);
		return $this->module->template('gallery.php', $tVars);
	}

}