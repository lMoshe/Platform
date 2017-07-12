<?php

class Users_Device_Android extends Users_Device
{

	/**
	 * You can use this method to send push notifications.
	 * It is far better, however, to use the Qbix Platform's offline notification
	 * mechanisms using Node.js instead of PHP. That way, you can be sure of re-using
	 * the same persistent connection.
	 * @method pushNotification
	 * @param {array} $notification See Users_Device->pushNotification parameters
	 * @param {array} [$options] See Users_Device->pushNotification parameters
	 */
	function handlePushNotification($notification, $options = array())
	{
		self::$push[] = Users_Device_FCM::prepareForAndroid($notification);
	}

	/**
	 * Sends all scheduled push notifications
	 * @method sendPushNotifications
	 * @static
	 * @throws Users_Exception_DeviceNotification
	 */
	static function sendPushNotifications()
	{
		if (!self::$push) {
			return;
		}
		$apiKey = Q_Config::expect('Users', 'apps', 'android', Q_Config::expect('Q', 'app'), "key");
		foreach (self::$push as $notification) {
			Users_Device_FCM::send($apiKey, self::$deviceId, $notification);
		}
		self::$push = [];
	}

	static protected $push = [];

	static $deviceId = null;

}