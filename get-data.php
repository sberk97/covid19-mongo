<!DOCTYPE html>
<html>
<head>
<style>
table {
  width: 100%;
  border-collapse: collapse;
}

table, td, th {
  border: 1px solid black;
  padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
$fieldNames = array("fips", "admin2", "province-state", "country-region", "last-update", "latitude", "longitude", "confirmed", "deaths", "recovered", "active", "combined-key", "incidence-rate", "case-fatality-ratio");
$fieldNamesInTable = array("FIPS", "Admin2", "Province State", "Country Region", "Last Update", "Latitude", "Longitude", "Confirmed", "Deaths", "Recovered", "Active", "Combined Key", "Incidence Rate", "Case-Fatality ratio");

$table = "<table><tr>";

function connectWithDb() {
  $host="mongo:27017";
  $manager = new MongoDB\Driver\Manager("mongodb://$host");
  return $manager;
}

function createFilter() {
  global $fieldNames;
  global $fieldNamesInTable;
  global $table;
  $filter = [];
  $i = 0;
  foreach ($fieldNames as $field) {
    if (!isset($_POST[$field . "-exists"]) && !empty($_POST[$field])) {
      $filter[$field] = buildFilterForField($field);
    } else if(isset($_POST[$field . "-exists"])) {
      $filter[$field] = ['$exists' => false];
    } else if (isset($_POST[$field . "-notempty"])) {
      $filter[$field] = ['$exists' => true];
    }
    if (isset($_POST[$field . "-display"])) {
      $table .= "<th>" . $fieldNamesInTable[$i] . "</th>";
    }
    $i++;
  }
  $table .= "</tr>";
  return $filter;
}

function buildFilterForField($field) {
  if($field == "last-update") {
    $givenDate = new DateTime($_POST[$field]);
    $nextDay = clone $givenDate;
    $nextDay->add(new DateInterval('P1D'));
    $givenDateMongoDB = new MongoDB\BSON\UTCDateTime($givenDate->getTimestamp()*1000);
    $nextDayMongoDB = new MongoDB\BSON\UTCDateTime($nextDay->getTimestamp()*1000);
    return ['$gte' => $givenDateMongoDB, '$lt' => $nextDayMongoDB];
  }
  return $_POST[$field];
}

function createOptions() {
  $options = [];
  $projection = createProjection();
  $sort = createSort();
  if(!empty($projection)) {
    $options['projection'] = $projection;
  }
  if(!empty($sort)) {
    $options['sort'] = $sort;
  }
  if(!empty($_POST['limit']) && $_POST['limit'] >= 0) {
    $options['limit'] = $_POST['limit'];
  }
  if(!empty($_POST['skip']) && $_POST['skip'] >= 0) {
    $options['skip'] = $_POST['skip'];
  }
  return $options;
}

function createProjection() {
  global $fieldNames;
  $projection = ["_id" => 0];
  foreach ($fieldNames as $field) {
    if (!isset($_POST[$field . "-exists"]) && !isset($_POST[$field . "-display"])) {
      $projection[$field] = 0;
    }
  }
  return $projection;
}

function createSort() {
  $sort = [];
  $howToSort = $_POST['asc-desc'] == "ascending" ? 1 : -1;
  if (!empty($_POST['sort-by'])) {
      $sort[$_POST['sort-by']] = $howToSort;
  }
  return $sort;
}

function returnTable($cursor) {
global $table;
global $fieldNames;
echo $table;

foreach ( $cursor as $r ) {
  echo "<tr>";
  foreach ($fieldNames as $field) {
    if(isset($_POST[$field . "-display"])) {
      if($field == "last-update") {
        echo "<td>" . ($r -> {$field}) -> toDateTime() -> format('d-m-Y\ H:i:s') . "</td>";
      } else {
        echo "<td>" . $r -> {$field} . "</td>";
      }
    }
  }
  echo "</tr>";
}
echo "</table>";
}

try {
    $manager = connectWithDb();
    if ($manager) {
      $query = new MongoDB\Driver\Query(createFilter(), createOptions());
      $dbname="covid19.covid19";
      $cursor = $manager->executeQuery($dbname, $query);
      
      returnTable($cursor);
    }
} catch(Exception $e){
    echo "<h1>Failed to connect with database</h1>";
    print_r($e);
    exit;
}
?>
</body>
</html>