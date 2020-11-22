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
      <input type="number" id="fips-input" name="fips">
      <label for="fips-display">Display?</label><input id="fips-display" type="checkbox" checked/>
      <label for="fips-exists">Should exists?</label><input id="fips-exists" type="checkbox" checked/>
    </div>
    <div id="admin2-div" style="display:none;">
      <label for="admin2">Admin2:</label>
      <input type="text" id="admin2-input" name="admin2">
      <label for="admin2-display">Display?</label><input id="admin2-display" type="checkbox" checked/>
      <label for="admin2-exists">Should exists?</label><input id="admin2-exists" type="checkbox" checked/>
    </div>
    <div id="province-state-div" style="display:none;">
      <label for="province-state">Province State:</label>
      <input type="text" id="province-state-input" name="province-state">
      <label for="province-state-display">Display?</label><input id="province-state-display" type="checkbox" checked/>
      <label for="province-state-exists">Should exists?</label><input id="province-state-exists" type="checkbox" checked/>
    </div>
    <div id="country-region-div" style="display:none;">
      <label for="country-region">Country Region:</label>
      <input type="text" id="country-region-input" name="country-region">
      <label for="country-region-display">Display?</label><input id="country-region-display" type="checkbox" checked/>
      <label for="country-region-exists">Should exists?</label><input id="country-region-exists" type="checkbox" checked/>
    </div>
    <div id="last-update-div" style="display:none;">
      <label for="last-update">Last Update:</label>
      <input type="date" id="last-update-input" name="last-update-region">
      <label for="last-update-display">Display?</label><input id="last-update-display" type="checkbox" checked/>
      <label for="last-update-exists">Should exists?</label><input id="last-update-exists" type="checkbox" checked/>
    </div>
    <div id="latitude-div" style="display:none;">
      <label for="latitude">Latitude:</label>
      <input type="number" id="latitude-input" name="latitude">
      <label for="latitude-display">Display?</label><input id="latitude-display" type="checkbox" checked/>
      <label for="latitude-exists">Should exists?</label><input id="latitude-exists" type="checkbox" checked/>
    </div>
    <div id="longitude-div" style="display:none;">
      <label for="longitude">Longitude:</label>
      <input type="number" id="longitude-input" name="longitude">
      <label for="longitude-display">Display?</label><input id="longitude-display" type="checkbox" checked/>
      <label for="longitude-exists">Should exists?</label><input id="longitude-exists" type="checkbox" checked/>
    </div>
    <div id="confirmed-div" style="display:none;">
      <label for="confirmed">Confirmed:</label>
      <input type="number" id="confirmed-input" name="confirmed">
      <label for="confirmed-display">Display?</label><input id="confirmed-display" type="checkbox" checked/>
      <label for="confirmed-exists">Should exists?</label><input id="confirmed-exists" type="checkbox" checked/>
    </div>
    <div id="deaths-div" style="display:none;">
      <label for="deaths">Deaths:</label>
      <input type="number" id="deaths-input" name="deaths">
      <label for="deaths-display">Display?</label><input id="deaths-display" type="checkbox" checked/>
      <label for="deaths-exists">Should exists?</label><input id="deaths-exists" type="checkbox" checked/>
    </div>
    <div id="recovered-div" style="display:none;">
      <label for="recovered">Recovered:</label>
      <input type="number" id="recovered-input" name="recovered">
      <label for="recovered-display">Display?</label><input id="recovered-display" type="checkbox" checked/>
      <label for="recovered-exists">Should exists?</label><input id="recovered-exists" type="checkbox" checked/>
    </div>
    <div id="active-div" style="display:none;">
      <label for="active">Active:</label>
      <input type="number" id="active-input" name="active">
      <label for="active-display">Display?</label><input id="active-display" type="checkbox" checked/>
      <label for="active-display-exists">Should exists?</label><input id="active-display-exists" type="checkbox" checked/>
    </div>
    <div id="combined-key-div" style="display:none;">
      <label for="combined-key">Combined Key:</label>
      <input type="text" id="combined-key-input" name="combined-key">
      <label for="combined-key-display">Display?</label><input id="combined-key-display" type="checkbox" checked/>
      <label for="combined-key-exists">Should exists?</label><input id="combined-key-exists" type="checkbox" checked/>
    </div>
    <div id="incidence-rate-div" style="display:none;">
      <label for="incidence-rate">Incidence Rate:</label>
      <input type="number" id="incidence-rate-input" name="incidence-rate">
      <label for="incidence-rate-display">Display?</label><input id="incidence-rate-display" type="checkbox" checked/>
      <label for="incidence-rate-exists">Should exists?</label><input id="incidence-rate-exists" type="checkbox" checked/>
    </div>
    <div id="case-fatality-ratio-div" style="display:none;">
      <label for="case-fatality-ratio">Case-Fatality ratio:</label>
      <input type="number" id="case-fatality-ratio-input" name="case-fatality-ratio">
      <label for="case-fatality-ratio-display">Display?</label><input id="case-fatality-ratio-display" type="checkbox" checked/>
      <label for="case-fatality-ratio-exists">Should exists?</label><input id="case-fatality-ratio-exists" type="checkbox" checked/>
    </div>
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
  </div>
</body>
</html>