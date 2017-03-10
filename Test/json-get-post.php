<?php
  header('Content-type:application/json;charset=utf-8');
  $r = new stdClass();
  $r->get = $_GET;
  $r->post = $_POST;
  echo json_encode($r); 
?>
