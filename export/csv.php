<?php
	// output headers so that the file is downloaded rather than displayed
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=media.csv');
	
	// create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');
	
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
?>