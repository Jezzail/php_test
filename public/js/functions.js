$(function() {
	$("#media").change(function(e) {
	    var file, img;

	    var problems = false;
	    var message = '';
	    
	    //Check if it is not an image
	    var ext = this.value.match(/\.([^\.]+)$/)[1];
	    ext = ext.toLowerCase();
	    switch(ext){
	        case 'jpg':
	        case 'jpeg':
	        case 'png':
	        case 'gif':
	            break;
	        default:
	        	problems = true;
	        	message += "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
	    }

	    //Check file size is greater than 20MB
        var maxSize = 20971520;//20 MB
        var fileSize = this.files[0].size;
        if(fileSize>maxSize){
        	problems = true;
        	message += "Sorry, your file is too large, max size is 20MB.<br>";
        }

        //Check that size is not greater than 1920x1080
        var maxWidth = 1920;
        var maxHeight = 1080;
        var _URL = window.URL || window.webkitURL;
	    if ((file = this.files[0])) {
	        img = new Image();
	        img.onload = function() {
	        	if(this.width > maxWidth || this.height > maxHeight){
	        		problems = true;
		            message += "Sorry, dimensions too big, max are 1920x1080.<br>";
	        	}
	        };
	        img.onerror = function() {
	            problems = true;
	            message += "Sorry, it is not a valid type.<br>";
	        };
	        img.src = _URL.createObjectURL(file);

	    }

	    if(!problems){
	    	$('#form').submit();
	    }else{
	    	$('#errors').html(message);
	    }
	});

	load_posts();
	window.setInterval(load_posts, 15000);
});

//functions that make an AJAX call to load the posts and views
function load_posts(){
	$.ajax({
	    data: {"action": "load_posts"},
	    type: "POST",
	    dataType: "json",
	    url: "ajax.php",
	})
	 .done(function( data, textStatus, jqXHR ) {
		 if(data.success){
		 	$('#posts').html(data.message);
		 	$('#total_posts').html(data.total_posts);
		 	$('#total_views').html(data.total_views);
		    //if we want to show the data in console 
			if ( console && console.log ) {
		         console.log(data);
		     }
	 	}else{
	 		$('#errors').html("Sorry, there was an error uploading the file, try again later.<br> ");
	 	}
	 })
	 .fail(function( jqXHR, textStatus, errorThrown ) {
		 $('#errors').html("Sorry, there was an error uploading the file, try again later.<br> ");
	});
}