<!DOCTYPE html>
<html>
	<head>
		<title>
            <?php
                echo $pageTitle
            ?>
        </title>
		<link rel="stylesheet" href="assets/ibuy.css" />
	</head>

	<body>
		<header>
			<h1><a href="index.php"><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></a></h1>

			<form action="#">
				<input type="text" name="search" placeholder="Search for anything" />
				<input type="submit" name="submit" value="Search" />
			</form>
		</header>

		<nav> <!--TODO: Populate this list from the categories defined by the admins-->
			<ul>
				<li><a class="categoryLink" href="index.php?pageHeading=Home+%26+Garden">Home &amp; Garden</a></li>
				<li><a class="categoryLink" href="index.php?pageHeading=Electronics">Electronics</a></li>
				<li><a class="categoryLink" href="index.php?pageHeading=Fashion">Fashion</a></li>
				<li><a class="categoryLink" href="index.php?pageHeading=Sport">Sport</a></li>
				<li><a class="categoryLink" href="index.php?pageHeading=Health">Health</a></li>
				<li><a class="categoryLink" href="index.php?pageHeading=Toys">Toys</a></li>
				<li><a class="categoryLink" href="index.php?pageHeading=Motors">Motors</a></li>
				<li><a class="categoryLink" href="categories.php">More</a></li>
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