<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>COVID-19 Database</title>
  <meta name="author" content="Sebastian Berk">
  <link rel="stylesheet" type="text/css" href="app/css/styles.css">
  <script src="app/js/jquery-3.5.1.min.js"></script>
  <script src="app/js/script.js" async defer></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
  integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
  crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
  integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
  crossorigin=""></script>
</head>
<body>
  <div class="sidenav">
    <div class="column-description">Click to select a column</div>
    <?php require 'app/php/field-settings.php';
    
    foreach ($fieldNamesWithSettings as $fieldName => $settings) {
      echo "<input id='$fieldName' type='checkbox' name='column-checkbox'/><label for='$fieldName'>" . $settings["on-screen"] . "</label>";
    }
    ?>
    <button onClick="selectAll();">Select all</button>
    <button onClick="deselect();">Deselect</button>
  </div>

  <div class="main">
    <h1>COVID-19 Cases Database</h1>
    Pick columns from the left menu that you want to search by<br>
    Leave empty input if you don't want to search by its value<br>
    If you want to search multiple values separate them with comma ',' (only for text inputs)<br>
    If you don't pick latitude and longitute or if they are empty map will not be displayed<br>
    Display - If you want to search by that column but don't want to see it in the results<br>
    Should not exists? - If this column shouldn't exists in the record<br>
    Should not be empty? - If this column should have values<br>
    Advanced search? - If you want to search numerical values with "greater than" and "less than"<br>

    <form id="covid-form" style='display:none;'>
      <table>
        <tr id="table-head">
          <th>Field name</th>
          <th>Display</th>
          <th>Should not exists?</th>
          <th>Should not be empty?</th>
          <th>Advanced search?</th>
        </tr>
      <?php
      function insertStep($isDouble) {
        if ($isDouble) {
          return " step='any' ";
        }
      }

      foreach ($fieldNamesWithSettings as $fieldName => $settings) {
        $fieldhtml = "<tr id='$fieldName-tr' style='display:none;'>";
        $fieldhtml .= "<td><label for='$fieldName-form'>" . $settings["on-screen"] . ":</label><input type='" . $settings["input-type"] . "'" . insertStep($settings["is-double"]) . "id='$fieldName-input' name='$fieldName' disabled></td>";
        
        if ($settings["display"]) {
          $fieldhtml .= "<td><input id='$fieldName-display' name='$fieldName-display' type='checkbox' disabled checked/></td>";
        }

        if ($settings["exists"]) {
          $fieldhtml .= "<td><input id='$fieldName-exists' name='$fieldName-exists' type='checkbox' disabled /></td>";
        }

        if ($settings["not-empty"]) {
          $fieldhtml .= "<td><input id='$fieldName-notempty' name='$fieldName-notempty' type='checkbox' disabled /></td>";
        }

        if ($settings["advanced"]) {
          $fieldhtml .= "<td><input id='$fieldName-advanced' name='$fieldName-advanced' type='checkbox' disabled/></td>";
          $fieldhtml .= "<td id='$fieldName-advanced-td' style='display:none;'>
            <div class='justify'>
              <label for='$fieldName-advanced-gt' class='advanced-label'>Greater than:</label>
              <input type='" . $settings["input-type"] . "'" . insertStep($settings["is-double"]) . " id='$fieldName-advanced-gt-input' name='$fieldName-advanced-gt'>
            </div>
            <div class='justify'>
              <label for='$fieldName-advanced-lt' class='advanced-label'>Less than:</label>
              <input type='" . $settings["input-type"] . "'" . insertStep($settings["is-double"]) . " id='$fieldName-advanced-lt-input' name='$fieldName-advanced-lt'>
            </div>
          </td>";
        }
        
        $fieldhtml .= "</tr>";

        echo $fieldhtml;
      }
      ?>
      </table>
      <div class="additional-padding">
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
      <div class="additional-padding">
        <label for="limit">Limit:</label>
        <input type="number" id="limit-input" name="limit">
      </div>
      <div class="additional-padding"> 
        <label for="skip">Skip:&nbsp</label>
        <input type="number" id="skip-input" name="skip">
      </div>
      <div class="form-buttons">
        <button id="submit-btn" type="submit" value="submit">SUBMIT</button>
        <button id="reset-btn" type="reset" value="reset">Reset form</button>
      </div>
    </form>
    <div class="results" id="results"></div>
  </div>
</body>
</html>