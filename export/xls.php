<?php
	// output headers so that the file is downloaded rather than displayed
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=media.xls');
	
	// create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');
	
	//make a connection to the database in wich we are storing some data
	$link = mysql_connect('localhost', 'user_php', '12345');
	if(!$link) {
	    die("Sorry, could not connect to database.<br>");
	}
	mysql_select_db("php_test") or die(mysql_error());
	
	$query = 'SELECT title, file FROM posts ORDER BY id DESC';
	$rows = mysql_query($query);
	
	// column headings
	$list = array (
    	array('Title', 'Filename')
	);
	// loop over the rows, pushing the data in array
	while ($row = mysql_fetch_assoc($rows)){
		array_push($list, $row);
	}
	// loop over the array, outputting them
	foreach ($list as $fields) {
    	fputcsv($output, $fields, "\t", '"');
	}
?>