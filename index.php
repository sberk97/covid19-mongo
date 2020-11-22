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
    <input id="fips" type="checkbox" name="column-checkbox"/><label for="fips">FIPS</label>
    <input id="admin2" type="checkbox" name="column-checkbox"/><label for="admin2">Admin2</label>
    <input id="province-state" type="checkbox" name="column-checkbox"/><label for="province-state">Province State</label>
    <input id="country-region" type="checkbox" name="column-checkbox"/><label for="country-region">Country Region</label>
    <input id="last-update" type="checkbox" name="column-checkbox"/><label for="last-update">Last Update</label>
    <input id="latitude" type="checkbox" name="column-checkbox"/><label for="latitude">Latitude</label>
    <input id="longitude" type="checkbox" name="column-checkbox"/><label for="longitude">Longitude</label>
    <input id="confirmed" type="checkbox" name="column-checkbox"/><label for="confirmed">Confirmed</label>
    <input id="deaths" type="checkbox" name="column-checkbox"/><label for="deaths">Deaths</label>
    <input id="recovered" type="checkbox" name="column-checkbox"/><label for="recovered">Recovered</label>
    <input id="active" type="checkbox" name="column-checkbox"/><label for="active">Active</label>
    <input id="combined-key" type="checkbox" name="column-checkbox"/><label for="combined-key">Combined Key</label>
    <input id="incidence-rate" type="checkbox" name="column-checkbox"/><label for="incidence-rate">Incidence Rate</label>
    <input id="case-fatality-ratio" type="checkbox" name="column-checkbox"/><label for="case-fatality-ratio">Case-Fatality Ratio</label>
    <button class="select-btn" onClick="selectAll();">Select all</button>
    <button class="select-btn" onClick="deselect();">Deselect</button>
  </div>

  <div class="main">
    <div id="fips-div" style="display:none;">
      <label for="fips">FIPS:</label>
      <input type="text" id="fips-input" name="fips">
    </div>
    <div id="admin2-div" style="display:none;">
      <label for="admin2">Admin2:</label>
      <input type="text" id="admin2-input" name="admin2">
    </div>
    <div id="province-state-div" style="display:none;">
      <label for="province-state">Province State:</label>
      <input type="text" id="province-state-input" name="province-state">
    </div>
    <div id="country-region-div" style="display:none;">
      <label for="country-region">Country Region:</label>
      <input type="text" id="country-region-input" name="country-region">
    </div>
    <div id="last-update-div" style="display:none;">
      <label for="last-update">Last Update:</label>
      <input type="text" id="last-update-input" name="last-update-region">
    </div>
    <div id="latitude-div" style="display:none;">
      <label for="latitude">Latitude:</label>
      <input type="text" id="latitude-input" name="latitude">
    </div>
    <div id="longitude-div" style="display:none;">
      <label for="longitude">Longitude:</label>
      <input type="text" id="longitude-input" name="longitude">
    </div>
    <div id="confirmed-div" style="display:none;">
      <label for="confirmed">Confirmed:</label>
      <input type="text" id="confirmed-input" name="confirmed">
    </div>
    <div id="deaths-div" style="display:none;">
      <label for="deaths">Deaths:</label>
      <input type="text" id="deaths-input" name="deaths">
    </div>
    <div id="recovered-div" style="display:none;">
      <label for="recovered">Recovered:</label>
      <input type="text" id="recovered-input" name="recovered">
    </div>
    <div id="active-div" style="display:none;">
      <label for="active">Active:</label>
      <input type="text" id="active-input" name="active">
    </div>
    <div id="combined-key-div" style="display:none;">
      <label for="combined-key">Combined Key:</label>
      <input type="text" id="combined-key-input" name="combined-key">
    </div>
    <div id="incidence-rate-div" style="display:none;">
      <label for="incidence-rate">Incidence Rate:</label>
      <input type="text" id="incidence-rate-input" name="incidence-rate">
    </div>
    <div id="case-fatality-ratio-div" style="display:none;">
      <label for="case-fatality-ratio">Case-Fatality ratio:</label>
      <input type="text" id="case-fatality-ratio-input" name="case-fatality-ratio">
    </div>
  </div>
</body>
</html>

<!-- <?php
print phpinfo();
?> -->