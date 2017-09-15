<?php
  require "config.php";

  function filter($data) { //Filters data against security risks.
      if (is_array($data)) {
          foreach ($data as $key => $element) {
              $data[$key] = filter($element);
          }
      } else {
          $data = trim(htmlentities(strip_tags($data)));
          if(get_magic_quotes_gpc()) $data = stripslashes($data);
          $data = mysql_real_escape_string($data);
      }
      return $data;
  }

  $aem = filter($_GET['aem']);

  $conn_details = array(
    "Database" => $api['db'],
    "UID" => $api['UID'],
    "PWD" => $api['PWD']
  );

  $conn = sqlsrv_connect( $api['host'], $conn_details);

  if( $conn === false ) {
       die( print_r( sqlsrv_errors(), true));
  }

  $sql = "SELECT * FROM erasmus_final WHERE 'aem' == ".$aem;

  $stmt = sqlsrv_query( $conn, $sql, array());
  if( $stmt === false ) {
       die( print_r( sqlsrv_errors(), true));
  }


  while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
          var_dump($row);
          echo "<br>";
  }

  sqlsrv_free_stmt( $stmt);


 ?>
