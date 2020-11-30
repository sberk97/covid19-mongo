<?php
$fieldNamesWithSettings = [
    "fips" => [
      "display" => true,
      "exists" => true,
      "not-empty" => true,
      "advanced" => false,
      "on-screen" => "FIPS",
      "input-type" => "number"
    ],
    "admin2" => [
      "display" => true,
      "exists" => true,
      "not-empty" => true,
      "advanced" => false,
      "on-screen" => "Admin2",
      "input-type" => "text"
    ], 
    "province-state" => [
      "display" => true,
      "exists" => true,
      "not-empty" => true,
      "advanced" => false,
      "on-screen" => "Province State",
      "input-type" => "text"
    ], 
    "country-region" => [
      "display" => true,
      "exists" => true,
      "not-empty" => true,
      "advanced" => false,
      "on-screen" => "Country Region",
      "input-type" => "text"
    ], 
    "last-update" => [
      "display" => true,
      "exists" => true,
      "not-empty" => true,
      "advanced" => false,
      "on-screen" => "Last Update",
      "input-type" => "date"
    ],    
    "latitude" => [
      "display" => true,
      "exists" => true,
      "not-empty" => true,
      "advanced" => false,
      "on-screen" => "Latitude",
      "input-type" => "number",
      "is-double" => true
    ], 
    "longitude" => [
      "display" => true,
      "exists" => true,
      "not-empty" => true,
      "advanced" => false,
      "on-screen" => "Longitude",
      "input-type" => "number",
      "is-double" => true
    ], 
    "confirmed" => [
      "display" => true,
      "exists" => true,
      "not-empty" => true,
      "advanced" => true,
      "on-screen" => "Confirmed",
      "input-type" => "number"
    ], 
    "deaths" => [
      "display" => true,
      "exists" => true,
      "not-empty" => true,
      "advanced" => true,
      "on-screen" => "Deaths",
      "input-type" => "number"
    ], 
    "recovered" => [
      "display" => true,
      "exists" => true,
      "not-empty" => true,
      "advanced" => true,
      "on-screen" => "Recovered",
      "input-type" => "number"
    ], 
    "active" => [
      "display" => true,
      "exists" => true,
      "not-empty" => true,
      "advanced" => true,
      "on-screen" => "Active",
      "input-type" => "number"
    ], 
    "combined-key" => [
      "display" => true,
      "exists" => true,
      "not-empty" => true,
      "advanced" => false,
      "on-screen" => "Combined Key",
      "input-type" => "text"
    ], 
    "incidence-rate" => [
      "display" => true,
      "exists" => true,
      "not-empty" => true,
      "advanced" => true,
      "on-screen" => "Incidence Rate",
      "input-type" => "number",
      "is-double" => true
    ], 
    "case-fatality-ratio" => [
      "display" => true,
      "exists" => true,
      "not-empty" => true,
      "advanced" => true,
      "on-screen" => "Case-Fatality ratio",
      "input-type" => "number",
      "is-double" => true
    ],
  ];
?>