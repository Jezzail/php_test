<?php
	/**
	 * This is a simple media manager app to upload images 
	 * 
	 * Author: Pablo Abril
	 * 
	 */

	//views.php is the file that add views to the count in each visit
	include("./public/views.php");
	
	// This will be true when we are uploading content
	if(isset($_FILES) && !empty($_FILES)) {
		$problems = false;//control if there is any problem
		$message = "";//error message
		
		//Check if it is not an image
		$imageFileType = strtolower(pathinfo($_FILES["media"]["name"],PATHINFO_EXTENSION));
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
			$problems = true;
			$message .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
		}
		
		//Check file size is greater than 20MB
		if ($_FILES["media"]["size"] > 20971520) {
			$problems = true;
		    $message .= "Sorry, your file is too large, max size is 20MB.<br>";
		}
		
		//Check that size is not greater than 1920x1080
		$image_info = getimagesize($_FILES["media"]["tmp_name"]);
		$image_width = $image_info[0];
		$image_height = $image_info[1];
		if($image_info===false || $image_width > 1920 || $image_height > 1080){
			$problems = true;
		    $message .= "Sorry, dimensions too big, max are 1920x1080.<br>";
		}
	    
		//If the file have a name we can start trying to upload it
		if (!$problems && isset($_FILES['media']['name']) && ($_FILES['media']['name'])!=''){
			$uploads_dir = './media'; //destination folder
	        $name = basename($_FILES["media"]["name"]);
	        $date = date('YmdHis');//we will add the date to the filename to make it unique
			$filename = $date."_".$name;
	        $target_file = "$uploads_dir/$filename";
			$tmp_name = $_FILES["media"]["tmp_name"];
			//we try to upload the file in the folder
	        if (move_uploaded_file($tmp_name, $target_file)) {
	        	//on success, make a connection to the database in wich we are storing some data
		        $link = mysql_connect('localhost', 'user_php', '12345');
				if(!$link) {
				    $problems = true;
				    $message .= "Sorry, could not connect to database.<br>";
				}
				mysql_select_db("php_test") or die(mysql_error());
				
				//Query to insert the title and filename
				$query = "INSERT INTO posts (title, file) VALUES ('$_POST[title]','$filename')";
				$insert = mysql_query($query);
		    } else {
		    	$problems = true;
		    	$message .= "Sorry, there was an error uploading the file, try again later.<br>";
		    }
		}
	}
	
?>
<html>
	<head> 
		<title>Media Manager</title>
		<link type="text/css" rel="stylesheet" href="public/css/jquery.dropdown.min.css" />
		<link rel="stylesheet" href="public/css/style.css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-3.1.0.js"></script>
		<script type="text/javascript" src="public/js/jquery.dropdown.min.js"></script>
    	<script type="text/javascript" src="public/js/functions.js"></script>
    </head>
    <body>
    	<div class='container'>
    		<div class='topbardiv'>POSTS: <span id='total_posts'></span></div>
    		<div class='topbardiv'>
	    		<button class='btn-file-input' type="button"  data-jq-dropdown="#jq-dropdown-1">EXPORT</button>
	    		<div id="jq-dropdown-1" class="jq-dropdown jq-dropdown-tip">
				    <ul class="jq-dropdown-menu">
				        <li><a href="./export/csv.php">CSV</a></li>
				        <li><a href="./export/xls.php">Excel</a></li>
				        <li><a href="./export/zip.php">ZIP</a></li>
				    </ul>
				</div>
			</div>
    		<div class='topbardiv'>VIEWS: <span id='total_views'></span></div>
    	</div>
    	<div class='container'>
    		<form id='form' action="index.php" method="post" enctype="multipart/form-data">
	    		<div class='titlecontainer'>
	    			<input type="text" name="title" placeholder="Image title" class='titleinput'>
	    		</div>
	    		<div class="file-input-wrapper">
				    <button class="btn-file-input">UPLOAD</button>
				    <input name="media" id='media' type="file" class="upload" accept=".jpeg,.jpg,.png,.gif"/>
				</div>
				<div class='errors' id='errors'>
		    		<?=$message?>
		    	</div>
    		</form>
    	</div>
    	<div id='posts'>
    	</div>
    </body>
</html>