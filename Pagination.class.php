<?php
/**
*@package Simple PDO MySQL pagination class
*@author  Ademola Abisayo Paul (sayopaul) https://github.com/sayopaul
*@category Database Pagination
*@version 0.1.1 First ever release + few bug fixes
**Please support my ministry by giving this a star :D . Its my first open source contribution. Though minor, but I'm sure it could be of use to some novice devs. I'm novice too though :) .
*/

class Pagination{
	private $limit_per_page;
	private $database_table_name;
	private $db;

	/**
	*@param PDO object . Expects the given parameter to be a PDO object.
	*@param Limit . Sets the number of results per page.
	*@param database_table_name . Sets the name of the database table.

	*/

	public function __construct($db,$limit_per_page,$database_table_name){
		$this->db=$db;
		$this->limit_per_page=$limit_per_page;
		$this->database_table_name=$database_table_name;

	}

	/**
	*This method returns the number of items in the database and helps to number them properly.
	*@return integer

	*/
	public function rowCount(){
		$sql="SELECT * FROM ". $this->database_table_name;
		$prepared=$this->db->prepare($sql);
		$prepared->execute();
		$rowCount=$prepared->rowCount();
		return (int) $rowCount;
	}

	/**
	*This is the main method, it prints out the links that send the offset variable to the paginate method.
	*@return string

	*/

	public function printNavBar(){
		$num = $this->rowCount();
		$offset=(isset($_GET['offset'])) ? $_GET['offset'] : 0;

		$currentPage=(isset($_GET['page'])) ? $_GET['page'] : 1;

		$prevBtn=(isset($_GET['offset'])) ? $_GET['offset'] - $this->limit_per_page : 0;

		$navBar="<ul class='pagination'>";

		$navBar.="<li> <a href='" . $_SERVER['PHP_SELF'] . "?offset=0&amp;page=1" ."'> First </a> </li>";

		$navBar.=(isset($_GET['offset']) && $_GET['offset'] > 0) ? " <li><a href='".$_SERVER['PHP_SELF']. "?offset=". $prevBtn ."&amp;page=". ($currentPage - 1) ."'> << </a> </li>" : "";


		for($i=$currentPage; $i < ceil( ($currentPage + $this->limit_per_page) + 1);  $i++){
			//print out the nav bar

				$current=(($i-1) * $this->limit_per_page);
				
				//style the current page. You can edit it to whatever you want
				if($current == $offset){

					$style='color:white; font-weight:bold; font-style:italic; background-color:#23527c';
				}else{
					$style=" ";
				}
				//try to do the three little dots thing
				if ($i <= ceil($num/$this->limit_per_page)) {
					$navBar.= "

								<li ><a style='$style' href='". $_SERVER['PHP_SELF'] . "?offset=". (($i-1) * $this->limit_per_page) ."&amp;page=$i". "'>" . $i ."</a>" ."&nbsp;</li>

								";
				}




	}

		//sets the offset. If there is an offset in the url, it is added to the limit per page else, the value is the limit per page.
		$nextBtn=(isset($_GET['offset'])) ? $_GET['offset'] + $this->limit_per_page : $this->limit_per_page;

		//the next button
		$navBar.=((isset($_GET['offset'])) && ($_GET['offset'] + $this->limit_per_page < $num)) ? "<li><a href='".$_SERVER['PHP_SELF']. "?offset=". $nextBtn."&amp;page=". ($currentPage + 1) ."'> >> </a></li>" : " " ;

		//last button
		$navBar.="<li> <a href='" . $_SERVER['PHP_SELF'] . "?offset=" . ((($num/$this->limit_per_page)-1) * $this->limit_per_page) ."&amp;page=". (ceil($num/$this->limit_per_page)) ."'> Last </a> </li> </ul>";

		return (string) $navBar;

	}


	/**
	*retrieves the variable via a GET request from the url .
	*creates the SQL query for the database to return the limited results.
	*@return string --- the results and the navbar in html format. You can then echo it out.
	*PLEASE REMEMBER TO EDIT THE OUTPUT AND FORMAT IT THE WAY YOU WANT. PUT IN THE RELEVANT MYSQL COLUMN NAMES IN PLACE OF name and dept

	*/
	public function paginate(){
		$output="<table class='table table-striped'>
					<thead>
						<tr style='text-align:center;'> PAGINATION TEST </tr>
					</thead>";
		$offset=(isset($_GET['offset'])) ? $_GET['offset'] : 0;
		
		$sql= " SELECT * FROM " . $this->database_table_name. " ORDER BY customerNumber ASC " . " LIMIT " . $this->limit_per_page . " OFFSET ". $offset ;
		
		$prepared=$this->db->prepare($sql);
		$prepared->execute();

		//loops through the prepared object. You can format the html to make it display however you deem fit
		while ($valid=$prepared->fetchObject()){
			//You can choose to format it anyway you want to format it . Ensure the object properties are the same with the column names in your table
			$output .="
					<tr>
						<td> $valid->contactFirstName </td>
						<td>$valid->contactLastName </td>
					</tr>

				";
		}
		$output.="</table>";
		$output .= $this->printNavBar();
		return $output;


	}
}
