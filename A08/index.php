<?php
include("connect.php");

$aircraftType = isset($_GET['aircraftType']) ? $_GET['aircraftType'] : '';
$airlineName = isset($_GET['airlineName']) ? $_GET['airlineName'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : '';


$flightQuery = "SELECT * FROM flightlogs";

if ($aircraftType != '' || $airlineName != '') {
  $flightQuery = $flightQuery . " WHERE";

  if ($aircraftType != '') {
    $flightQuery = $flightQuery . " aircraftType='$aircraftType'";
  }

  if($aircraftType != '' && $airlineName != ''){
    $flightQuery = $flightQuery . " AND";
  }
  
  if ($airlineName != '') {
    $flightQuery = $flightQuery . " airlineName='$airlineName'";
  }
}

if ($sort != ''){
  $flightQuery = $flightQuery." ORDER BY $sort";

  if($order != ''){
    $flightQuery = $flightQuery." $order";
  }
}

$flightResults = executeQuery($flightQuery);

$aircraftTypeQuery = "SELECT DISTINCT(aircraftType) FROM flightlogs";
$aircraftTypeResults = executeQuery($aircraftTypeQuery);

$airlineNameQuery = "SELECT DISTINCT(airlineName) FROM flightlogs";
$airlineNameResults = executeQuery($airlineNameQuery);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo isset($_GET['aircraftType']) && $_GET['aircraftType'] != '' ? $_GET['aircraftType'] : 'Flight'; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="ICON.ico">
</head>

<body id="body" data-bs-theme="light">
  <div class="container-fluid">
    <div class="row my-5">
      <div class="col-lg-6 col-md-8 col-sm-12 mx-auto">
        <form>
          <div class="card p-4 rounded-5">
            <div class="h6">
              Filter
            </div>
            <div class="row g-3">
              <div class="col-md-6">
                <label for="aircraftTypeSelect" class="form-label">Aircraft Type</label>
                <select id="aircraftTypeSelect" name="aircraftType" class="form-control">
                  <option value="">Any</option>
                  <?php
                  if (mysqli_num_rows($aircraftTypeResults) > 0) {
                    while ($aircraftTypeRow = mysqli_fetch_assoc($aircraftTypeResults)) {
                      ?>
                      <option <?php if ($aircraftType == $aircraftTypeRow['aircraftType']) {echo "selected";}?> 
                        value="<?php echo $aircraftTypeRow['aircraftType'] ?>">
                        <?php echo $aircraftTypeRow['aircraftType'] ?>
                      </option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-6">
                <label for="airlineNameSelect" class="form-label">Airline Name</label>
                <select id="airlineNameSelect" name="airlineName" class="form-control">
                  <option value="">Any</option>
                  <?php
                  if (mysqli_num_rows($airlineNameResults) > 0) {
                    while ($airlineNameRow = mysqli_fetch_assoc($airlineNameResults)) {
                      ?>
                      <option <?php if ($airlineName == $airlineNameRow['airlineName']) {echo "selected";}?> 
                        value="<?php echo $airlineNameRow['airlineName'] ?>">
                        <?php echo $airlineNameRow['airlineName'] ?>
                      </option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-6">
                <label for="sort" class="form-label">Sort By</label>
                <select id="sort" name="sort" class="form-control">
                  <option value="">None</option>
                  <option <?php if ($sort == "departureDatetime") {echo "selected";}?> value="departureDatetime">Departure</option>
                  <option <?php if ($sort == "arrivalDatetime") {echo "selected";}?> value="arrivalDatetime">Arrival</option>
                  <option <?php if ($sort == "flightNumber") {echo "selected";}?> value="flightNumber">Flight Number</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="order" class="form-label">Order</label>
                <select id="order" name="order" class="form-control">
                  <option <?php if ($order == "ASC") {echo "selected";}?> value="ASC">Ascending</option>
                  <option <?php if ($order == "DESC") {echo "selected";}?> value="DESC">Descending</option>
                </select>
              </div>
            </div>
            <div class="text-center mt-4">
              <button class="btn btn-primary" style="width: fit-content">Submit</button>
              <button type="button" class="btn btn-dark" id="btn" onclick="mode()">Mode</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="row my-5">
      <div class="col">
        <div class="card p-4 rounded-5">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Flight Number</th>
                  <th scope="col">Departure Date</th>
                  <th scope="col">Arrival Date</th>
                  <th scope="col">Flight Duration (minutes)</th>
                  <th scope="col">Aircraft Type</th>
                  <th scope="col">Airline Name</th>
                  <th scope="col">Pilot Name</th>
                  <th scope="col">Passenger Count</th>
                  <th scope="col">Ticket Price</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (mysqli_num_rows($flightResults) > 0) {
                  while ($flightRow = mysqli_fetch_assoc($flightResults)) {
                      ?>
                    <tr>
                      <th scope="row"><?php echo $flightRow['flightNumber'] ?></th>
                      <td><?php echo $flightRow['departureDatetime'] ?></td>
                      <td><?php echo $flightRow['arrivalDatetime'] ?></td>
                      <td><?php echo $flightRow['flightDurationMinutes'] ?></td>
                      <td><?php echo $flightRow['aircraftType'] ?></td>
                      <td><?php echo $flightRow['airlineName'] ?></td>
                      <td><?php echo $flightRow['pilotName'] ?></td>
                      <td><?php echo $flightRow['passengerCount'] ?></td>
                      <td><?php echo $flightRow['ticketPrice'] ?></td>
                    </tr>
                    <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <p>&copy; 2024 Vea Avygail. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    function mode() {
      var bodyElement = document.getElementById("body");
      var currentTheme = bodyElement.getAttribute("data-bs-theme");
      var newTheme = currentTheme === "light" ? "dark" : "light";
      bodyElement.setAttribute("data-bs-theme", newTheme);
    }
  </script>
</body>

</html>
