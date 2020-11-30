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
  foreach ($fieldNamesWithSettings as $fieldName => $settings) {
    if (isset($_POST[$fieldName . "-advanced"])) {
      $filter[$fieldName] = buildAdvancedFilterForField($fieldName, $settings["input-type"]);
    } else if (!isset($_POST[$fieldName . "-exists"]) && !empty($_POST[$fieldName])) {
      $filter[$fieldName] = buildFilterForField($_POST[$fieldName], $settings["input-type"]);
    } else if(isset($_POST[$fieldName . "-exists"])) {
      $filter[$fieldName] = ['$exists' => false];
    } else if (isset($_POST[$fieldName . "-notempty"])) {
      $filter[$fieldName] = ['$exists' => true];
    }
    if (isset($_POST[$fieldName . "-display"])) {
      $table .= "<th>" . $settings["on-screen"] . "</th>";
    }
  }
  $table .= "</tr>";
  return $filter;
}

function buildFilterForField($value, $inputType) {
  if (strpos($value, ",") !== false) {
    $values = explode(",", trim($value));
    for ($i=0; $i < count($values); $i++) { 
      $values[$i] = trim($values[$i]);
      $values[$i] = prepareValueForSearch($values[$i], $settings["input-type"]);
    }
    return ['$in' => $values];
  } else if($inputType == "date") {
    $nextDay = new DateTime($value);
    $nextDay->add(new DateInterval('P1D'));
    $givenDateMongoDB = prepareValueForSearch($value, $settings["input-type"]);
    $nextDayMongoDB = new MongoDB\BSON\UTCDateTime($nextDay->getTimestamp()*1000);
    return ['$gte' => $givenDateMongoDB, '$lt' => $nextDayMongoDB];
  } else {
    return prepareValueForSearch($value, $settings["input-type"]);
  }
}

function buildAdvancedFilterForField($fieldName, $inputType) {
  $gtValue = $_POST[$fieldName . "-advanced-gt"];
  $ltValue = $_POST[$fieldName . "-advanced-lt"];

  if (!empty($gtValue)) {
    $advancedArray['$gt'] = prepareValueForSearch($gtValue, $inputType);
  }
  if (!empty($ltValue)) {
    $advancedArray['$lt'] = prepareValueForSearch($ltValue, $inputType);
  }
  return $advancedArray;
}

function prepareValueForSearch($value, $inputType) {
  if ($inputType == "date") {
    $date = new DateTime($value);
    return new MongoDB\BSON\UTCDateTime($date->getTimestamp()*1000);
  } else if ($inputType == "number") {
    return (double) $value;
  }
  return $value;
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
        $value = $r -> {$fieldName};
        echo "<td>" . prepareValueToDisplay($value, $settings["input-type"]) . "</td>";
      }
    }
    echo "</tr>";
  }
  echo "</table>";
}

function prepareValueToDisplay($value, $inputType) {
  if ($inputType == "date") {
    return $value -> toDateTime() -> format('d-m-Y\ H:i:s');
  }

  return $value;
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