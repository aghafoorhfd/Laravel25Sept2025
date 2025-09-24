<?php

	namespace Modules\Core;

	use Modules\Core\Abstracts\BaseSettingsClass;

	class SettingClass extends BaseSettingsClass
	{
		const UPLOAD_DRIVER=['uploads','s3'];
		public static function getSettingPages()
		{
            return [];
		}
	}
