<?PHP

/*
	Alternative to Recaptcha.
	

	Form Inclusion
	 	----------------
		<img src="proveHuman.php">
		<input type="text" name="proveHuman" value="" placeholder="">

 	

 	Verification Sample Code
        ----------------
        $validator = new proveHuman;
        if ( $validator->verifyUserInput($_POST["proveHuman"]) ) {
            //User Input is Valid.
        }

*/


class proveHuman {
	var $settings;
	var $visual;
	var $log;

	function __construct() {
		@session_start();
		$this->log = array();
	}

	function validate($userInput) {
		if ( isset($_SESSION["proveHumanTimeSensitive"]) ) {
			// Check that they didn't submit too quickly.
			if ( time() < $_SESSION["proveHumanTimeSensitive"] ) {
				$this->log[] = "User submission was faster than possible.";
				return false;
			}
		}
		if ( isset($_SESSION["proveHumanCode"]) ) {
			if ( $_SESSION["proveHumanCode"] == $userInput ) {
				return true;
			}else {
				$this->log[] = "Incorrect User Input received.";
			}
		}
		return false;
	}


	function generateCode($validationSettings) {
		$chars = "";

		if ( $validationSettings["includeNumeric"] ) {
			$chars .= "0123456789";
		}

		if ( $validationSettings["includeAlpha"] ) {
			$alpha = "abcdefghijklmnopqrstuvwxyz";

			$chars .= $alpha;

			if ( $validationSettings["caseSensitive"] ) {
				$chars .= strtoupper($alpha);
			}
		}

		if ( $validationSettings["includeSpecial"] ) {
			$chars .= $validationSettings["specialCharacters"];
		}


		$strlen = rand($validationSettings["stringMinLength"], $validationSettings["stringMaxLength"]);

		$output = "";
		for ( $i = 0; $i <= $strlen; $i++ ) {
			$randChar = rand(0, strlen($chars)-1);
			$output .= substr($chars,$randChar,1);
		}

		return $output;
	}

	function generateImage($validationSettings,$displaySettings) {
		
		if ( $im = @imagecreatetruecolor($displaySettings["imageWidth"],$displaySettings["imageHeight"]) ) {
			$white = imagecolorallocate($im, 255, 255, 255);
			$grey = imagecolorallocate($im, 128, 128, 128);
			$black = imagecolorallocate($im, 0, 0, 0);

			$bgRGB = $displaySettings["backgroundColor"];
			$bgColor = imagecolorallocate($im, $bgRGB[0], $bgRGB[1], $bgRGB[2]);

			$borderRGB = $displaySettings["borderColor"];
			$borderColor = imagecolorallocate($im, $borderRGB[0], $borderRGB[1], $borderRGB[2] );

			if ( $displaySettings["borderHeight"] > 0 OR $displaySettings["borderWidth"] > 0 ) {
				$bgFillWidth = $displaySettings["imageWidth"] - ($displaySettings["borderWidth"] * 2);
				$bgFillHeight = $displaySettings["imageHeight"] - ($displaySettings["borderHeight"] * 2);

				imagefilledrectangle($im, 0, 0, $displaySettings["imageWidth"], $displaySettings["imageHeight"], $borderColor);
				imagefilledrectangle($im, 3, 3, $bgFillWidth, $bgFillHeight, $bgColor);
			}else {
				imagefilledrectangle($im, 0, 0, $displaySettings["imageWidth"], $displaySettings["imageHeight"], $bgColor);
			}
			

			$txtRGB = $displaySettings["fontColor"];
			$textColor = imagecolorallocate($im, $txtRGB[0], $txtRGB[1], $txtRGB[2]);

			$shadowRGB = $displaySettings["fontShadow"];
			$shadowColor = imagecolorallocate($im, $shadowRGB[0], $shadowRGB[1], $shadowRGB[2]);
			

			$string = $this->generateCode($validationSettings);
			
			$_SESSION["proveHumanCode"] = $string;
			if ( $validationSettings["timeSensitive"] ) {
				$_SESSION["proveHumanTimeSensitive"] = time() + $validationSettings["timeRequired"];
			}
			
			if ( $displaySettings["fontFile"] ) {
				$textBoxInfo = imagettfbbox ( $displaySettings["fontSize"], 0 , $displaySettings["fontFile"], $string);
				$textWidth = abs($textBoxInfo[4] - $textBoxInfo[0]);
				$textHeight = abs($textBoxInfo[5] - $textBoxInfo[1]);

				$textX = ( $displaySettings["imageWidth"] - $textWidth  ) / 2;
				$textY = ( $displaySettings["imageHeight"] + $textHeight ) / 2;

				if ( $displaySettings["fontShadow"] ) {
					imagettftext($im, $displaySettings["fontSize"], 0, $textX-1, $textY-1, $grey, $displaySettings["fontFile"], $string);
				}
				imagettftext($im, $displaySettings["fontSize"], 0, $textX, $textY, $textColor, $displaySettings["fontFile"], $string);
			}else {
				imagestring($im, 1, 5, 5, $string, $textColor);
			}
			

			header("Content-Type: image/png");
			imagepng($im);
			imagedestroy($im);

		}else{
			die("Unable to generate image.");
		}

		
	}


}

?>