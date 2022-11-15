<?php
session_start();
if (isset($_SESSION['loggedin'])) {
	$logButton = 'href="account/logout.php">Logout';
}
else {
	$logButton = 'href="account/login.php">Login';
}
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

		<nav> <!--TODO: Populate this list from the categories defined by the admins-->
			<ul>
				<?php
					$server = 'mysql';
					$username = 'student';
					$password = 'student';
					$schema = 'ibuy';
					$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
					$stmt = $pdo->prepare('SELECT * FROM categories');
					$stmt->execute();
					$cats = $stmt->fetchAll();
					foreach ($cats as &$cat) {
						echo '<li><a class="categoryLink" href="../index.php?pageHeading='. urlencode($cat['category_name']) .'">'. $cat['category_name'] .'</a></li>';
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
			&copy; ibuy <?php echo date('Y')?>
		</footer>
        </main>
	</body>
</html>