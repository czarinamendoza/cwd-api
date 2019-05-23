<?php
$connect = mysql_connect('localhost', 'root', 'asdf'); 
mysql_select_db ('todoList'); 
$sql_details_notes = "SELECT * FROM `tbl_todo` WHERE TD_TYPE ='NOTES'";
$res_notes = mysql_query($sql_details_notes);

$sql_details_todo = "SELECT * FROM `tbl_todo` WHERE TD_TYPE ='TODO'";
$res_todo = mysql_query($sql_details_todo);

error_reporting(0);
$var_title = $_POST['txtTitle'];
$var_Details = $_POST['txtDetails'];

function updateDatabase($sql,$label_details){
	if (!mysql_query($sql,$connect))
	  {
	  die('Error: '.$connect);
	  }

	$page = $_SERVER['PHP_SELF'];
	$sec = "2";
	header("Refresh: $sec; url=$page");
}

if ($_POST['btn_getDetails'])
{
	$sql="INSERT INTO tbl_todo (TD_TYPE, TD_TITLE, TD_DETAILS, TD_STATUS) VALUES ('NOTES','$var_title','$var_Details','0')";

	$label_details = "1 record added";
	updateDatabase($sql,$label_details);

}

if($_POST['btn_deleteDetails']){
	$var_id = $_POST['btn_deleteDetails'];
	$sql="DELETE FROM tbl_todo WHERE TD_ID='$var_id'";

	if (!mysql_query($sql,$connect))
	{
	 die('Error: ' . mysql_error());
	}

	$page = $_SERVER['PHP_SELF'];
	$sec = "2";
	header("Refresh: $sec; url=$page");

	echo "1 record deleted";
}

if($_POST['btn_moveDetailsToDo']){
	$var_id = $_POST['btn_moveDetailsToDo'];
	$sql="UPDATE tbl_todo SET TD_TYPE='NOTES' WHERE TD_ID='$var_id'";

	if (!mysql_query($sql,$connect))
	{
	 die('Error: ' . mysql_error());
	}

	$page = $_SERVER['PHP_SELF'];
	$sec = "2";
	header("Refresh: $sec; url=$page");

	echo "1 record updated";
}

if($_POST['btn_moveDetailsNotes']){
	$var_id = $_POST['btn_moveDetailsNotes'];
	$sql="UPDATE tbl_todo SET TD_TYPE='TODO' WHERE TD_ID='$var_id'";

	if (!mysql_query($sql,$connect))
	{
	 die('Error: ' . mysql_error());
	}

	$page = $_SERVER['PHP_SELF'];
	$sec = "2";
	header("Refresh: $sec; url=$page");

	echo "1 record updated";
}

if($_POST['btn_changeundoneDetailsToDo']){
	$var_id = $_POST['btn_changeundoneDetailsToDo'];
	$sql="UPDATE tbl_todo SET TD_STATUS='0' WHERE TD_ID='$var_id'";

	if (!mysql_query($sql,$connect))
	{
	 die('Error: ' . mysql_error());
	}

	$page = $_SERVER['PHP_SELF'];
	$sec = "2";
	header("Refresh: $sec; url=$page");

	echo "1 record updated";
}

if($_POST['btn_changedoneDetailsToDo']){
	$var_id = $_POST['btn_changedoneDetailsToDo'];
	$sql="UPDATE tbl_todo SET TD_STATUS='1' WHERE TD_ID='$var_id'";

	if (!mysql_query($sql,$connect))
	{
	 die('Error: ' . mysql_error());
	}

	$page = $_SERVER['PHP_SELF'];
	$sec = "2";
	header("Refresh: $sec; url=$page");

	echo "1 record updated";
}


?>
<html>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<table>
			<tr>
				<td>
					<label>Title</label>
					<input type="text" name="txtTitle" >
				</td>
				<td>
					<label>Details</label>
					<textarea rows="4" cols="50" name="txtDetails"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" name="btn_getDetails">
				</td>
			</tr>
		</table>
		
		<br><br>
		<table>
			<tr><td colspan="3">NOTES</td></tr>
			<tr>
				<td>Title</td>
				<td>Details</td>
				<td>Action</td>
			</tr>
			<?php

				while($row_notes = mysql_fetch_array($res_notes)){

				echo "<tr>";
				echo "<td>",$row_notes['TD_TITLE'],"</td>";
				echo "<td> ",$row_notes['TD_DETAILS'],"</td>";
				echo "<td> <button type='submit' name='btn_deleteDetails' value='",$row_notes['TD_ID'],"'>DELETE</button>					 
					 <button type='submit' name='btn_moveDetailsNotes' value='",$row_notes['TD_ID'],"'>MOVE</button></td>";
				echo "</tr>";
				}

			?>
		</table>
		<br><br>
		<table>
			<tr><td colspan="3">TO DO</td></tr>
			<tr>
				<td>Title</td>
				<td>Details</td>
				<td>Action</td>
			</tr>
			<?php

				while($row_todo = mysql_fetch_array($res_todo)){

				$checked = ($row_todo['TD_STATUS'] == 1) ? 'checked' : '';
				echo "<tr>";
				echo "<td> <input type='checkbox' name='chk_marking' value='",$row_todo['TD_ID'],"' ",$checked,">",$row_todo['TD_TITLE'],"</td>";
				echo "<td> ",$row_todo['TD_DETAILS'],"</td>";
				echo "<td><button type='submit' name='btn_deleteDetails' value='",$row_todo['TD_ID'],"'>DELETE</button>
					 <button type='submit' name='btn_moveDetailsToDo' value='",$row_todo['TD_ID'],"'>MOVE</button>";

				if($row_todo['TD_STATUS'] == 1){

					echo "<button type='submit' name='btn_changeundoneDetailsToDo' value='",$row_todo['TD_ID'],"'>UNDONE</button></td>";
				}else{

					echo "<button type='submit' name='btn_changedoneDetailsToDo' value='",$row_todo['TD_ID'],"'>DONE</button></td>";
				}

				echo "</tr>";
				}

			?>
		</table>

	</form>

	<?php

	echo $message1;

	?>


</html>