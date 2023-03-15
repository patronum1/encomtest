<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>My Website</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<style>
	/* Your custom CSS styles */
	.vertical-menu {
	  width: 200px;
	  height: 100%;
	  position: fixed;
	  z-index: 1;
	  top: 0;
	  left: 0;
	  background-color: #f5f5f5;
	  overflow-x: hidden;
	  padding-top: 20px;
	}

	.vertical-menu a {
	  padding: 15px 20px;
	  display: block;
	  font-size: 16px;
	  font-weight: bold;
	  color: #333;
	  text-decoration: none;
	  transition: 0.3s;
	}

	.vertical-menu a:hover {
	  background-color: #ddd;
	  color: #000;
	}

	.vertical-menu .username {
	  font-size: 20px;
	  font-weight: bold;
	  color: #333;
	  padding: 10px 20px;
	  text-align: center;
	}

	.vertical-menu .school {
	  font-size: 16px;
	  color: #666;
	  padding: 10px 20px;
	  text-align: center;
	}
	</style>
</head>
<body>
	<div class="vertical-menu">
		<div class="username"><?php echo $username; ?></div>
		<div class="school"><?php echo $school; ?></div>
        <a href="dashboard.php">Dashboard</a>
        <a href="dashboard2.php">Page 1</a>
        <a href="dashboard3.php">Page 2</a>
        <a href="dashboard4.php">Page 3</a>
        <a href="dashboard5.php">Page 4</a>
        <a href="dashboard6.php">Page 5</a>
        <a href="dashboard7.php">Page 6</a>
        <a href="settings.php">Settings</a>
        <a href="signout.php">Sign Out</a>
	</div>
	<div class="content">
		<!-- Your page content goes here -->
	</div>
</body>
</html>
