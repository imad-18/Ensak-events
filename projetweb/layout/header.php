<header>
  <nav>
    <?php
    require_once 'utils\functions.php';
    echo '<a href="index.php" class="logoo"><img src="images/pnngg.png" ></a>';
    ?>
    <div>
      <ul  style="margin-left: 46em;">
      <?php
      if (is_logged_in() && is_admin()) {
        require_once 'utils/functions.php';
        echo '<li style="flex: none;"><a style="
        display: inline-block;
        padding: 10px 20px;       
        text-decoration: none;
        background-color: rgb(62 124 166); /* Light brown button background color */
        color: #fff;
        border-radius: 4px;
        transition: background-color 0.3s ease-in-out;"
        href = "viewEvents.php"
        onmouseover="this.style.backgroundColor=\'rgb(35 57 72)\'" 
        onmouseout="this.style.backgroundColor=\'rgb(62 124 166)\'"
        >My Events</a></li>';

        echo '<li><a style="
        display: inline-block;
        padding: 10px 20px;
        text-decoration: none;
        background-color: rgb(62 124 166); /* Light brown button background color */
        color: #fff;
        border-radius: 4px;
        transition: background-color 0.3s ease-in-out;" href = "logout.php"
        onmouseover="this.style.backgroundColor=\'rgb(35 57 72)\'" 
        onmouseout="this.style.backgroundColor=\'rgb(62 124 166)\'"
        >Logout</a></li>';

      } else if (is_logged_in()) {
        echo '<li><a style="
        display: inline-block;
        padding: 10px 20px;
        text-decoration: none;
        background-color: rgb(62 124 166); /* Light brown button background color */
        color: #fff;
        border-radius: 4px;
        transition: background-color 0.3s ease-in-out;"
        href = "logout.php"
        onmouseover="this.style.backgroundColor=\'rgb(35 57 72)\'" 
        onmouseout="this.style.backgroundColor=\'rgb(62 124 166)\'"
        >Logout</a></li>';
      } else {
        echo '<li style="margin-left: 7em;"><a id="loggin" style="display: inline-block;
        padding: 10px 20px;
        margin-top: 10px;
        text-decoration: none;
        background-color: rgb(62 124 166); /* Light brown button background color */
        color: #fff;
        border-radius: 4px;
        transition: background-color 0.3s ease-in-out;"
         href="login.php"
         onmouseover="this.style.backgroundColor=\'rgb(35 57 72)\'" 
         onmouseout="this.style.backgroundColor=\'rgb(62 124 166)\'"

         >Login</a></li>';
      }
      echo '</ul>'
      ?>
    </div>
  </nav>
</header>