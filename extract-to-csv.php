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