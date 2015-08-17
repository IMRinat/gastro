<?php
  echo "privet";
  if(isset($_GET["name"]))    $nam=$_GET["name"];
//  $ip=$this->server('remote_addr');
 //$_SERVER['REMOTE_ADDR'];
  print_r ($_SERVER);
  print $nam;
  //print $ip;


  //file_put_contents ( $filename , mixed $data [, int $flags = 0 [, resource $context ]] )

?>
