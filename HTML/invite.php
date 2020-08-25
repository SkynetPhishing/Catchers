<?php
 error_reporting(0);
 include('session.php');
include_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Red+Rose&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/form_2.css">
</head>
<body>
    <div class="container">
        <h2>Mail Information</h2>
        <form class="form-horizontal" action="" method="post" name="uploadCSV"
    enctype="multipart/form-data">
            <fieldset>
                <label class="col-md-4 control-label">Choose CSV File</label> <input
            type="file" name="file" id="file" accept=".csv">
        <button type="submit" id="submit" name="import1"
            class="btn-submit">Import</button>
        <br />

    </div>
    <div id="labelError"></div>
			</fieldset>
		</form>
		<?php

if (isset($_POST["import1"])) {
    //echo"1";
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $sqlInsert = "INSERT into invite (username,email)
                   values ('" . $column[0] . "','" . $column[1] . "')";
            $result = mysqli_query($db, $sqlInsert);
            
            if (! empty($result)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
    }
}
?>
<?php
if (isset($_POST["import1"]))
{
$sqlSelect = "SELECT distinct * FROM invite";
$result = mysqli_query($db, $sqlSelect);
            
if (mysqli_num_rows($result) > 0) {
?>
<table id='userTable'>
    <thead>
        <tr>
            <th>User Name</th>
            <th>Email Id</th>
        </tr>
    </thead>
    <?php
	while ($row = mysqli_fetch_array($result)) {
    ?>

    <tbody>
        <tr>
            <td><?php  echo $row['username']; ?></td>
            <td><?php  echo $row['email']; ?></td>
        </tr>
     <?php
     }
     ?>
    </tbody>
</table>
<?php }} ?>
<div>
<form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
	Users Selected for Invite are:<br>
	<input type="submit" name="submit" value="Invite">
</form>
</div>
<br>
<form action="invite2.php" method="post">
<fieldset>
<?php
if(array_key_exists('submit', $_POST)) { 
sendmail(); 
} 
function sendmail()
{
	?>
	<div>
		<h3>Please Enter Below the Details to send mail.</h3>
	</div>
	<div>
		   <div class="form-group">
			  <label for="formGroupExampleInput">SMTP Server Name:</label>
			  <input type="text" class="form-control" id="formGroupExampleInput" name="server" placeholder="smtp1.example.com" required>
			</div>
			<div class="form-group">
			  <label for="formGroupExampleInput2">SMTP User Name:</label>
			  <input type="email" class="form-control" id="formGroupExampleInput2" name="username" placeholder="user@example.com" required>
			</div>
			<div class="form-group">
				<label for="formGroupExampleInput2">SMTP Password:</label>
				<input type="password" class="form-control" id="formGroupExampleInput2" name="password" placeholder="Encrpted" required>
			</div>
			<div class="mb-3 form-group">
				<label for="validationTextarea">Mail Body</label>
				<textarea class="form-control " id="validationTextarea" name="mailbody" placeholder="Required mail body textarea" required></textarea>
			</div>
			<div class="form-check form-group">
				<input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
				<label class="form-check-label" for="invalidCheck">
				  Agree to terms and conditions
				</label>
				<div class="invalid-feedback">
				  You must agree before submitting.
				</div>
			</div>
			<br>
			<input type='submit' name='saveconfig' value='Send Mail'/>
	</div>
	<?php
}
?>
	</fieldset>
        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" ></script>
</html>