<?php
  require "config.php";

  //TODO: Filter aem parameter

  $aem = $_GET['aem'];
  $depID = $_GET['depID'];

  $conn_details = array(
    "Database" => $api['db'],
    "UID" => $api['UID'],
    "PWD" => $api['PWD']
  );

  $conn = sqlsrv_connect( $api['host'], $conn_details);

  if( $conn === false ) {
       die( print_r( sqlsrv_errors(), true));
  }

  $sql = "SELECT * FROM erasmus_final WHERE spec_aem = '$aem' AND depID = '$depID'";

  $stmt = sqlsrv_query( $conn, $sql, array());
  if( $stmt === false ) {
       die( print_r( sqlsrv_errors(), true));
  }


  while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      exit(json_encode($row));
  }

  sqlsrv_free_stmt( $stmt);


 ?>
