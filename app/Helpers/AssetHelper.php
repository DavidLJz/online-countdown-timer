<?php

namespace App\Helpers;

/**
 * 
 */
class AssetHelper
{
	static protected $secure;

	function __construct()
	{
		self::$secure = (env('APP_ENV') === 'production');
	}

	static function assets($paths) :void
	{
		if (is_array($paths)) {
			foreach ($paths as $path) {
				echo self::scriptTag(self::asset($path, self::$secure));
			}

			return;
		}

		echo self::scriptTag(self::asset($paths, self::$secure));
	}

	static function asset(string $path) :string
	{
		$fpath = base_path(env('ASSET_URL', 'public') . '/' . $path);

		$mtime = date('dmY-Hi', filemtime($fpath));

		return asset($path, self::$secure) . '?v=' . $mtime;
	}

	static private function scriptTag(string $asset) :string
	{
		return "<script src='{$asset}' defer></script>";
	}
}