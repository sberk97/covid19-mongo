<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>COVID-19 Database</title>
  <meta name="author" content="Sebastian Berk">
  <link rel="stylesheet" type="text/css" href="styles.css">
  <script src="jquery-3.5.1.min.js"></script>
  <script src="script.js" async defer></script>
</head>
<body>
  <div class="sidenav">
    <div class="column-description">Click to select a column</div>
    <?php
    $fieldNames = array("fips", "admin2", "province-state", "country-region", "last-update", "latitude", "longitude", "confirmed", "deaths", "recovered", "active", "combined-key", "incidence-rate", "case-fatality-ratio");
    $fieldNamesOnScreen = array("FIPS", "Admin2", "Province State", "Country Region", "Last Update", "Latitude", "Longitude", "Confirmed", "Deaths", "Recovered", "Active", "Combined Key", "Incidence Rate", "Case-Fatality ratio");
    
    for ($i=0; $i < count($fieldNames); $i++) { 
      echo "<input id='$fieldNames[$i]' type='checkbox' name='column-checkbox'/><label for='$fieldNames[$i]'>$fieldNamesOnScreen[$i]</label>";
    }
    ?>
    <button class="select-btn" onClick="selectAll();">Select all</button>
    <button class="select-btn" onClick="deselect();">Deselect</button>
  </div>

  <div class="main">
    <h1>COVID-19 Cases Database</h1>
    <p>Pick columns that you want to query by</p>
    <p>Display? - If you want to query by that column but don't want to see it in the results</p>
    <p>Should not exists? - If this column shouldn't exists in the record</p>
    <p>Advanced query? - If you want to query numerical values with "greater than" and "less than"</p>
    <p>Leave empty input if you don't want to query by its value</p>

    <form id="covid-form">
    <?php
    $fieldNamesWithSettings = [
      "fips" => [
        "display" => true,
        "exists" => true,
        "advanced" => false,
        "on-screen" => "FIPS",
        "input-type" => "number"
      ],
      "admin2" => [
        "display" => true,
        "exists" => true,
        "advanced" => false,
        "on-screen" => "Admin2",
        "input-type" => "text"
      ], 
      "province-state" => [
        "display" => true,
        "exists" => true,
        "advanced" => false,
        "on-screen" => "Province State",
        "input-type" => "text"
      ], 
      "country-region" => [
        "display" => true,
        "exists" => true,
        "advanced" => false,
        "on-screen" => "Country Region",
        "input-type" => "text"
      ], 
      "last-update" => [
        "display" => true,
        "exists" => true,
        "advanced" => false,
        "on-screen" => "Last Update",
        "input-type" => "date"
      ],    
      "latitude" => [
        "display" => true,
        "exists" => true,
        "advanced" => false,
        "on-screen" => "Latitude",
        "input-type" => "number"
      ], 
      "longitude" => [
        "display" => true,
        "exists" => true,
        "advanced" => false,
        "on-screen" => "Longitude",
        "input-type" => "number"
      ], 
      "confirmed" => [
        "display" => true,
        "exists" => true,
        "advanced" => true,
        "on-screen" => "Confirmed",
        "input-type" => "number"
      ], 
      "deaths" => [
        "display" => true,
        "exists" => true,
        "advanced" => true,
        "on-screen" => "Deaths",
        "input-type" => "number"
      ], 
      "recovered" => [
        "display" => true,
        "exists" => true,
        "advanced" => true,
        "on-screen" => "Recovered",
        "input-type" => "number"
      ], 
      "active" => [
        "display" => true,
        "exists" => true,
        "advanced" => true,
        "on-screen" => "Active",
        "input-type" => "number"
      ], 
      "combined-key" => [
        "display" => true,
        "exists" => true,
        "advanced" => false,
        "on-screen" => "Combined Key",
        "input-type" => "text"
      ], 
      "incidence-rate" => [
        "display" => true,
        "exists" => true,
        "advanced" => true,
        "on-screen" => "Incidence Rate",
        "input-type" => "number"
      ], 
      "case-fatality-ratio" => [
        "display" => true,
        "exists" => true,
        "advanced" => true,
        "on-screen" => "Case-Fatality ratio",
        "input-type" => "number"
      ],
    ];

    foreach ($fieldNamesWithSettings as $key => $value) {
      $output = "<div id='$key-div' style='display:none;'>";
      $output .= "<label for='$key'>" . $value["on-screen"] . ":</label><input type='" . $value["input-type"] . "' id='$key-input' name='$key' disabled>";
      
      if ($value["display"]) {
        $output .= "<label for='$key-display'>Display?</label><input id='$key-display' name='$key-display' type='checkbox' disabled checked/>";
      }

      if ($value["exists"]) {
        $output .= "<label for='$key-exists'>Should not exists?</label><input id='$key-exists' name='$key-exists' type='checkbox' disabled />";
      }

      if ($value["advanced"]) {
        $output .= "<label for='$key-advanced'>Advanced query?</label><input id='$key-advanced' name='$key-advanced' type='checkbox' disabled/>";
        $output .= "<div id='$key-advanced-div' style='display:none;'>
          <label for='$key-advanced-gt'>Greater than:</label>
          <input type='number' id='$key-advanced-gt-input' name='$key-advanced-gt'>
          <label for='$key-advanced-lt'>Less than:</label>
          <input type='number' id='$key-advanced-lt-input' name='$key-advanced-lt'>
        </div>";
      }
      
      $output .= "</div>";

      echo $output;
    }

    ?>
    <div>
      <label for="sort-by">Sort by:</label>
      <select name="sort-by" id="sort-by">
        <option hidden disabled selected value> -- select an option -- </option>
        <option value="fips">FIPS</option>
        <option value="admin2">Admin2</option>
        <option value="province-state">Province State</option>
        <option value="country-region">Country Region</option>
        <option value="last-update">Last Update</option>
        <option value="latitude">Latitude</option>
        <option value="longitude">Longitude</option>
        <option value="confirmed">Confirmed</option>
        <option value="deaths">Deaths</option>
        <option value="recovered">Recovered</option>
        <option value="active">Active</option>
        <option value="combined-key">Combined Key</option>
        <option value="incidence-rate">Incidence Rate</option>
        <option value="case-fatality-ratio">Case-Fatality Ratio</option>
      </select>
      <input type="radio" id="ascending" name="asc-desc" value="ascending" checked>
      <label for="ascending">Ascending</label>
      <input type="radio" id="descending" name="asc-desc" value="descending">
      <label for="descending">Descending</label>
    </div>
    <div>
      <label for="limit">Limit:</label>
      <input type="number" id="limit-input" name="limit"><br>
      <label for="skip">Skip:</label>
      <input type="number" id="skip-input" name="skip">
    </div>
    <div>
      <button id="submit-btn" type="submit" value="submit">SUBMIT</button>
      <button id="reset-btn" type="reset" value="reset">Reset form</button>
    </div>
    </form>
    <div id="results"><b>Results will display here...</b></div>
  </div>
</body>
</html>