<?php 
	class encryption
	{
		public static function Encrypt($text)
		{
			$hash = MD5($text);
			return $hash;
		}

		public static function Decrypt($hash)
		{
			$text = 'No Way';
			return $text;
		}
	}
?>