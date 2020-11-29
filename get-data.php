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

<?php require 'field-settings.php';

$table = "<table><tr>";

function connectWithDb() {
  $host="mongo:27017";
  $manager = new MongoDB\Driver\Manager("mongodb://$host");
  return $manager;
}

function createFilter() {
  global $table;
  global $fieldNamesWithSettings;
  $filter = [];
  $i = 0;
  foreach ($fieldNamesWithSettings as $fieldName => $settings) {
    if (!isset($_POST[$fieldName . "-exists"]) && !empty($_POST[$fieldName])) {
      $filter[$fieldName] = buildFilterForField($fieldName);
    } else if(isset($_POST[$fieldName . "-exists"])) {
      $filter[$fieldName] = ['$exists' => false];
    } else if (isset($_POST[$fieldName . "-notempty"])) {
      $filter[$fieldName] = ['$exists' => true];
    }
    if (isset($_POST[$fieldName . "-display"])) {
      $table .= "<th>" . $settings["on-screen"] . "</th>";
    }
    $i++;
  }
  $table .= "</tr>";
  return $filter;
}

function buildFilterForField($fieldName) {
  if($fieldName == "last-update") {
    $givenDate = new DateTime($_POST[$fieldName]);
    $nextDay = clone $givenDate;
    $nextDay->add(new DateInterval('P1D'));
    $givenDateMongoDB = new MongoDB\BSON\UTCDateTime($givenDate->getTimestamp()*1000);
    $nextDayMongoDB = new MongoDB\BSON\UTCDateTime($nextDay->getTimestamp()*1000);
    return ['$gte' => $givenDateMongoDB, '$lt' => $nextDayMongoDB];
  }
  return $_POST[$fieldName];
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
  global $fieldNamesWithSettings;

  $projection = ["_id" => 0];
  foreach ($fieldNamesWithSettings as $fieldName => $settings) {
    if (!isset($_POST[$fieldName . "-exists"]) && !isset($_POST[$fieldName . "-display"])) {
      $projection[$fieldName] = 0;
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
  global $fieldNamesWithSettings;
  global $table;
  echo $table;

  foreach ( $cursor as $r ) {
    echo "<tr>";
    foreach ($fieldNamesWithSettings as $fieldName => $settings) {
      if(isset($_POST[$fieldName . "-display"])) {
        if($fieldName == "last-update") {
          echo "<td>" . ($r -> {$fieldName}) -> toDateTime() -> format('d-m-Y\ H:i:s') . "</td>";
        } else {
          echo "<td>" . $r -> {$fieldName} . "</td>";
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