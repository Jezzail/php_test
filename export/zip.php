<?php
	//First, we create the CSV file
	// create a file pointer connected to the output stream
	$output = fopen('../media/media.csv', 'w');
	
	// output the column headings
	fputcsv($output, array('Title', 'Filename'));
	
	//make a connection to the database in wich we are storing some data
	$link = mysql_connect('localhost', 'user_php', '12345');
	if(!$link) {
	    die("Sorry, could not connect to database.<br>");
	}
	mysql_select_db("php_test") or die(mysql_error());
	
	$query = 'SELECT title, file FROM posts ORDER BY id DESC';
	$rows = mysql_query($query);
	
	// loop over the rows, outputting them
	while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);
	//end of creating the CSV

	//We get all files in the media folder
	$folder = '../media';
	$medias  = scandir($folder);
	foreach($medias as $media){
		if($media!='.' && $media!='..'){
			//excluding directories
			$files[] = "../media/".$media;
		}
	}
	
	// create new zip opbject
    $zip = new ZipArchive();

    // create a temp file & open it
    $tmp_file = tempnam('.','');
    $zip->open($tmp_file, ZipArchive::CREATE);

    // loop through each file
    foreach($files as $file){
        // download file
        $download_file = file_get_contents($file);

        //add it to the zip
        $zip->addFromString(basename($file),$download_file);
    }
    // close zip
    $zip->close();

    // send the file to the browser as a download
    header('Content-disposition: attachment; filename=media.zip');
    header('Content-type: application/zip');
    readfile($tmp_file);	
?>