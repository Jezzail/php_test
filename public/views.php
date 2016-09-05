<?php	
	//opens viewlog.txt to read the number of hits
	$datei = fopen("./public/viewlog.txt","r");
	$count = fgets($datei,1000);
	fclose($datei);
	$count=$count + 1 ;
	
	$total_views = $count;
	
	// opens viewlog.txt to change new hit number
	$datei = fopen("./public/viewlog.txt","w");
	fwrite($datei, $count);
	fclose($datei);

?>