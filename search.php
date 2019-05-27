<?php

$term = $_GET["term"];
$companies = array(
    array("label" => "JAVA", "value" => "JAVA"),
    array("label" => "DATA IMAGE PROCESSING", "value" => "DATA IMAGE PROCESSING"),
    array("label" => "JAVASCRIPT", "value" => "JAVASCRIPT"),
    array("label" => "DATA MANAGEMENT SYSTEM", "value" => "DATA MANAGEMENT SYSTEM"),
    array("label" => "COMPUTER PROGRAMMING", "value" => "COMPUTER PROGRAMMING"),
    array("label" => "SOFTWARE DEVELOPMENT LIFE CYCLE", "value" => "SOFTWARE DEVELOPMENT LIFE CYCLE"),
    array("label" => "LEARN COMPUTER FUNDAMENTALS", "value" => "LEARN COMPUTER FUNDAMENTALS"),
    array("label" => "IMAGE PROCESSING USING JAVA", "value" => "IMAGE PROCESSING USING JAVA"),
    array("label" => "CLOUD COMPUTING", "value" => "CLOUD COMPUTING"),
    array("label" => "DATA MINING", "value" => "DATA MINING"),
    array("label" => "DATA WAREHOUSE", "value" => "DATA WAREHOUSE"),
    array("label" => "E-COMMERCE", "value" => "E-COMMERCE"),
    array("label" => "DBMS", "value" => "DBMS"),
    array("label" => "HTTP", "value" => "HTTP")

);

$result = array();
foreach ($companies as $company) {
    $companyLabel = $company["label"];
    if (strpos(strtoupper($companyLabel), strtoupper($term)) !== false) {
        array_push($result, $company);
    }
}

echo json_encode($result);
?>