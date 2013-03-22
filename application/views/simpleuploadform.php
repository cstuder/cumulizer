<?php 
/**
 * Simple upload form
 * 
 * @param string $message;
 * @author christian studer <cstuder@existenz.ch>
 */
$this->load->helper('form');

$this->load->view('_header');

if(isset($message)) echo "<div class='alert alert-info'>{$message}</div>";

echo form_open_multipart('dashboard/simpleupload');
echo form_upload('userfile');
echo '<br />';
echo form_submit('submit', 'Kassenbon hochladen', 'class="btn btn-primary"');
echo form_close();

$this->load->view('_footer');