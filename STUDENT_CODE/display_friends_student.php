<!-- THE BOOTSTRAP CASCADING STYLE SHEETS LIBRARY IS USED IN THIS APPLICATION UNDER THE MIT LICENSE. CSS IS DELIVERED
THROUGH A CONTENT DELIVERY NETWORK (CDN). 

The MIT License (MIT)

Copyright (c) 2011-2018 Twitter, Inc.
Copyright (c) 2011-2018 The Bootstrap Authors

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated 
documentation files (the "Software"), to deal in the Software without restriction, including without limitation 
the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and 
to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all 
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR 
PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR 
ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.


THE LIBRARY IS PUSHED INTO A GITHUB REPOSITORY HERE: https://github.com/twbs/bootstrap/blob/v4.1.3/

-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<meta content="en-au" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Display Friends</title>
<style>
    body
    {
        background-color: #FFFFFF;
        font-family: Helvetica;
    }
</style>
</head>
<body>
<p>CIRCLE OF FRIENDS - DATABASE TEST&nbsp; (2) - DATA OUTPUT</p>
<p>&nbsp;</p><form method="post" action="">TEST FRIENDS OF USER - ENTER USER ID BELOW<br />
	<br />
	Enter User ID <input name="edt_userid" type="text" /><input name="btn_submit" type="submit" class="btn btn-warning" value="Submit" /><br />
	<br />
	<br />
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>


<?php

//////////////////////////////////////// READ THIS FIRST ! \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
//                                                                                                              //
//    In the code sections below where student input is asked for, complete the code as described               //
//    Only change the code in the STUDENT INPUT REQUIRED sections. Other code has been completed for you        //
//                                                                                                              //
//                                                                                                              //
/////////////////////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


// Connect to MYSQL and select database
$conn = new mysqli("localhost","root","","circle_of_friends");
    if ($conn->connect_error)
    { // IF THE CONNECTION FAILS, OUTPUT CONNECTION ERROR
	    die("Connection failed: " . $conn->connect_error);
    }

// Process data if submit button is pressed //
if (isset($_POST['btn_submit']))
{

  // GET THE USERID FROM THE EDIT BOX
   $edt_userid=$_POST['edt_userid'];
   
   
  /////////////////// THIS CODE DISPLAYS THE NAME OF THE PERSON ON THE SCREEN //////////////////////
  /////////////////// THIS CODE HAS BEEN WRITTEN FOR YOU - DO NOT EDIT        ////////////////////// 
   
   // Get the name of this person and display on the screen
   // Create a query to access this persons details 
   // Prepare the query
   $personquery=$conn->prepare("SELECT firstname,lastname
                                FROM user_info 
                                WHERE person_id=?"); // SELECT THE FIRSTNAME & LASTNAME FROM THE USER_INFO TABLE WHERE
                                                    // THE PERSON ID IS EQUAL TO THE USER'S INPUT PROVIDED BY 
                                                    // THE VARIABLE '$edt_userid'
   // bind the parameters
   $personquery->bind_param("s",$edt_userid);
  
   // Run the query
   $personquery->execute();
 
   // Get the result
   $personqueryresult=$personquery->get_result();
  
   // Fetch the result (there will only be one row)
   $personqueryresultrow=mysqli_fetch_array($personqueryresult);
   
   // Display the name of the person on screen
   echo "You have selected the user with the name :<b> ".$personqueryresultrow['firstname']." ".$personqueryresultrow['lastname']."</b></BR></BR>";
  
 /////////////////// THIS CODE DISPLAYS THE SCHOOLS  OF THE PERSON ON THE SCREEN //////////////////////
////////////////////  STUDENT INPUT REQUIRED AS INDICATED                        //////////////////////

    // List the schools this person attended   
    // Create the query to list all schools for person entered into edit box.
    // Prepare the query    
    $schoolquery=$conn->prepare("SELECT person_id, attendance.school_id, schoolname, schoollocation
                                FROM attendance, school_info
                                WHERE person_id = ? AND attendance.school_id = school_info.school_id");
                                // The above line selects the person_id, attendance.school_id, schoolname, schoollocation
                                // columns from the attendance and school_info tables.
                                // Where the person_id is equal to the $edt_userid variable, and attendance.schoolid
                                // is equal to school_info.school_id.
                                // This displays the users attended schools.
    // BINDING PARAMETERS
    $schoolquery->bind_param("s", $edt_userid);   
    // The above line binds the variable; $edt_userid to a parameter holding a string datatype.
    // This allows for no SQL injection to take place in production.

    // Run the query - through the execute function 
    $schoolquery->execute();
       
    // GET THE RESULT THROUGH THE '$schoolquery' VARIABLE
    $schoolqueryresult=$schoolquery->get_result();
    
    // Put a heading on the screen
	echo "This person attended the following schools :</BR></BR>";
	
	// Loop though the result from the query and output the school names
    while ($schoolqueryresultrow=mysqli_fetch_array($schoolqueryresult))
    {
        echo $schoolqueryresultrow['schoolname']." in ".$schoolqueryresultrow['schoollocation']."</BR>";
    }
	
/////////////////////////////////////////////////////////////STUDENT INPUT REQUIRED BELOW \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

/// THIS CODE WILL DISPLAY ALL FRIENDS OF THE PERSON ON THE SCREEN
/// Complete code where indicated

   // Create a query to get all the persons friends
   $friendquery=$conn->prepare("SELECT person1_id, person2_id, firstname, lastname
                                FROM friends, user_info
                                WHERE person1_id= ? AND friends.person2_id = user_info.person_id");
                                // The aboce line selects the person1_id, person2_id, firstname and lastname
                                // columns from the friends and user_info tables.
                                // Where person1_id is equal to the variable; $edt_userid
                                // which is binded to a parameter in the next statement.
                                // And where friends.person2_id is equal to user_info.person_id
                                // This displays the friends that the user is friended with.

   
   // BINDING PARAMETERS
   $friendquery->bind_param("s", $edt_userid);                                    
   // EXECUTE THE QUERY 
   $friendquery->execute(); // This executes the query with the execute() function.
   
   // get the result            
   $friendqueryresult=$friendquery->get_result();
  
   // Put a heading on the screen
   echo "</BR></BR>This persons friends are : </BR></BR>";
   // Loop though the friends and display them on screen
   while ($friendqueryresultrow=mysqli_fetch_array($friendqueryresult)) // WHEN EXECUTED, THIS WHILE LOOP DISPLAYS THE
   {                                                                    // USER'S ID, FIRSTNAME AND LASTNAME
       echo "<strong>User ID: </strong>";
       // DISPLAY THE PERSON2 ID - IN OTHER WORDS, THE LIST OF FRIENDS
       echo $friendqueryresultrow['person2_id'];
       echo " | ";
       echo "<strong>Firstname: </strong>";
       // DISPLAY PERSON2'S FIRSTNAME
       echo $friendqueryresultrow['firstname'];
       echo " | ";
       echo " ";
       echo "<strong>Lastname: </strong>";
       // DISPLAY PERSON2'S LASTNAME
       echo $friendqueryresultrow['lastname']."<BR>";  
   }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
}
?>

</body>
</html>