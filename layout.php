<?php
if (isset($_SESSION['loggedin'])) {
	$logButton = 'href="../account/logout.php">Logout';
}
else {
	$logButton = 'href="../account/login.php">Login';
}

require_once 'functions.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<title>
            <?php
                echo $pageTitle
            ?>
        </title>
		<link rel="stylesheet" href="../assets/ibuy.css" />
	</head>

	<body>
		<header>
			<h1><a href="../index.php"><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></a></h1>

			<form action="#">
				<input type="text" name="search" placeholder="Search for anything" />
				<input type="submit" name="submit" value="Search" />
			</form>

		</header>

		<nav>
			<ul>
				<?php
					$cats = fetchCats();
					foreach ($cats as &$cat) {
						echo '<li><a class="categoryLink" href="../index.php?pageHeading='. urlencode($cat['name']) .'">'. $cat['name'] .'</a></li>';
					}
				?>
				<li><a class="categoryLink" <?php echo $logButton?></a></li>
			</ul>
		</nav>
		<img src="../assets/banners/1.jpg" alt="Banner" />

		<main>
            <?php
                echo $pageContent;
            ?>
        <footer>
			<a style="text-decoration: none;" href="admin/adminCategories.php">admins</a><br>
			&copy; ibuy <?php echo date('Y')?>
		</footer>
        </main>
	</body>
</html>