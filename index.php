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
    <input id="FIPS" type="checkbox" name="column-checkbox"/><label for="FIPS">FIPS</label>
    <input id="Admin2" type="checkbox" name="column-checkbox"/><label for="Admin2">Admin2</label>
    <input id="Province State" type="checkbox" name="column-checkbox"/><label for="Province State">Province State</label>
    <input id="Country Region" type="checkbox" name="column-checkbox"/><label for="Country Region">Country Region</label>
    <input id="Last Update" type="checkbox" name="column-checkbox"/><label for="Last Update">Last Update</label>
    <input id="Latitude" type="checkbox" name="column-checkbox"/><label for="Latitude">Latitude</label>
    <input id="Longitude" type="checkbox" name="column-checkbox"/><label for="Longitude">Longitude</label>
    <input id="Confirmed" type="checkbox" name="column-checkbox"/><label for="Confirmed">Confirmed</label>
    <input id="Deaths" type="checkbox" name="column-checkbox"/><label for="Deaths">Deaths</label>
    <input id="Recovered" type="checkbox" name="column-checkbox"/><label for="Recovered">Recovered</label>
    <input id="Active" type="checkbox" name="column-checkbox"/><label for="Active">Active</label>
    <input id="Combined Key" type="checkbox" name="column-checkbox"/><label for="Combined Key">Combined Key</label>
    <input id="Incidence Rate" type="checkbox" name="column-checkbox"/><label for="Incidence Rate">Incidence Rate</label>
    <input id="Case-Fatality Ratio" type="checkbox" name="column-checkbox"/><label for="Case-Fatality Ratio">Case-Fatality Ratio</label>
    <button class="select-btn" onClick="selectAll();">Select all</button>
    <button class="select-btn" onClick="deselect();">Deselect</button>
  </div>

  <div class="main">
    <h2>Sidenav Example</h2>
    <p>This sidenav is always shown.</p>
  </div>
</body>
</html>

<!-- <?php
print phpinfo();
?> -->