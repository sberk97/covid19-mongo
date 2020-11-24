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
    <h1>COVID-19 Cases Database</h1>
    <p>Pick columns that you want to query by</p>
    <p>Display? - If you want to query by that column but don't want to see it in the results</p>
    <p>Should not exists? - If this column shouldn't exists in the record</p>
    <p>Advanced query? - If you want to query numerical values with "greater than" and "less than"</p>
    <p>Leave empty input if you don't want to query by its value</p>
    <!-- <form id="covid-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  -->

    <form id="covid-form"> 
    <div id="fips-div" style="display:none;" method="post">
      <label for="fips">FIPS:</label>
      <input type="number" id="fips-input" name="fips">
      <label for="fips-display">Display?</label><input id="fips-display" type="checkbox" name="fips-display" checked/>
      <label for="fips-exists">Should not exists?</label><input id="fips-exists" name="fips-exists" type="checkbox" />
    </div>
    <div id="admin2-div" style="display:none;">
      <label for="admin2">Admin2:</label>
      <input type="text" id="admin2-input" name="admin2">
      <label for="admin2-display">Display?</label><input id="admin2-display" type="checkbox" checked/>
      <label for="admin2-exists">Should not exists?</label><input id="admin2-exists" type="checkbox" />
    </div>
    <div id="province-state-div" style="display:none;">
      <label for="province-state">Province State:</label>
      <input type="text" id="province-state-input" name="province-state">
      <label for="province-state-display">Display?</label><input id="province-state-display" type="checkbox" checked/>
      <label for="province-state-exists">Should not exists?</label><input id="province-state-exists" type="checkbox" />
    </div>
    <div id="country-region-div" style="display:none;">
      <label for="country-region">Country Region:</label>
      <input type="text" id="country-region-input" name="country-region">
      <label for="country-region-display">Display?</label><input id="country-region-display" type="checkbox" checked/>
      <label for="country-region-exists">Should not exists?</label><input id="country-region-exists" type="checkbox" />
    </div>
    <div id="last-update-div" style="display:none;">
      <label for="last-update">Last Update:</label>
      <input type="date" id="last-update-input" name="last-update-region">
      <label for="last-update-display">Display?</label><input id="last-update-display" type="checkbox" checked/>
      <label for="last-update-exists">Should not exists?</label><input id="last-update-exists" type="checkbox" />
    </div>
    <div id="latitude-div" style="display:none;">
      <label for="latitude">Latitude:</label>
      <input type="number" id="latitude-input" name="latitude">
      <label for="latitude-display">Display?</label><input id="latitude-display" type="checkbox" checked/>
      <label for="latitude-exists">Should not exists?</label><input id="latitude-exists" type="checkbox" />
    </div>
    <div id="longitude-div" style="display:none;">
      <label for="longitude">Longitude:</label>
      <input type="number" id="longitude-input" name="longitude">
      <label for="longitude-display">Display?</label><input id="longitude-display" type="checkbox" checked/>
      <label for="longitude-exists">Should not exists?</label><input id="longitude-exists" type="checkbox" />
    </div>
    <div id="confirmed-div" style="display:none;">
      <label for="confirmed">Confirmed:</label>
      <input type="number" id="confirmed-input" name="confirmed">
      <label for="confirmed-display">Display?</label><input id="confirmed-display" type="checkbox" checked/>
      <label for="confirmed-exists">Should not exists?</label><input id="confirmed-exists" type="checkbox" />
      <label for="confirmed-advanced">Advanced query?</label><input id="confirmed-advanced" type="checkbox"/>
      <div id="confirmed-advanced-div" style="display:none;">
        <label for="confirmed-gt">Greater than:</label>
        <input type="number" id="confirmed-gt-input" name="confirmed-gt">
        <label for="confirmed-lt">Less than:</label>
        <input type="number" id="confirmed-lt-input" name="confirmed-lt">
      </div>
    </div>
    <div id="deaths-div" style="display:none;">
      <label for="deaths">Deaths:</label>
      <input type="number" id="deaths-input" name="deaths">
      <label for="deaths-display">Display?</label><input id="deaths-display" type="checkbox" checked/>
      <label for="deaths-exists">Should not exists?</label><input id="deaths-exists" type="checkbox" />
      <label for="deaths-advanced">Advanced query?</label><input id="deaths-advanced" type="checkbox"/>
      <div id="deaths-advanced-div" style="display:none;">
        <label for="deaths-gt">Greater than:</label>
        <input type="number" id="deaths-gt-input" name="deaths-gt">
        <label for="deaths-lt">Less than:</label>
        <input type="number" id="deaths-lt-input" name="deaths-lt">
      </div>
    </div>
    <div id="recovered-div" style="display:none;">
      <label for="recovered">Recovered:</label>
      <input type="number" id="recovered-input" name="recovered">
      <label for="recovered-display">Display?</label><input id="recovered-display" type="checkbox" checked/>
      <label for="recovered-exists">Should not exists?</label><input id="recovered-exists" type="checkbox" />
      <label for="recovered-advanced">Advanced query?</label><input id="recovered-advanced" type="checkbox"/>
      <div id="recovered-advanced-div" style="display:none;">
        <label for="recovered-gt">Greater than:</label>
        <input type="number" id="recovered-gt-input" name="recovered-gt">
        <label for="recovered-lt">Less than:</label>
        <input type="number" id="recovered-lt-input" name="recovered-lt">
      </div>
    </div>
    <div id="active-div" style="display:none;">
      <label for="active">Active:</label>
      <input type="number" id="active-input" name="active">
      <label for="active-display">Display?</label><input id="active-display" type="checkbox" checked/>
      <label for="active-exists">Should not exists?</label><input id="active-exists" type="checkbox" />
      <label for="active-advanced">Advanced query?</label><input id="active-advanced" type="checkbox"/>
      <div id="active-advanced-div" style="display:none;">
        <label for="active-gt">Greater than:</label>
        <input type="number" id="active-gt-input" name="active-gt">
        <label for="active-lt">Less than:</label>
        <input type="number" id="active-lt-input" name="active-lt">
      </div>
    </div>
    <div id="combined-key-div" style="display:none;">
      <label for="combined-key">Combined Key:</label>
      <input type="text" id="combined-key-input" name="combined-key">
      <label for="combined-key-display">Display?</label><input id="combined-key-display" type="checkbox" checked/>
      <label for="combined-key-exists">Should not exists?</label><input id="combined-key-exists" type="checkbox" />
    </div>
    <div id="incidence-rate-div" style="display:none;">
      <label for="incidence-rate">Incidence Rate:</label>
      <input type="number" id="incidence-rate-input" name="incidence-rate">
      <label for="incidence-rate-display">Display?</label><input id="incidence-rate-display" type="checkbox" checked/>
      <label for="incidence-rate-exists">Should not exists?</label><input id="incidence-rate-exists" type="checkbox" />
      <label for="incidence-rate-advanced">Advanced query?</label><input id="incidence-rate-advanced" type="checkbox"/>
      <div id="incidence-rate-advanced-div" style="display:none;">
        <label for="incidence-rate-gt">Greater than:</label>
        <input type="number" id="incidence-rate-gt-input" name="incidence-rate-gt">
        <label for="incidence-rate-lt">Less than:</label>
        <input type="number" id="incidence-rate-lt-input" name="incidence-rate-lt">
      </div>
    </div>
    <div id="case-fatality-ratio-div" style="display:none;">
      <label for="case-fatality-ratio">Case-Fatality ratio:</label>
      <input type="number" id="case-fatality-ratio-input" name="case-fatality-ratio">
      <label for="case-fatality-ratio-display">Display?</label><input id="case-fatality-ratio-display" type="checkbox" checked/>
      <label for="case-fatality-ratio-exists">Should not exists?</label><input id="case-fatality-ratio-exists" type="checkbox" />
      <label for="case-fatality-ratio-advanced">Advanced query?</label><input id="case-fatality-ratio-advanced" type="checkbox"/>
      <div id="case-fatality-ratio-advanced-div" style="display:none;">
        <label for="case-fatality-ratio-gt">Greater than:</label>
        <input type="number" id="case-fatality-ratio-gt-input" name="case-fatality-ratio-gt">
        <label for="case-fatality-ratio-lt">Less than:</label>
        <input type="number" id="case-fatality-ratio-lt-input" name="case-fatality-ratio-lt">
      </div>
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
    <div>
      <p>Leave 0 if you don't want to limit/skip anything</p>
      <label for="limit">Limit:</label>
      <input type="number" id="limit-input" name="limit" value="0"><br>
      <label for="skip">Skip:</label>
      <input type="number" id="skip-input" name="skip" value="0">
    </div>
    <div>
      <button id="submit-btn" type="submit" value="submit">SUBMIT</button>
      <button id="reset-btn" type="reset" value="reset">Reset form</button>
    </div>
    </form>
    <div id="txtHint"><b>Person info will be listed here...</b></div>
  </div>
</body>
</html>