<?php
// Include the database connection file
include 'utils/db_connection.php';

// Retrieve all event types
$selectEventTypeQuery = "SELECT DISTINCT event_type FROM events";
$resultEventType = mysqli_query($conn, $selectEventTypeQuery);

if (!$resultEventType) {
  die("Error executing the query: " . mysqli_error($conn));
}

// Fetch event types
$eventTypes = mysqli_fetch_all($resultEventType, MYSQLI_ASSOC);

// Retrieve all events from the database
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filterEventType = isset($_GET['event_type']) ? $_GET['event_type'] : '';

$selectQuery =
  "SELECT * FROM events
    WHERE (event_name LIKE '%$search%'
    OR event_details LIKE '%$search%')"
  . ($filterEventType ? "AND event_type = '$filterEventType'" : "");
$result = mysqli_query($conn, $selectQuery);

if (!$result) {
  die("Error executing the query: " . mysqli_error($conn));
}

// Fetch and display events
$events = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" type="text/css" href="styles/globals.css">

  
  <!-- Other meta tags and links -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>


  <style>
    /* Add this CSS to style the event cards */

#event-card-ctr{
  display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
}
.event-card {
  width: 300px; /* Adjust the width as needed */
  margin-bottom: 20px;
  box-sizing: border-box;
}

/* Adjust the styling based on your needs */
.event-card > div {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: center;
}

.event-card img {
  max-width: 100%;
  height: auto;
  margin-bottom: 10px;
}

/* Add this CSS to clear the floats and avoid layout issues */
.clearfix::after {
  content: "";
  clear: both;
  display: table;
}


/* Add this CSS for the carousel styling */
.carousel {
  width: 100%;
  max-width: 1200px; /* Adjust the maximum width as needed */
  margin: 0 auto;
}

.carousel img {
  width: 100%;
  height: auto;
}

/*form style*/
/* Add this CSS for styling the form */
form {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #f5f5f5;
}

label {
  display: block;
  margin-bottom: 8px;
  font-weight: bold;
}

input[type="text"],
select {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ddd;
  border-radius: 4px;
  box-sizing: border-box;
}

button {
  background-color: #007BFF;
  color: #fff;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}



  </style>
</head>

<body>
  <?php require 'layout/header.php'; ?>

  <div class="carousel">
    <div><img src="images/amphi_rouge.jpg" alt="Slide 1"></div>
    <div><img src="images/ensak1.jpg" alt="Slide 2"></div>
    <div><img src="images/carr1.jpg" alt="Slide 3"></div>
    <!-- Add more slides as needed -->
  </div>

  <main>
    <!-- Your existing form and event card sections -->
  </main>


  <!-- Slick carousel JavaScript -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <script>
    $(document).ready(function(){
      $('.carousel').slick({
        autoplay: true,
        autoplaySpeed: 3000, // Set the duration for each slide
        dots: true, // Show navigation dots
        arrows: false // Hide navigation arrows
      });
    });
  </script>
  <main>
    <form method="get" action="">
      <input type="text" name="search" placeholder="Search for events..."
        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

      <label for="event_type">Categorie:</label>
      <select id="event_type" name="event_type">
        <option value="">All</option>
        <?php foreach ($eventTypes as $eventType): ?>
          <option value="<?php echo $eventType['event_type']; ?>">
            <?php echo $eventType['event_type']; ?>
          </option>
        <?php endforeach; ?>
      </select>

      <button type="submit">Submit</button>
    </form>

    <div id="event-card-ctr">
      <?php
      if (empty($events)) {
        echo "<p>No events found.</p>";
      } else {
        foreach ($events as $event) {
          echo
            "<div class='event-card'>
              <div>
                <div>
                  <img src='{$event['event_img']}' alt='img' width='250px'>
                </div>
                <h3>{$event['event_name']}</h3>
                <p>Date: {$event['event_date']}</p>
              </div>
              <a href='event.php?id={$event['event_id']}'>
                View More Details
              </a>
            </div>";
        }
      }
      ?>
    </div>
  </main>
  <?php require 'layout/footer.php'; ?>
</body>

<script>
  // Set default value to event_type using JavaScript
  document.getElementById("event_type").value = "<?php echo $filterEventType; ?>";
</script>

</html>