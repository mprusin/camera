
<?php
$localPath = "/";
//$filename = "CP04";
function  file_UCStoUTF($fileUCS, $nameCam){
	
	$content = file_get_contents($fileUCS);
	$utf8content = iconv('UCS-2', 'UTF-8', $content);
	file_put_contents('Pliki/' . $nameCam , $utf8content);
	return 'Pliki/' . $nameCam ;
}
/*function pliki($plik){
	echo "funkcja";
	$path = strrchr('/' , $plik);
	echo $path;
}*/


function odczytCam($nrCam){
	//echo "funkcja"."<br />";
	$path = "";
	
	$filePath = fopen("path", 'r');		//otwarcie pliku ze scieszkami
	if (!$filePath) {
			throw new \RuntimeException('File does not exist');
			echo "Brak pliku Path";
		}
	
	while (($dataPath = fgetcsv($filePath, 0, ';')) !== false)  {		
		$klucz = array_search($nrCam, $dataPath); // $klucz = 2;
		//echo $dataPath[2];
		//echo $klucz;
		if ($klucz == 1){
			$path = $dataPath[2];
			//echo $path;
			//exit();
		}
	
	}
		
	//while (($dataPath = fgetcsv($filePath, 0, ';')) !== false)  {
		
		//konwersja plików
		//echo "============".$dataPath[0]."==================<br />";
		$filename = file_UCStoUTF($path, $nrCam.".sts");

		$handle = fopen($filename, 'r');

		if (!$handle) {
			throw new \RuntimeException('File does not exist');
			echo "Brak pliku z kamery";
		}
		
		$row = 0; 
		while (($data = fgetcsv($handle, 0, ';')) !== false)  {
			if ($data[0] === "DATE" ) {
				$row_nag = $row;
			}
			$row++;
		}		
		fclose ($handle);
		$row_max = $row-1;
		//rewind($hanle);
		//echo $row_max."\t".$row_nag."<br />";
		
		$handle = fopen($filename, 'r');

		if (!$handle) {
			throw new \RuntimeException('File does not exist');
			echo "Brak pliku z kamery";
		}
		$row = 0; 
		$sztuki = 0;
		$bledy = 0.00;
		$lastErr = 0.00;
		$strzalka = "down";
		$col_1 = $col_2 =$col_3 =0;

		while (($data = fgetcsv($handle, 0, ';')) !== false)  {
			//$ile = count($data);
			if ($row >= $row_nag){
				if ($row === $row_nag ) {
					//echo $row."Nagłówek".$data[0]."<br />";
					for ($i=0; $i <= count($data);$i++){
						//echo $data[$i]."<br />";
						switch($data[$i]){
							case 'JOB0.theResult.Inspected':
								$col_1 = $i;
								//echo "Parametr 1=".$i."\t";
								break;
							case 'JOB0.theResult.Class_0':
								$col_2 = $i;
								//echo "Parametr 1=".$i."\t";
								break;
							case 'JOB0.theResult.Class_1':
								$col_3 = $i;
								//echo "Parametr 1=".$i."<br />";
								break;
							default:
								//echo "Brak parametrów";
						}
					}	
					//echo $data[$col_1]."\t",$data[$col_2]."\t",$data[$col_3]."<br />";
					$row++;
					continue;
				}
				//echo $row;
				$inspected = (int) $data[$col_1];
				$class0 = (int) $data[$col_2];
				$class1 = (int) $data[$col_3];	//bledy
									
				//if ($inspected >= $sztuki ){
					$sztuki = $inspected;
					$bledy = number_format((($class1*100)/$sztuki),2);
					if ($bledy < $lastErr){
						$strzalka = "down";
					} elseif ($bledy == $lastErr){
						$strzalka = "-";
					}else {
						$strzalka = "up";
					}
					//echo $row."\t".$inspected."\t".$class0."\t".$class1." Było:". $lastErr. " jest ". $bledy ." ->".$strzalka. "<br />";
					
					$lastErr = $bledy;
				//} elseif ($class0  === 0){
					//echo $row.": ".$sztuki."\t",$bledy."<br />";
					//echo $bledy ." poprzedni:". $lastErr;
					/*if ($bledy <= $lastErr){
						$strzalka = "down";
					} else {
						$strzalka = "up";
					}*/
					if ($row === $row_max){
						return array($data[0], substr($data[1],0,6),$sztuki, number_format($bledy,2), $strzalka);
					}
					
					//exit();
					//echo $strzalka;
					$sztuki =$class0;
					$bledy = number_format((($class1*100)/$sztuki),2);
				//}
				
			}
		/*
			echo sprintf(
				"Było= %s jest= %s %s\n",
				$sztuki,
				$inspected,
				$inspected >= $sztuki ? 'OK' : sprintf('Błąd (oczekiwane: %s)', $inspected)
			);
			$sztuki =$inspected;
			echo "<br />";*/

			$row++;
		}

		fclose ($handle);
	//}	
	fclose($filePath);
}

//$wynik = odczytCam("Kamera_1");
//echo "<br />".$wynik[0]." ".$wynik[1]." ".$wynik[2]." ".$wynik[3]." ".$wynik[4];

?>