<!-- TEST PAGE USING BOOTSTRAP -->
<!DOCTYPE html>
<html>
<head>
	<title> Bootstrap Test </title>
	<link rel='stylesheet' href='css/bootstrap.min.css'>
</head>
<body>
	<section class='centainer-fluid'>
		<section style='text-align:center;' class='jumbotron'>
			<h1> Bootstrap Example </h1>
			<?php
				error_reporting(E_ALL ^ E_NOTICE);
				ini_set("display_errords",1);
				//!important ---- require the config file and the Pagination class
				require "config.php";
				include "Pagination.class.php";
				//initialize PDO connection and save object to $d
				try{
					$db=new PDO(DSN,USER,PASS);
				}catch(PDOException $e){
					echo "couldn't connect cos of $e";
				}
				//pass the pdo object,the number of listings per page, and the table name to the class. 
				$paginate = new Pagination($db,5,"customers");
				//call the paginate methods
				$test =$paginate->paginate();
				//print out the returned result
				echo $test;
			?>

		</section>
	</section>
</body>
</html>

	

