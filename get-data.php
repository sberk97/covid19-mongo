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

<?php
$fips = $_POST['fips'];
$fipsDisplay = isset($_POST['fips-display']);
$fipsExists = isset($_POST['fips-exists']);

$admin2 = $_POST['admin2'];
$admin2Display = isset($_POST['admin2-display']);
$admin2Exists = isset($_POST['admin2-exists']);

$provinceState = $_POST['province-state'];
$provinceStateDisplay = isset($_POST['province-state-display']);
$provinceStateExists = isset($_POST['province-state-exists']);

$countryRegion = $_POST['country-region'];
$countryRegionDisplay = isset($_POST['country-region-display']);
$countryRegionExists = isset($_POST['country-region-exists']);

$lastUpdate = $_POST['last-update']; 
$lastUpdateDisplay = isset($_POST['last-update-display']);
$lastUpdateExists = isset($_POST['last-update-exists']);

$latitude = $_POST['latitude'];
$latitudeDisplay = isset($_POST['latitude-display']);
$latitudeExists = isset($_POST['latitude-exists']);

$longitude = $_POST['longitude'];
$longitudeDisplay = isset($_POST['longitude-display']);
$longitudeExists = isset($_POST['longitude-exists']);

$confirmed = $_POST['confirmed'];
$confirmedDisplay = isset($_POST['confirmed-display']);
$confirmedExists = isset($_POST['confirmed-exists']);

$deaths = $_POST['deaths'];
$deathsDisplay = isset($_POST['deaths-display']);
$deathsExists = isset($_POST['deaths-exists']);

$recovered = $_POST['recovered'];
$recoveredDisplay = isset($_POST['recovered-display']);;
$recoveredExists = isset($_POST['recovered-exists']);

$active = $_POST['active'];
$activeDisplay = isset($_POST['active-display']);
$activeExists = isset($_POST['active-exists']);

$combinedKey = $_POST['combined-key'];
$combinedKeyDisplay = isset($_POST['combined-key-display']);
$combinedKeyExists = isset($_POST['combined-key-exists']);

$incidenceRate = $_POST['incidence-rate'];
$incidenceRateDisplay = isset($_POST['incidence-rate-display']);
$incidenceRateExists = isset($_POST['incidence-rate-exists']);

$caseFatalityRatio = $_POST['case-fatality-ratio'];
$caseFatalityRatioDisplay = isset($_POST['case-fatality-ratio-display']);
$caseFatalityRatioExists = isset($_POST['case-fatality-ratio-exists']);

$sortBy = $_POST['sort-by'];
$ascending = $_POST['asc-desc'];
$limit = $_POST['limit'];
$skip = $_POST['skip'];

echo "FIPS: $fips<br>";
echo "FIPS display: $fipsDisplay<br>";
echo "FIPS exists: $fipsExists<br>";
echo "admin2: $admin2<br>";
echo "admin2 display: $admin2Display<br>";
echo "admin2 exists: $admin2Exists<br>";
echo "provinceState: $provinceState<br>";
echo "provinceState display: $provinceStateDisplay<br>";
echo "provinceState exists: $provinceStateExists<br>";
echo "countryRegion: $countryRegion<br>";
echo "countryRegion display: $countryRegionDisplay<br>";
echo "countryRegion exists: $countryRegionExists<br>";
echo "lastUpdate: $lastUpdate<br>";
echo "lastUpdate display: $lastUpdateDisplay<br>";
echo "lastUpdate exists: $lastUpdateExists<br>";
echo "latitude: $latitude<br>";
echo "latitude display: $latitudeDisplay<br>";
echo "latitude exists: $latitudeExists<br>";
echo "longitude: $longitude<br>";
echo "longitude display: $longitudeDisplay<br>";
echo "longitude exists: $longitudeExists<br>";
echo "confirmed: $confirmed<br>";
echo "confirmed display: $confirmedDisplay<br>";
echo "confirmed exists: $confirmedExists<br>";
echo "deaths: $deaths<br>";
echo "deaths display: $deathsDisplay<br>";
echo "deaths exists: $deathsExists<br>";
echo "recovered: $recovered<br>";
echo "recovered display: $recoveredDisplay<br>";
echo "recovered exists: $recoveredExists<br>";
echo "active: $active<br>";
echo "active display: $activeDisplay<br>";
echo "active exists: $activeExists<br>";
echo "combinedKey: $combinedKey<br>";
echo "combinedKey display: $combinedKeyDisplay<br>";
echo "combinedKey exists: $combinedKeyExists<br>";
echo "incidenceRate: $incidenceRate<br>";
echo "incidenceRate display: $incidenceRateDisplay<br>";
echo "incidenceRate exists: $incidenceRateExists<br>";
echo "caseFatalityRatio: $caseFatalityRatio<br>";
echo "caseFatalityRatio display: $caseFatalityRatioDisplay<br>";
echo "caseFatalityRatio exists: $caseFatalityRatioExists<br>";
echo "Sort by: $sortBy<br>";
echo "Ascending: $ascending<br>";
echo "Limit: $limit<br>";
echo "Skip: $skip<br>";

// foreach (array_keys($_POST) as $field)
// {
//     echo $_POST[$field];
// }
// echo "<table>
// <tr>
// <th>Firstname</th>
// <th>Lastname</th>
// <th>Age</th>
// <th>Hometown</th>
// <th>Job</th>
// </tr>";
// while($row = mysqli_fetch_array($result)) {
//   echo "<tr>";
//   echo "<td>" . $row['FirstName'] . "</td>";
//   echo "<td>" . $row['LastName'] . "</td>";
//   echo "<td>" . $row['Age'] . "</td>";
//   echo "<td>" . $row['Hometown'] . "</td>";
//   echo "<td>" . $row['Job'] . "</td>";
//   echo "</tr>";
// }
// echo "</table>";
// mysqli_close($con);
?>
</body>
</html>