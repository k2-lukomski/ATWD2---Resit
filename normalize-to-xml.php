<?php
/// Starting clock time in seconds
$start_time = microtime(true);

//Each file is run through the function to create xml files

convertToXML("data_188.csv", "data_188.xml");
convertToXML("data_203.csv", "data_203.xml");
convertToXML("data_206.csv", "data_206.xml");
convertToXML("data_209.csv", "data_209.xml");
convertToXML("data_213.csv", "data_213.xml");
convertToXML("data_215.csv", "data_215.xml");
convertToXML("data_228.csv", "data_228.xml");
convertToXML("data_270.csv", "data_270.xml");
convertToXML("data_271.csv", "data_271.xml");
convertToXML("data_375.csv", "data_375.xml");
convertToXML("data_395.csv", "data_395.xml");
convertToXML("data_447.csv", "data_447.xml");
convertToXML("data_459.csv", "data_459.xml");
convertToXML("data_463.csv", "data_463.xml");
convertToXML("data_481.csv", "data_481.xml");
convertToXML("data_500.csv", "data_500.xml");
convertToXML("data_501.csv", "data_501.xml");

//Delete warnings
ob_clean();

// End clock time in seconds
$end_time = microtime(true);

// Calculate script execution time
$execution_time = ($end_time - $start_time);

//Outputs the exacution time of the script
echo " Execution time of script = ".$execution_time." sec";

//Create method
function convertToXML($ogFile, $createdFile) {

	//Open the original file
	$oppenedData  = fopen($ogFile, 'rt');

	//Make new file and set encoding
	$xml  = new DomDocument('1.0',"UTF-8");
	$xml->formatOutput = true;

	//Get the next line
	$row = fgets($oppenedData);

    //Make collumns out of row using explode
	[$siteID,$ts,$nox,$no2,$no,$PM10,$NVPM10,$VPM10,$NVPM2_5,$PM2_5,$VPM2_5,$CO,$O3,$SO2,$loc,$lat,$long] = explode(',', $row);

    //Create array out of row in file
	$row = array($siteID,$ts,$nox,$no2,$no,$PM10,$NVPM10,$VPM10,$NVPM2_5,$PM2_5,$VPM2_5,$CO,$O3,$SO2,$loc,$lat,$long);

	//Mke root component
	$component = $xml->createElement('station');

    //Check is siteID is empty
	if ($row[0] != null){
        $componentCharacteristic = $xml -> createAttribute('id'); //create new atribite of 'id'
        $componentCharacteristic -> value = $row[0]; //set atributes value to the value of the siteID
		$component -> appendChild($componentCharacteristic);
	}

	//Genarating name for station
	if ($row[14] != null){
		$componentCharacteristic = $xml -> createAttribute('name');


		//Check for special characters
		$ruleoutAmpersand = $row[14];
		$update = str_replace('&', '&amp;', $ruleoutAmpersand);
		$obtainCharacter = $update;
		$name = str_replace('"', '', $obtainCharacter);
		$componentCharacteristic -> value = $name;
		$component -> appendChild($componentCharacteristic);
	}

	if ($row[15] != null){
		$componentCharacteristic = $xml -> createAttribute('geocode');
		//Check for unusable character and spaces
		$obtainCharacter = $row[15].','.$row[16];
		$geocode = substr($obtainCharacter,0,-1);
		$componentCharacteristic -> value = $geocode;
		$component -> appendChild($componentCharacteristic);
	}

	// Complete root of component and update
	$xml -> appendChild($component);

	while (($row = fgets($oppenedData)) !== FALSE)
	{
		//Read data, split then add to array
		list($siteID,$ts,$nox,$no2,$no,$PM10,$NVPM10,$VPM10,$NVPM2_5,$PM2_5,$VPM2_5,$CO,$O3,$SO2,$loc,$lat,$long) = explode(',', $row);

		$row = array($siteID,$ts,$nox,$no2,$no,$PM10,$NVPM10,$VPM10,$NVPM2_5,$PM2_5,$VPM2_5,$CO,$O3,$SO2,$loc,$lat,$long);

		//See if line 3 is empty
		if ($row[2] != null) {
            //create new child element of stations
			$subNode = $xml -> createElement('rec');

            $subNodeChar = $xml -> createAttribute('ts');
            $subNodeChar -> value = $row[1];
            $subNode -> appendChild($subNodeChar);

            $subNodeChar = $xml -> createAttribute('nox');
            $subNodeChar -> value = $row[2];
            $subNode -> appendChild($subNodeChar);

			if ($row[3] != null){
				$subNodeChar = $xml -> createAttribute('no');
				$subNodeChar -> value = $row[3];
				$subNode -> appendChild($subNodeChar);
			}

			if ($row[4] != null){
				$subNodeChar = $xml -> createAttribute('no2');
				$subNodeChar -> value = $row[4];
				$subNode -> appendChild($subNodeChar);
			}

		}
		//Update the rest of the children 
		$component -> appendChild($subNode);
	}

	//Saving the xml file assigned to a variable
	$stringInFile = $xml->saveXML();

	//Write to file and then close
	$write = fopen($createdFile, "w");
	fwrite($write, $stringInFile);
	fclose($write);


	//Save the file, delete last line and add bracket, creates the required number of lines
	ftruncate(fopen($createdFile, 'r+'), filesize($createdFile) - strlen(PHP_EOL));
	$fix = fopen($createdFile, 'a');
	fwrite($fix, '>');
	fclose($fix);
}