# php_test
Assignment for a PHP Developer
In this small media manager app, I tried to maintain a clean and organized code to meet all the expected points.
It is made in PHP, HTML, CSS and JQuery. In addition, I decided to use a MySQL database to have an easier way of storing and retrieving data from the posts.
The folder and file structure is as follow:
/php_test/ main folder
•	index.php This is the page that the user sees. Here you can find the HTML code and the form data processing in PHP (Upload the files)
•	ajax.php This is the url that the AJAX calls use to periodically load the posts and display the posts and views count. The response of the AJAX call is encoded in JSON.
•	php_test.sql Is an exportation of the database. It contains only the table posts with the columns id, title, file and date.
/php_test/export/ folder that contains the exports files
•	csv.php create a .csv file with the posts data ready to download by the user.
•	xls.php create a .xls file with the posts data ready to download by the user.
•	zip.php create and store a csv file with the posts data, then create a .zip file with the csv and all the images ready to download by the user.
/php_test/public/ folder that contains public files like js, css sheets and views counter.
•	views.php open and write the viewlog.txt to add a new hit.
•	viewlog.txt only contains the number of views.
/php_test/public/js/ folder that contains the javascript.
•	functions.js with the help of JQuery commands, make sure the file that is trying to be uploaded is correct and calls for the AJAX function that display the posts in the web.
•	jquery.dropdown.min.js plugin that helps with the EXPORT dropdown menu.
/php_test/public/css/ folder that contains the stylesheets.
•	style.css contains all the styles for the classes used in the web.
•	jquery.dropdown.min.css style for the plugin that helps with the EXPORT dropdown menu.
/php_test/media/ folder that stores the images from each post

The user created for MySQL connection only has SELECT and INSET permissions within the php_test database.
