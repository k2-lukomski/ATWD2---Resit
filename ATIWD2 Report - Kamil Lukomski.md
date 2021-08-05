# XML processing models

### XML as Text
At it's core XML is text based meaning it's syntax and the content included in an XML file is made up of text. This text can be viewed by many different tools eg. Notepad. This makes XML really easy to access and developers can have their code up and running within seconds. On the other hand, XML possesses features which cannot be processed by simple text editors and more advanced tools such as Notepad++ have to be used to allow for XML processing.

### XML as Events
When reading an XML file, a parser is used to do so. As the parser moves from one end of the file to the other it may be required to retrieve certain resources from an external location, check the validity of code or apply namespaces. All this is done to make sure that the file is read correctly and includes all the context needed to understand the information. Event parsers do this as they go along and record events as they come through. An event could include when an element has started/ended and what it included. 

### XML as Tree Model
XML documents are required to be well structured. This is why the Tree Model is implemented to categorize different elements which all contain different attributes. Each element can also store a different element which has attributes of their own, therefore creating a Tree Model. API's which use the Tree Model usually give an overview of the entire tree to the application after the parsing has concluded. This way the application does not have to deal with finding context or encountering an error because the use of the tree model and parsing has already resolved those issues.

# DOM oriented parsers as compared to stream oriented parsers
The main differeance between a DOM parser and a stream parser is when the data is ready to be viewed by the user. A DOM parser will only allow the user to view the information after the entire parse has been finished while a stream parser returns information as it is being read in real time. Both of these methods are very good in their own right but they need to be used depending on the situation in which you find yourself in.

If you are looking for a small piece of information in a big XML file it would be more beneficial to use a stream parser instead of waiting around for a DOM parser to finish parsing the entire document. Oppositely if your are looking for a list off all tags of a certain type in a document then using a DOM parser would be the better option.


# Extending visualization
Google Chart API can be used to create charts. This tool has a good range of charts that you can create. It also is very customizable meaning you can create unique charts such as scatter charts or line charts which show changes over a period of time. On top of that, a pie chart can be used to indicate which station has recorded the best quality air out of all stations. Quickchart API is also another great tool which allows for making charts. This tool uses javascript to do so. Since the tool is open source there are many charts to choose from as most of them have been created by other users.Another chart which could come in handy is a comparison chart which would compare the best station to the worse.

# Links to all code and data files
The file extract-to-php.php can be found [HERE](https://github.com/k2-lukomski/ATWD2---Resit/blob/main/extract-to-csv.php)

Preview:
```php
<?php
// Starting clock time in seconds
$start_time = microtime(true);

# set timezone
@date_default_timezone_set("GMT");

//Due to working with large file, variables are set to maximize performance
ini_set('memory_limit','512');
ini_set('max_execution_time','300');
ini_set('auto_detect_line_endings', TRUE);

//variable which holds the curent line in the file
$currentFileLine = 0;

//Open original file
$open = fopen("air-quality-data-2004-2019.csv", "r");

//Create file for each station
$data_188 = fopen("data_188.csv", "w");
$data_203 = fopen("data_203.csv", "w");
$data_206 = fopen("data_206.csv", "w");
$data_209 = fopen("data_209.csv", "w");
$data_213 = fopen("data_213.csv", "w");
$data_215 = fopen("data_215.csv", "w");
$data_228 = fopen("data_228.csv", "w");
$data_270 = fopen("data_270.csv", "w");
$data_271 = fopen("data_271.csv", "w");
$data_375 = fopen("data_375.csv", "w");
$data_395 = fopen("data_395.csv", "w");
$data_452 = fopen("data_425.csv", "w");
$data_447 = fopen("data_447.csv", "w");
$data_459 = fopen("data_459.csv", "w");
$data_463 = fopen("data_463.csv", "w");
$data_481 = fopen("data_481.csv", "w");
$data_500 = fopen("data_500.csv", "w");
$data_501 = fopen("data_501.csv", "w");

//Get the first line which contain headers
$ogFileHeader = fgets($open);

//Put all headers into variables
list($Date_Time,$NOx,$NO2,$NO,$SiteID,$PM10,$NVPM10,$VPM10,$NVPM2_5,$PM2_5,$VPM2_5,$CO,$O3,$SO2,$Temperature,$RH,$Air_Pressure,$Location,$geo_point_2d,$DateStart,$DateEnd,$Current) = explode(";", $ogFileHeader);

//Put all header variables in an array
$modFileHeader = array($SiteID,"Ts",$NOx,$NO2,$NO,$PM10,$NVPM10,$VPM10,$NVPM2_5,$PM2_5,$VPM2_5,$CO,$O3,$SO2,$Location,"Lat","Long");

//Input headers into files
fputcsv($data_188, $modFileHeader);
fputcsv($data_203, $modFileHeader);
fputcsv($data_206, $modFileHeader);
fputcsv($data_209, $modFileHeader);
fputcsv($data_213, $modFileHeader);
fputcsv($data_215, $modFileHeader);
fputcsv($data_228, $modFileHeader);
fputcsv($data_270, $modFileHeader);
fputcsv($data_271, $modFileHeader);
fputcsv($data_375, $modFileHeader);
fputcsv($data_395, $modFileHeader);
fputcsv($data_447, $modFileHeader);
fputcsv($data_452, $modFileHeader);
fputcsv($data_459, $modFileHeader);
fputcsv($data_463, $modFileHeader);
fputcsv($data_481, $modFileHeader);
fputcsv($data_500, $modFileHeader);
fputcsv($data_501, $modFileHeader);

//When the orikginal file is open
while(!feof($open))
{
    //Get the next line
    $dataArray = fgets($open);
    
    //Put line into variables and seperate them using explode
    list($Date_Time,$NOx,$NO2,$NO,$SiteID,$PM10,$NVPM10,$VPM10,$NVPM2_5,$PM2_5,$VPM2_5,$CO,$O3,$SO2,$Temperature,$RH,$Air_Pressure,$Location,$geo_point_2d,$DateStart,$DateEnd,$Current) = explode(";", $dataArray);

    //Convert the date and time into a timestamp
    $conDateTime = strtotime($Date_Time);

    //Explode geo_point_2d into Latitude and Longitude and store in corresponding variables
    list($Latitude,$Longitude) = explode(",", $geo_point_2d);

    //Put needed data in array
    $dataArray = array($SiteID,$conDateTime,$NOx,$NO2,$NO,$PM10,$NVPM10,$VPM10,$NVPM2_5,$PM2_5,$VPM2_5,$CO,$O3,$SO2,$Location,$Latitude,$Longitude);

    //If lines 2 and 11 are not empty
    if($dataArray[2] != null or $dataArray[11] != null){
        //Input station data into corresponding files
        switch ($dataArray[0]) {
            case 188:
                fputcsv($data_188, $dataArray);
                break;
            case 203:
                fputcsv($data_203, $dataArray);
                break;
            case 206:
                fputcsv($data_206, $dataArray);
                break;
            case 209:
                fputcsv($data_209, $dataArray);
                break;
            case 213:
                fputcsv($data_213, $dataArray);
                break;
            case 215:
                fputcsv($data_215, $dataArray);
                break;
            case 228:
                fputcsv($data_228, $dataArray);
                break;
            case 270:
                fputcsv($data_270, $dataArray);
                break;
            case 271:
                fputcsv($data_271, $dataArray);
                break;
            case 375:
                fputcsv($data_375, $dataArray);
                break;
            case 395:
                fputcsv($data_395, $dataArray);
                break;
            case 447:
                fputcsv($data_447, $dataArray);
                break;
            case 452:
                fputcsv($data_452, $dataArray);
                break;
            case 459:
                fputcsv($data_459, $dataArray);
                break;
            case 463:
                fputcsv($data_463, $dataArray);
                break;
            case 481:
                fputcsv($data_481, $dataArray);
                break;
            case 500:
                fputcsv($data_500, $dataArray);
                break;
            case 501:
                fputcsv($data_501, $dataArray);
                break;

        }
    }
    //Add to the line counter
    $currentFileLine++;

}

//Close all files
fclose($open);
fclose($data_188);
fclose($data_203);
fclose($data_206);
fclose($data_209);
fclose($data_213);
fclose($data_215);
fclose($data_228);
fclose($data_270);
fclose($data_271);
fclose($data_375);
fclose($data_395);
fclose($data_447);
fclose($data_452);
fclose($data_459);
fclose($data_463);
fclose($data_481);
fclose($data_500);
fclose($data_501);

// End clock time in seconds
$end_time = microtime(true);

// Calculate script execution time
$execution_time = ($end_time - $start_time);

//Delete warnings
ob_clean();

//Print execution time
echo " Execution time of script = ".$execution_time." sec";

?>
```

The file normalize-to-xml.php can be found [HERE](https://github.com/k2-lukomski/ATWD2---Resit/blob/main/normalize-to-xml.php)

Preview:

```php
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
```

The file air-quality.xsd can be found [HERE](https://github.com/k2-lukomski/ATWD2---Resit/blob/main/air-quality.xsd)

Preview:

```xsd
<xs:schema attributeFormDefault="unqualified" elementFormDefault="qualified" xmlns:xs="http://www.w3.org/2001/XMLSchema">
  <xs:element name="station">
    <xs:complexType>
      <xs:sequence>
        <xs:element name="rec" maxOccurs="unbounded" minOccurs="0">
          <xs:complexType>
            <xs:simpleContent>
              <xs:extension base="xs:string">
                <xs:attribute type="xs:dateTime" name="ts" use="optional"/>
                <xs:attribute type="xs:float" name="nox" use="optional"/>
                <xs:attribute type="xs:float" name="no" use="optional"/>
                <xs:attribute type="xs:float" name="no2" use="optional"/>
              </xs:extension>
            </xs:simpleContent>
          </xs:complexType>
        </xs:element>
      </xs:sequence>
      <xs:attribute type="xs:short" name="id"/>
      <xs:attribute type="xs:string" name="name"/>
      <xs:attribute type="xs:string" name="geocode"/>
    </xs:complexType>
  </xs:element>
</xs:schema>
```
The CSV files can be found [HERE](https://github.com/k2-lukomski/ATWD2---Resit/tree/main/CSV%20Files)

The XML files can be found [HERE](https://github.com/k2-lukomski/ATWD2---Resit/tree/main/XML%20Files)