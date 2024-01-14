<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  // Redirect to the login page if not logged in
  header("Location: login.php");
  exit();
}
include 'utils/functions.php';
if (!is_admin()) {
  header("Location: accessDenied.php");
  exit();
}

// Include the database connection file
include 'utils/db_connection.php';

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
  // Get the event ID from the URL
  $eventID = $_GET['id'];

  // Retrieve the event details from the database
  $selectEventQuery = "SELECT * FROM events WHERE event_id = '$eventID'";
  $eventResult = mysqli_query($conn, $selectEventQuery);

  if (!$eventResult) {
    die("Error executing the event query: " . mysqli_error($conn));
  }

  // Fetch event details
  $event = mysqli_fetch_assoc($eventResult);

  // Retrieve the list of registered users for the event
  $selectUsersQuery = "
    SELECT users.user_id, users.username, users.email, users.user_img
    FROM users
    JOIN registrations ON users.user_id = registrations.user_id
    WHERE registrations.event_id = '$eventID'
  ";
  $usersResult = mysqli_query($conn, $selectUsersQuery);

  if (!$usersResult) {
    die("Error executing the users query: " . mysqli_error($conn));
  }

  // Fetch and display event details and registered users
  $users = mysqli_fetch_all($usersResult, MYSQLI_ASSOC);
} else {
  // Redirect to the index page if 'id' parameter is not set
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Dashboard</title>
  <link rel="stylesheet" type="text/css" href="styles/globals.css">
  <style>
    body {
  font-family: 'Arial', sans-serif;
  background-color: #f5f5f5;
  margin: 0;
  padding: 0;
}

main {
  max-width: 800px;
  margin: 20px auto;
  padding: 20px;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
  text-align: center;
  color: #294b6f;
}



div {
  margin-bottom: 20px;
}

div img {
  display: block;
  margin: 0 auto;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th, td {
  padding: 10px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #007BFF;
  color: #fff;
}

td img {
  border-radius: 50%;
}

p {
  color: #777;
}


  </style>
  <?php include 'utils/config.php'; ?>
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo $googleMapsApiKey; ?>&callback=initMap"></script>
  <script>
    var map;
    var marker;
    function initMap() {
      // Initialize the map
      map = new google.maps.Map(document.getElementById('map'), {
        center: {
          lat: <?php echo $event['event_latitude']; ?>,
          lng: <?php echo $event['event_longitude']; ?>
        },
        zoom: 15 // You can adjust the zoom level as needed
      });
      // Add a marker for the event's location
      marker = new google.maps.Marker({
        position: {
          lat: <?php echo $event['event_latitude']; ?>,
          lng: <?php echo $event['event_longitude']; ?>
        },
        map: map,
        title: 'Event Location'
      });
    }
  </script>
</head>

<body>
  <?php require 'layout/header.php'; ?>
  <main>
    <div>
      <div>
        <img src="<?php echo $event['event_img']; ?>" alt="event-img" width="250">
      </div>
      <h1>
        <?php echo '<h2>'.$event['event_name'].'</h2>'; ?>
      </h1>
    </div>

    <!--map details-->
    <!-- <div>
      <p><strong>Categorie:</strong>
        <?php //echo $event['event_type']; ?>
      </p>
      <p><strong>Date:</strong>
        <?php //echo $event['event_date']; ?>
      </p>
    </div>
    <p><strong>Details:</strong>
      <?php //echo $event['event_details']; ?>
    </p>
    <?php
    /*if ($event['event_latitude'] != 0 && $event['event_longitude'] != 0) {
      echo "<div id='map'></div>";
    } else {
      echo "<p>No Location in this event.</p>";
    }*/
    ?> --> 


    <h2>Registered Users:</h2>
    <div>
      <!--<div>
        <h3>User:</h3>
        <h3>Email:</h3>
      </div>-->
      <?php
if (empty($users)) {
  echo "<p>No users registered for this event.</p>";
} else {
  echo "<table>
          <thead>
            <tr>
              <th>User Image</th>
              <th>Username</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>";

  foreach ($users as $user) {
    echo "<tr>
            <td><img src='{$user['user_img']}' alt='User Image' width='30' height='30'></td>
            <td>{$user['username']}</td>
            <td>{$user['email']}</td>
          </tr>";
  }

  echo "</tbody></table>";
}
?>

    </div>
  </main>
  <?php require 'layout/footer.php'; ?>
</body>

</html>