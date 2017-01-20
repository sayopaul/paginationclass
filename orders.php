<?php
	
	include_once "../models/Order_table.class.php";
	require "../"

	$stats = new Order($db);
	$all = $stats->getAllOrders();
	$orders_out ="";
	$orders_out ="<section class='center-align'> <h3 >Recent Orders</h3>";
	while($valid=$all->fetchObject()){
		
		$orders_out.="
		<section class='row'> 
			<table style='margin-left:3px; margin-right:20px; border:1px solid gray;' class=' col s12 striped'>
				<thead>
					<tr style='text-align:center;'>
						<th> Order Number: $valid->order_id  </th>
					</tr>


				</thead>
				 <tr>
				 	<td>Name:  </td>
				 	<td> $valid->f_name</td>



				 </tr>
 				 <tr>
				 	<td> Foor Ordered: </td>
				 	<td> $valid->o_name</td>



				 </tr>
				 <tr>
				 	<td> Email address </td>
				 	<td> $valid->o_email</td>



				 </tr>
				  <tr>
				 	<td> Phone Number </td>
				 	<td> $valid->o_number </td>



				 </tr>
				  <tr>
				 	<td> Mode of Collection:</td>
				 	<td> $valid->o_mode </td>



				 </tr>
				  <tr>
				 	<td> Quantity: </td>
				 	<td> $valid->o_quantity</td>



				 </tr>
				  <tr>
				 	<td> Address: </td>
				 	<td> $valid->o_address</td>



				 </tr>
				  <tr>
				 	<td> Total Moneyyy :D : </td>
				 	<td> $valid->o_price</td>



				 </tr>
				  <tr>
				 	<td> Date and Time Ordered : </td>
				 	<td> $valid->o_date</td>



				 </tr>





			</table>
			<a href='http://jessies.sayothechristian.com.ng'>
	</section>		
		" ;
	

	}

	return $orders_out;
