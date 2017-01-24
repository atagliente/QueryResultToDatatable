/**
 * Created by: Antonio Tagliente
 * Date: 24.01.17
 * Time: 22:04
 */

<?php

define("SERVER_NAME", "localhost");
define("USER_NAME","root");
define("PASSWORD","");
define("DATABASE","simple_db");
/*
 * Temperature is a hypothetical table that contains 2 fields, date and value
 */
define("TEMP_QUERY","SELECT * FROM `temperature` WHERE 1");

// Create connection
$mysqli = new mysqli(SERVER_NAME, USER_NAME, PASSWORD, DATABASE);
// Check connection
if ($mysqli ->connect_error) {
    $string = "Connection failed: " . $mysqli->connect_error;
    die($string);
    throw new Exception($string);
}
if (!syslog(LOG_DEBUG, $string)) {
    throw new Exception("Error - Not save into syslog: ".$string);
}

/*
 * This function return a json (datatable formatted) from query
 */
public function getDataGraphFromQuery($header, $sql) {
    $result = $mysqli->query($sql);
    if($result->num_rows > 0) {
        $table = array();
        foreach ($header as $column) {
            $table['cols'][] = array('id' => '', 'label' => $column[0], 'type' => $column[1]);;
        }
        $rows = array();
        foreach($result as $row){
            if (count($header) != count($row)) throw  new Exception("Error - Columns number mismatch");
            $temp = array();
            foreach ($row as $cell) {
                $temp[] = array('v' => $cell);
            }
            $rows[] = array('c' => $temp);
        }
        $result->free();
        $table['rows'] = $rows;
        $jsonTable = json_encode($table, true);
        return $jsonTable;
    } else {
        return "result is empty";
    }
}

// prepares the columns' statement 
$headers = array(array("Date","string"), array("Value","number"));

echo getDataGraphFromQuery($headers, TEMP_QUERY);

?>