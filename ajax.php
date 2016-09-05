<?php
	//get the action
	if(!isset($_POST['action'])){
		print "ERROR";
	}
	
	switch ($_POST['action']){
		case 'load_posts':
			//make a connection to the database in wich we are storing some data
			$link = mysql_connect('localhost', 'user_php', '12345');
			if(!$link){
			    $jsondata['success'] = false;
			    echo json_encode($jsondata);
			    break;
			}
			mysql_select_db("php_test") or die(mysql_error());
			
			$query = 'SELECT * FROM posts ORDER BY id DESC';
			$rows = mysql_query($query);
			
			$posts = "";
			$total_posts = 0;
			// loop over the rows and getting the data
			while ($row = mysql_fetch_assoc($rows)){
				$posts .= "<div class='container'><div class='title'>".$row['title']."</div><div class='date'>".$row['date']."</div><div><img class='image' src='./media/".$row['file']."' alt='".$row['title']."'></div></div>";
				$total_posts++;
			}
			$jsondata['message'] = $posts;
			$jsondata['total_posts'] = $total_posts;
			
			//////
			//opens viewlog.txt to read the number of hits
			$datei = fopen("./public/viewlog.txt","r");
			$count = fgets($datei,1000);
			fclose($datei);
			$jsondata['total_views'] = $count;
			
			$jsondata['success'] = true;
			
		    header('Content-type: application/json; charset=utf-8');
		    echo json_encode($jsondata);
			
			break;
	}
?>