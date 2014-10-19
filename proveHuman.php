<?PHP

require("inc.proveHuman.class.php");

$validationSettings = array(
							"caseSensitive" => TRUE,			// Force User Input to be case sensitive
							"timeSensitive" => TRUE, 			// Verify that a period of time has passed between generation & submission
							"timeRequired" => 5, 				// Time in Seconds that must have passed between image generated and form submission
							"stringMinLength" => 6,				// Minimum Length of String
							"stringMaxLength" => 8,				// Maximum Length of String
							"includeNumeric" => TRUE,			// Include Numbers in String
							"includeAlpha" => TRUE,				// Include Letters in String
							"includeSpecial" => TRUE,			// Include Special Characters in String
							"specialCharacters" => "!@#%&*",	// String of possible Special Characters
							);

$displaySettings = array(
							"imageWidth" => 240, 				// Image Width in Pixels
							"imageHeight" => 50,				// Image Height in Pixels
							"borderWidth" => 2,					// Border Width in Pixels
							"borderHeight" => 2,				// Border Height in Pixels
							"borderColor" => array(0,0,0),		// Border Color in RGB
							"backgroundColor" => array(255,255,255),	// Background Color in RGB
							"fontFile" => "ttf/times.ttf",		// True type font
							"fontColor" => array(233,14,91),	// Text Color in RGB
							"fontShadow" => array(0,0,0),		// Text Shadow Color in RGB
							"fontSize" => "25",					// Text Size
							);

$proveHuman = new proveHuman();


$proveHuman->generateImage($validationSettings,$displaySettings);

?>