<!DOCTYPE html>
<html lang="bg">

<head>
	<!-- Meta Tag -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Title Tag  -->
	<title><?= $title ?></title>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="images/favicon.png">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<!-- Magnific Popup -->
	<link rel="stylesheet" href="assets/css/magnific-popup.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="assets/css/fontawesome.all.min.css">
	<!-- Fancybox -->
	<link rel="stylesheet" href="assets/css/jquery.fancybox.min.css">
	<!-- Themify Icons -->
	<link rel="stylesheet" href="assets/css/themify-icons.css">
	<!-- Nice Select CSS -->
	<link rel="stylesheet" href="assets/css/niceselect.css">
	<!-- Animate CSS -->
	<link rel="stylesheet" href="assets/css/animate.css">
	<!-- Flex Slider CSS -->
	<link rel="stylesheet" href="assets/css/flex-slider.min.css">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="assets/css/owl-carousel.css">
	<!-- Slicknav -->
	<link rel="stylesheet" href="assets/css/slicknav.min.css">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

	<!-- StyleSheet -->
	<link rel="stylesheet" href="assets/css/reset.css">
	<link rel="stylesheet" href="assets/css/responsive.css">
	<link rel="stylesheet" href="assets/css/style.css">

	<?php
	if (isset($_SESSION["compare"]) && count($_SESSION["compare"]) == 0) unset($_SESSION["compare"]);
	if (isset($_GET['compid']) && is_numeric($_GET['compid'])) {
		$productId = intval($_GET['compid']);
		if (isset($_SESSION["compare"])) {
			if (count($_SESSION["compare"]) < 4 ||  $productId < 0) {
				$ind = array_search(abs($productId), $_SESSION["compare"]);
				if ($ind === false || $productId < 0) {
					if ($productId < 0) {
						unset($_SESSION["compare"][$ind]);
					} else {
						$_SESSION["compare"][] = abs($productId);
					}
				}
			}
		} else {
			$_SESSION["compare"][] = $productId;
		}
	}

	if (isset($_GET['quick_phone'])) {
		$mailMsg .= '<h2>Заявка за обаждане от сайта </h2>';
		$mailMsg .= '<p>Обадете се на телефон: ' . $_GET['quick_phone'] . '</p>';
		$subject = 'Заявка за обаждане от сайта';
		if (sendMail($mail, $adminEmail, $subject, $mailMsg, strip_tags($mailMsg))) {
			$msg = "Благодарим ви! Ще се свържем с вас при първа възможност";
		} else {
			$msg = "Нещо се обърка. Моля свържете се с администратор";
			$success = false;
		}
	}
	if (isMobile()) {
	?>
		<link rel="stylesheet" href="assets/css/style-m.css">
	<?php
	}
	?>
</head>
<?php
try {
	$catArr = array();
	$categories = $dbh->query("SELECT *  FROM categories");
	if ($categories->rowCount() > 0) {
		foreach ($categories as $row) {
			array_push($catArr, $row);
		}
	}
} catch (Exception $e) {
	echo 'Грешка: ', $e->getMessage(), "\n";
}
if (isMobile()) {
?>

	<body>
		<!-- Header -->
		<header class="header shop">
			<!-- Top Navigation Menu -->
			<div class="topnav">
				<div class="topnav-m">
					<a href="javascript:void(0);" class="top-menu-m" onclick="switchMobNav();">
						<img src="assets/images/top-menu-m.png" alt="Top menu">
					</a>
					<span class="top-menu-l"></span>
					<div class="top-menu-u">
						<a href="javascript:void(0);" class="search-bar-top-a" onclick="switchTopSearchBar();">
							<i class="fas fa-search"></i>
						</a>
						<!-- <a href="javascript:void(0);" onclick="switchTopCartItems();" class="top-menu-cart">
							<i class="fas fa-shopping-cart"></i>
							<span class="total-count" id="totalCount"></span>
						</a> -->
					</div>
				</div>
				<div class="search-bar-top">
					<div class="search-bar">
						<form action="<?= $core ?>">
							<input name="q" placeholder="Търсене..." value="<?= (isset($_GET['q']) ? $_GET['q'] : "") ?>" type="search">
							<button class="btnn">Търсене</button>
						</form>
					</div>
				</div>
			</div>
			<!-- <div class="shopping-top-items shopping-item elm-invisible" id="cartMenu">
				<ul class="shopping-list" id="cartItems"></ul>
				<div class="bottom">
					<div class="total ff-rb">
						<span>Общо</span>
						<span class="total-amount" id="totalAmount"></span>
					</div>
					<a href="<?= $core ?>cart" class="btn btn-t p-0">Към вашата количка</a>
				</div>
			</div> -->
			<nav id="m-menu-main" class="m-sidenav-main">
				<ul class="main-menu">
					<li><img src="<?= $core ?>/assets/images/logo.webp" alt=""></li>
					<li><a href="javascript:void(0);" onclick="openMobMainCat();">Категории</a></li>
				</ul>
			</nav>

			<nav id="m-menu-main-category" class="m-sidenav-sub">
				<ul class="main-category">
					<li><a href="<?= $core ?>">Всички категории</a></li>
					<?php
					if (!empty($catArr)) {
						foreach ($catArr as $row) {
					?>
							<li><a href="<?= $core ?>?id=<?= $row['category_id'] ?>"><?= $row['category_name'] ?></a></li>
					<?php
						}
					} else {
						echo '<h3>Няма намерени категории</h3>';
					}
					?>
				</ul>
			</nav>
			<div id="overlay-menu" class="mob-nav-close"></div>
		</header>
		<!--/ End Header -->

		<?php
		if ($msg != "") {
		?>
			<section>
				<div class="row">
					<div class="col-12 col-sm-8">
						<div class="alert alert-<?= ($success) ? "success" : "danger" ?> alert-dismissible fade show" role="alert">
							<?= $msg ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
					</div>
				</div>
			</section>
		<?php
		}
	} else {
		?>
		<body class="js">
			<!-- Header -->
			<header class="header shop">
				<div class="middle-inner">
					<div class="container">
						<div class="row">
							<div class="col-sm-1 col-lg-1 col-md-1 col-12 m-auto">
								<a href="<?= $core ?>"><img src="<?= $core ?>/assets/images/logo.webp" alt=""></a>
							</div>
							<div class="col-sm-2 col-lg-2 col-md-2 col-12">
								<div class="all-category">
									<h3 class="cat-heading fz-1 fw-400 text-uppercase">
										<a href="#"><i class="fas fa-bars fz-2" aria-hidden="true"></i>Категории</a>
									</h3>
									<ul class="main-category dsp-n">
										<li><a href="<?= $core ?>">Всички категории</a></li>
										<?php
										if (!empty($catArr)) {
											foreach ($catArr as $row) {
										?>
												<li><a href="<?= $core ?>?id=<?= $row['category_id'] ?>"><?= $row['category_name'] ?></a></li>
										<?php
											}
										} else {
											echo '<h3>Няма намерени категории</h3>';
										}
										?>
									</ul>
								</div>								
							</div>
							<div class="col-sm-7 col-lg-7 col-md-7 col-12">
								<div class="search-bar-top">
									<div class="search-bar">
										<form action="<?= $core ?>">
											<input name="q" placeholder="Търсене..." value="<?= (isset($_GET['q']) ? $_GET['q'] : "") ?>" type="search">
											<select name="id">
												<option value="0" <?= (isset($_GET['id']) && $_GET['id'] == 0) ? "selected" : "" ?>>Всички категории</option>
												<?php
												if (!empty($catArr)) {
													foreach ($catArr as $row) {
												?>
														<option value="<?= $row['category_id'] ?>" <?= (isset($_GET['id']) && $_GET['id'] == $row['category_id']) ? "selected" : "" ?>><?= $row['category_name'] ?></option>
												<?php
													}
												} else {
													echo '<h3>Няма намерени категории</h3>';
												}
												?>
											</select>
											<button class="btnn">Търсене</button>
										</form>
									</div>
								</div>
							</div>
							<div class="col-sm-2 col-lg-2 col-md-2 col-12">
								<div class="right-bar">
									<a href="<?= $core ?>addproduct" class="btn"><i class="fas fa-plus"></i> Добави</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>
			<!--/ End Header -->
			<?php
			if ($msg != "") {
			?>
				<section>
					<div class="row justify-content-center m-3">
						<div class="col-12 col-sm-8">
							<div class="alert alert-<?= ($success) ? "success" : "danger" ?> alert-dismissible fade show" role="alert">
								<?= $msg ?>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div>
						</div>
					</div>
				</section>
		<?php
			}
		}
		?>