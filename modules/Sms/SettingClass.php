<?php

	namespace Modules\Sms;

	use Modules\Core\Abstracts\BaseSettingsClass;

	class SettingClass extends BaseSettingsClass
	{
		const SMS_DRIVER = [
			"log", "nexmo", "twilio"
		];

		public static function getSettingPages()
		{
            return [];
		}
	}
