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
    <?php require 'field-settings.php';
    
    foreach ($fieldNamesWithSettings as $fieldName => $settings) {
      echo "<input id='$fieldName' type='checkbox' name='column-checkbox'/><label for='$fieldName'>" . $settings["on-screen"] . "</label>";
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
    foreach ($fieldNamesWithSettings as $fieldName => $settings) {
      $fieldhtml = "<div id='$fieldName-div' style='display:none;'>";
      $fieldhtml .= "<label for='$fieldName'>" . $settings["on-screen"] . ":</label><input type='" . $settings["input-type"] . "' id='$fieldName-input' name='$fieldName' disabled>";
      
      if ($settings["display"]) {
        $fieldhtml .= "<label for='$fieldName-display'>Display?</label><input id='$fieldName-display' name='$fieldName-display' type='checkbox' disabled checked/>";
      }

      if ($settings["exists"]) {
        $fieldhtml .= "<label for='$fieldName-exists'>Should not exists?</label><input id='$fieldName-exists' name='$fieldName-exists' type='checkbox' disabled />";
      }

      if ($settings["not-empty"]) {
        $fieldhtml .= "<label for='$fieldName-notempty'>Should not be empty?</label><input id='$fieldName-notempty' name='$fieldName-notempty' type='checkbox' disabled />";
      }

      if ($settings["advanced"]) {
        $fieldhtml .= "<label for='$fieldName-advanced'>Advanced query?</label><input id='$fieldName-advanced' name='$fieldName-advanced' type='checkbox' disabled/>";
        $fieldhtml .= "<div id='$fieldName-advanced-div' style='display:none;'>
          <label for='$fieldName-advanced-gt'>Greater than:</label>
          <input type='number' id='$fieldName-advanced-gt-input' name='$fieldName-advanced-gt'>
          <label for='$fieldName-advanced-lt'>Less than:</label>
          <input type='number' id='$fieldName-advanced-lt-input' name='$fieldName-advanced-lt'>
        </div>";
      }
      
      $fieldhtml .= "</div>";

      echo $fieldhtml;
    }
    ?>
    <div>
      <label for="sort-by">Sort by:</label>
      <select name="sort-by" id="sort-by">
        <option hidden disabled selected value> -- select an option -- </option>
        <?php
          foreach ($fieldNamesWithSettings as $fieldName => $settings) {
            echo "<option value='$fieldName' disabled>" . $settings["on-screen"] . "</option>";
          }
        ?>
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