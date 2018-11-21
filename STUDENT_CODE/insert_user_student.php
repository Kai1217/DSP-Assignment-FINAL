<html>
<head>
<meta content="en-au" http-equiv="Content-Language">
<title>CIRCLE OF FRIENDS DATABASE</title>
<style type="text/css">
.auto-style1 {
	text-align: center;
}
</style>
</head>
<body>

<?php
//////////////////////////////////////// READ THIS FIRST ! \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
//
//    In the code sections below where student input is asked for, complete the code as described
//    Only change the code between the STUDENT INPUT REQUIRED sections. Other code has been completed for you
//              
//
/////////////////////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


// Connect to MYSQL and select database
$conn = new mysqli("localhost","root","","circle_of_friends");
	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
	}



// Process data if save button is pressed //
if (isset($_POST['btn_save']))
{

	$edt_firstname=$_POST['edt_firstname'];
	$edt_lastname=$_POST['edt_lastname'];
	$edt_email=$_POST['edt_email'];
	$edt_dob=$_POST['edt_dob'];
	$sel_emaildisplay=$_POST['sel_emaildisplay'];

	// First calculate new id for user
	// Use the MAX function to calculate a new ID

    // prepare the query 
    $newid_query=$conn->prepare("SELECT max(person_id)+1 as newid
                                   FROM user_info");
   // execute the query
    $newid_query->execute();
    //get the result                             
    $newid_query_result= $newid_query->get_result();
    // fetch the result
    $newidrow=mysqli_fetch_array($newid_query_result);
    $newid=$newidrow['newid'];						// <<< USE THIS IN YOUR CODE BELOW

/////////////////////////////////////////////////////////////STUDENT INPUT REQUIRED BELOW \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

	// Write the SQL query using PREPARE
    $newuserquery=$conn->prepare("INSERT INTO user_info (person_id, firstname, lastname, dateofbirth, email, 
								   emaildisplay) VALUES(?, ?, ?, ?, ?, ?)");

    // bind parameters for the prepared query, remember there is ONE integer and FIVE strings
    $newuserquery->bind_param("isssss", $newid, $edt_firstname, $edt_lastname, $edt_dob, $edt_email, $sel_emaildisplay);
	
	// RUN the query for database insert using the execute() method
	$newuserquery->execute();
	echo $newuserquery->affected_rows." ROWS INSERTED"; // DISPLAY THE AMOUNT OF ROWS AFFECTED FROM THE EXECUTE METHOD
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	  		
} // end if Button Save pressed
?>

<form action="" method="post">
  <p>CIRCLE OF FRIENDS - DATABASE TEST (1) NEW USER INPUT</p>
	<table style="width: 45%">
		<tr>
			<td class="auto-style1" colspan="2">ENTER NEW USER</td>
		</tr>
		<tr>
			<td style="width: 126px">First Name</td>
			<td style="width: 8px">
			<input name="edt_firstname" size="20" type="text"></td>
		</tr>
		<tr>
			<td style="width: 126px">Last Name</td>
			<td style="width: 8px">
			<input name="edt_lastname" size="20" type="text"></td>
		</tr>
		<tr>
			<td style="width: 126px">Email</td>
			<td style="width: 8px">
			<input name="edt_email" size="50" type="text"></td>
		</tr>
		<tr>
			<td style="width: 126px">Date of Birth</td>
			<td style="width: 8px"><input name="edt_dob" size="10" type="text"></td>
		</tr>
		<tr>
			<td style="width: 126px">Display Email</td>
			<td style="width: 8px"><select name="sel_emaildisplay">
			<option selected="" value="Y">YES</option>
			<option value="N">NO</option>
			</select></td>
		</tr>		
	</table>
	<input name="btn_save" type="submit" value="SAVE">
</form>
</body>
</html>
