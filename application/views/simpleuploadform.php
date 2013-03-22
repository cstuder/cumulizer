<?php 
/**
 * Simple upload form
 * 
 * @param string $message;
 * @author christian studer <cstuder@existenz.ch>
 */
$this->load->helper('form');

?><!DOCTYPE html>
<html lang="de">
<head>
<meta charset="utf-8">
<title>Cumulizer upload form</title>
<link rel="stylesheet" href="http://meteotest-static.ch/bootstrap-2.3/css/bootstrap.min.css" />
<link rel="stylesheet" href="css/cumulizer.css" />
</head>

<body>
<div class="container">

<?php
	if(isset($message)) echo "<div class='alert alert-info'>{$message}</div>";

	echo form_open_multipart('dashboard/simpleupload');
	echo form_upload('userfile');
	echo '<br />';
	echo form_submit('submit', 'Kassenbon hochladen', 'class="btn btn-primary');
	echo form_close();
?>

</div>
</body>
<script src="http://meteotest-static.ch/jquery/jquery-1.9.0.min.js"></script>
<script src="http://meteotest-static.ch/bootstrap-2.3/js/bootstrap.min.js"></script>
<script src="js/cumulizer.js"></script>
</html>