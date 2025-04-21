<?php
$error = '';
$catName = $prodName = $prodDesc = $prodShort = $prodPrice = 'Грешен индекс';
$images = array();

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
	try {
		$product = $mysqli->query("SELECT * FROM (SELECT products.product_id, products.product_name, products.product_model, products.product_price, products.product_description, products.short_description, products.name, products.phone, GROUP_CONCAT(DISTINCT categories.category_name) as categories, GROUP_CONCAT(DISTINCT categories.category_id) as categoriesids FROM `products` LEFT JOIN category_products ON category_products.product_id = products.product_id LEFT JOIN categories ON category_products.category_id = categories.category_id WHERE products.product_id=" . $_GET['id'] . ") as main WHERE main.product_id IS NOT NULL");
		if ($product->num_rows > 0) {
			$row = $product->fetch_object();
			$prodId = $row->product_id;
			$categories = $row->categoriesids;
			$catName = str_replace(",", ", ", $row->categories);
			$prodName = $row->product_name;
			$prodModel = $row->product_model;
			$prodDesc = $row->product_description;
			$prodShort = $row->short_description;
			$prodPrice = $row->product_price;
			$freeMontage = (array_search(11, explode(",", $row->categoriesids)) !== false) ? true : false;
			$price = $prodPrice;
			$name = $row->name;
			$phone = $row->phone;
		} else {
			$error = true;
		}
	} catch (Exception $e) {
		echo 'Грешка: ', $e->getMessage(), "\n";
	}

	try {
		$imagesSql =  $mysqli->query("SELECT option_value FROM product_options WHERE option_id = 1 AND product_id=" . $_GET['id']);
		if ($imagesSql->num_rows > 0) {
			$images = $imagesSql->fetch_all(MYSQLI_ASSOC);
		} else {
			$images = array();
		}
	} catch (Exception $e) {
		echo 'Грешка: ', $e->getMessage(), "\n";
	}
} else {
	$error = true;
}
if (!$error) {
?>
	<!-- Start Cat Area -->
	<?php
	if (isMobile()) {
	?>
		<!-- Start Product -->
		<section>
			<div class="container mb-3">
				<div class="row">
					<div class="col-12">
						<div class="row">
							<div class="col-12 mb-2 text-left">
								<h3 class="ff-rb mt-1 fz-22x"><?= $prodName ?></h3>
								<h5 class="ff-rb"><?= $prodModel ?></h5>
								<p><i class="fas fa-user-alt mt-2"></i><?= $name ?></p>
								<p><i class="fas fa-phone"></i><?= $phone ?></p>
							</div>
							<div class="col-12">
								<div id="product-page-pics" class="carousel slide" data-ride="carousel">
									<div class="row">
										<div class="col-12">
											<div class="carousel-inner">
												<?php
												if ($images) {
													foreach ($images as $key => $image) {
												?>
														<div class="carousel-item <?= ($key == 0) ? 'active' : '' ?>">
															<img src="assets/images/product/<?= $image['option_value'] ?>" alt="">
														</div>
												<?php
													}
												}
												?>
											</div>
											<a class="carousel-control-prev" href="#car-pics-auction" data-slide="prev">
												<span class="carousel-control-prev-icon"></span>
											</a>
											<a class="carousel-control-next" href="#car-pics-auction" data-slide="next">
												<span class="carousel-control-next-icon"></span>
											</a>
										</div>
										<div class="col-12 dsp-n">
											<ol class="carousel-indicators list-inline m-0">
												<?php
												if ($images) {
													foreach ($images as $key => $image) {
												?>
														<li class="list-inline-item">
															<a id="carousel-selector-<?= $key ?>" data-slide-to="<?= $key ?>" data-target="#product-images"><img src="assets/images/product/<?= $image['option_value'] ?>" class="img-fluid" alt="Pic title"></a>
														</li>
												<?php
													}
												}
												?>
											</ol>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12">
						<div class="row mb-1">
							<div class="col-12 product-short-info ff-rl text-left">
								<?= $prodShort ?>
							</div>
						</div>
						<div class="row mb-1 product-pw">
							<div class="col-12 col-md-6 mb-1 text-center">
								Цена:<span class="price ff-rb"><?= number_format($prodPrice, 2, ',', ' ') ?> лв.</span>
							</div>
						</div>
						<div class="row mb-1 pt-1 product-pw bt-1dg">
							<div class="col-6 mb-1 text-left">
								<?= $prodDesc ?>
							</div>
						</div>
						<div class="row mt-3 mb-3">
							<div class="col-12 mb-1 ff-rb fz-1d15 text-uppercase">
								Описание
							</div>
							<div class="col-12">
								<p class="ff-rl mb-1">
									<?= $prodDesc ?>
								</p>
							</div>
						</div>
						<div class="row mb-1">
							<div class="col-12 ff-rb text-uppercase">
								Детайли за продукта
							</div>
							<?php
							foreach ($attrs as $vals) {
								if ($vals[0] != 'Бранд') {
							?>
									<div class="col-12 fz-13x">
										<div class="row mx-0 mt-1">
											<div class="col-6 pl-0 mt-1 ff-rb text-left">
												<?= $vals[0] ?>
											</div>
											<div class="col-6 pr-0 mt-1 ff-rl text-right">
												<?= $vals[1] ?>
											</div>
										</div>
									</div>
							<?php
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Product -->
	<?php
	} else {
	?>
		<?php
		$selectCatPr = 	$mysqli->query("SELECT * FROM category_products WHERE product_id = " . $_GET['id'] . "");
		$viewCatPr = mysqli_fetch_assoc($selectCatPr);
		$catId = $viewCatPr['category_id'];
		?>
		<section>
			<div class="container my-3">
				<div class="row breadcrumbs-top mb-3">
					<div class="col-12">
						<div class="breadcrumb-wrapper">
							<ol class="breadcrumb p-0 mb-0 pl-0">
								<li class="breadcrumb-item ">
									<a href="javascript:history.go(-1)">Оферти</a>
								</li>
								<li class="breadcrumb-item">
									<a href="<?= $core ?>?id=<?= $catId ?>"><?= $catName ?></a>
								</li>
								<li class="breadcrumb-item active">
									<?= $prodName ?>
									<?= $prodModel ?>
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Cat Area -->

		<!-- Start Product -->
		<section>
			<div class="container mb-3">
				<div class="row">
					<div class="col-12 col-md-6">
						<div class="row">
							<div class="col-12">
								<div id="product-page-pics" class="carousel slide" data-ride="carousel">
									<div class="row">
										<div class="col-12">
											<div class="carousel-inner">
												<?php
												if ($images) {
													foreach ($images as $key => $image) {
												?>
														<div class="carousel-item <?= ($key == 0) ? 'active' : '' ?>">
															<img src="assets/images/product/<?= $image['option_value'] ?>" alt="">
														</div>
												<?php
													}
												}
												?>
											</div>
											<a class="carousel-control-prev" href="#product-images" data-slide="prev">
												<span class="carousel-control-prev-icon"></span>
											</a>
											<a class="carousel-control-next" href="#product-images" data-slide="next">
												<span class="carousel-control-next-icon"></span>
											</a>
										</div>
										<div class="col-12">
											<ol class="carousel-indicators list-inline m-0">
												<?php
												if ($images) {
													foreach ($images as $key => $image) {
												?>
														<li class="list-inline-item">
															<a id="carousel-selector-<?= $key ?>" data-slide-to="<?= $key ?>" data-target="#product-images"><img src="assets/images/product/<?= $image['option_value'] ?>" class="img-fluid" alt="Pic title"></a>
														</li>
												<?php
													}
												}
												?>
											</ol>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="row mb-3">
							<div class="col-12 mb-2 text-left">
								<h3 class="ff-rb mt-1"><?= $prodName ?></h3>
								<h5 class="ff-rb"><?= $prodModel ?></h5>
								<p><i class="fas fa-user-alt pt-2 pr-1"></i><?= $name ?></p>
								<p><i class="fas fa-phone pt-1 pr-1"></i><?= $phone ?></p>
							</div>
							<div class="col-12 product-short-info ff-rl text-left">
								<?= $prodShort ?>
							</div>
						</div>
						<div class="row mb-1 product-pw">
							<div class="col-12 col-md-6 mb-1 text-left">
								Цена: <span class="price ff-rb"><?= number_format($prodPrice, 2, ',', ' ') ?> лв.</span>
							</div>
						</div>
						<div class="row mb-1 pt-1 product-pw bt-1dg">
							<div class="col-12 col-md-3 mb-1 text-left"></div>
							<div class="col-12 col-md-6 mb-1 clearfix"></div>
						</div>
						<div class="row mb-1">
							<div class="col-12 ff-rb fz-1d15 text-uppercase">
								Детайли за продукта
							</div>
							<div class="p-3">
								<?= $prodDesc ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Product -->
	<?php
	}
} else {
	?>
	<section>
		<div class="container my-3">
			<div class="row breadcrumbs-top mb-3">
				<div class="col-12 text-center">
					<h2>Грешни параметри в URL заявката</h2>
				</div>
			</div>
		</div>
	</section>
<?php
}
?>