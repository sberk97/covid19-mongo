<!DOCTYPE html>
<html>
<body>

<?php require 'field-settings.php';

$table = "<table><tr>";
$recordDataForMap = [];

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
      $advFilter = buildAdvancedFilterForField($fieldName, $settings["input-type"]);
      if (!empty($advFilter)) {
          $filter[$fieldName] = $advFilter;
      }
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
      $values[$i] = prepareValueForSearch($values[$i], $inputType);
    }
    return ['$in' => $values];
  } else if($inputType == "date") {
    $nextDay = new DateTime($value);
    $nextDay->add(new DateInterval('P1D'));
    $givenDateMongoDB = prepareValueForSearch($value, $inputType);
    $nextDayMongoDB = new MongoDB\BSON\UTCDateTime($nextDay->getTimestamp()*1000);
    return ['$gte' => $givenDateMongoDB, '$lt' => $nextDayMongoDB];
  } else {
    return prepareValueForSearch($value, $inputType);
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
  return (string) $value;
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
    saveRecordDataForMap($r);
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

function saveRecordDataForMap($r) {
  global $recordDataForMap;

  $latitude = $r -> {"latitude"};
  $longitude = $r -> {"longitude"};
  if (!empty($latitude) && !empty($longitude)) {
      $combinedKey = $r -> {"combined-key"};
      if(empty($combinedKey)) {
        $admin2 = $r -> {"admin2"};
        $provinceState = $r -> {"province-state"};
        $countryRegion = $r -> {"country-region"};
        $location = prepareLocationString($admin2, $provinceState, $countryRegion);
      } else {
        $location = $combinedKey;
      }
      $confirmed = $r -> {"confirmed"};
      $deaths = $r -> {"deaths"};
      $recovered = $r -> {"recovered"};
      $recordData = ["latitude" => $latitude, "longitude" => $longitude, "location" => $location, "confirmed" => $confirmed, "deaths" => $deaths, "recovered" => $recovered];
      $recordDataForMap[] = $recordData;
  }
}

function prepareLocationString($admin2, $provinceState, $countryRegion) {
  // string containing ' caused issues
  $admin2 = str_replace("'", " ", $admin2);
  $provinceState = str_replace("'", " ", $provinceState);
  $countryRegion = str_replace("'", " ", $countryRegion);
  return implode(", ", array_filter([$admin2, $provinceState, $countryRegion]));
}

function prepareValueToDisplay($value, $inputType) {
  if ($inputType == "date") {
    return $value -> toDateTime() -> format('d-m-Y\ H:i:s');
  }

  return $value;
}

function returnMap() {
  $mapScript = "
  <div id='mapid'></div>
  <script>
  var mymap = L.map('mapid').setView([0, 0], 1);
  " . createMarkers() . " 
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: 'Map data &copy; <a href=https://www.openstreetmap.org/>OpenStreetMap</a> contributors, <a href=https://creativecommons.org/licenses/by-sa/2.0/>CC-BY-SA</a>, Imagery © <a href=https://www.mapbox.com/>Mapbox</a>',
  maxZoom: 18
  }).addTo(mymap);
  
  </script>";
  echo $mapScript;
}

function createMarkers() {
  global $recordDataForMap;

  $markersString = "";
  $i = 0;
  foreach ($recordDataForMap as $key => $value) {
    $lat = $value['latitude'];
    $long = $value['longitude'];
    $location = $value['location'];
    $confirmed = $value['confirmed'];
    $deaths = $value['deaths'];
    $recovered = $value['recovered'];
    $markersString .= "var marker$i = L.marker(['$lat', '$long']).addTo(mymap);marker$i.bindPopup('";
    $markersString .= "<b>$location</b><br><br>";

    // empty returns True for 0 but I want to display 0 on a map
    if ($confirmed == 0 || !empty($confirmed)) {
      $markersString .= "Confirmed cases: $confirmed<br>";
    }
    if ($deaths == 0 || !empty($deaths)) {
      $markersString .= "Death cases: $deaths<br>";
    }
    if ($recovered == 0 || !empty($recovered)) {
      $markersString .= "Recovered cases: $recovered";
    }

    $markersString .= "');";
    $i++;
    if ($i==200) {
      break; // limit number of markers as it can freeze browser
    }
  }

  return $markersString;
}

try {
    $manager = connectWithDb();
    if ($manager) {
      $query = new MongoDB\Driver\Query(createFilter(), createOptions());
      $dbname="covid19.covid19";
      $cursor = $manager->executeQuery($dbname, $query);
      
      returnTable($cursor);
      if (!empty($recordDataForMap)) {
          returnMap();
      }
    }
} catch(Exception $e){
    echo "<h1>Failed to connect with database</h1>";
    print_r($e);
    exit;
}
?>
</body>
</html>