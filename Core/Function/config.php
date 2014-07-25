<?php

	require_once("Config/Lite.php");

	/**
	 * All the config releated functions.
	 * 
	 * This file will include stuff like, set, get configs
	 * 
	 * @category Server
	 * @package ControlPanel
	 * @author Dennis &lt;dennistryy3@gmail.com>
	 * @copyright 2014 Dennis Planting
	 */

	class Config
	{
		/**
		 * Get a setting.
		 * 
		 * @param string $config What config file to grab.
		 * @param string $category What category to look in.
		 * @param string $setting What setting to get.
		 * 
		 * @return The value of the setting.
		 */

		function get($config, $category, $setting)
		{
			$config = "/home/tryy3/Control_Panel/Config/" . $config . ".ini";
			$configFile = new Config_Lite($config);

			if (isset($configFile[$category]))
			{
				$categoryFile = $configFile[$category];

				if (isset($categoryFile[$setting]))
				{
					return $categoryFile[$setting];
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}


		/**
		 * Set a setting to a value.
		 * 
		 * @param string $config What config file to grab.
		 * @param string $category What category to look in.
		 * @param string $setting What setting to set.
		 * @param string $value The value to set the setting to.
		 * 
		 * @return If setting the ettings was successfully or not.
		 */
		
		function set($config, $category, $setting, $value)
		{
		}
	}