<?PHP

require("inc.proveHuman.class.php");

$validationSettings = array(
							"caseSensitive" => TRUE,			// Force User Input to be case sensitive
							"timeSensitive" => TRUE, 			// Verify that a period of time has passed between generation & submission
							"timeRequired" => 1, 				// Time in Seconds that must have passed between image generated and form submission

							"stringMinLength" => 6,				// Minimum Length of String
							"stringMaxLength" => 8,				// Maximum Length of String
							"includeNumeric" => TRUE,			// Include Numbers in String
							"includeAlpha" => TRUE,				// Include Letters in String
							"includeSpecial" => TRUE,			// Include Special Characters in String
							"specialCharacters" => "!@#%&*",	// String of possible Special Characters

							);

$displaySettings = array(
							"imageWidth" => 240, // Width in Pixels
							"imageHeight" => 50,
							"borderWidth" => 2,
							"borderHeight" => 2,
							"borderColor" => array(0,0,0),
							"backgroundColor" => array(255,255,255),
							"fontFile" => "ttf/times.ttf",
							"fontColor" => array(233,14,91),
							"fontShadow" => array(0,0,0),
							"fontSize" => "25",



	);

$proveHuman = new proveHuman();


$proveHuman->generateImage($validationSettings,$displaySettings);

?>