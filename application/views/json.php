<?php
/**
 * JSON Output
 * 
 * @param mixed $payload
 * @author christian studer <cstuder@existenz.ch>
 */
$this->output->set_header('Content-type: application/json');
echo json_encode($payload);