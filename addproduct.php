<?php
$id = '';
$msg = 'Добавяне на оферта';

if (isset($_POST['editPage'])) {
	$product_categories = (isset($_POST['product_categories'])) ? $_POST['product_categories'] : array();
	$product_name = $_POST['product_name'];
	$product_price = $_POST['product_price'];
	$product_description = mysqli_real_escape_string($mysqli, $_POST['product_description']);
	$short_description = $_POST['short_description'];
	$product_model = $_POST['product_model'];
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$mysqli->query("INSERT INTO products (product_name, product_price, product_description, short_description, product_model, name, phone) VALUES ('$product_name', $product_price, '$product_description', '$short_description', '$product_model', '$name', '$phone')");
	$product_id = $mysqli->insert_id;
	foreach ($product_categories as $value) {
		$mysqli->query("INSERT INTO category_products (category_id, product_id) VALUES (" . $value . ", " . $product_id . ")");
	}

	if (isset($_FILES["uploadfile"])) {
		$filename = $_FILES["uploadfile"]["name"];
		$tempname = $_FILES["uploadfile"]["tmp_name"];
		if ($_FILES['uploadfile']['size'] != 0 && $_FILES['uploadfile']['error'] == 0) {
			$folder = "assets/images/product/" . $filename;
			$mysqli->query("INSERT INTO product_options (product_id, option_id, option_value) VALUES (" . $product_id . ", 1, '$filename')");
			if (move_uploaded_file($tempname, $folder)) {
				$msg = "Офертата е добавена успешно";
			} else {
				$msg = "Нещо се обърка";
			}
		}
	}
}

?>
<div class="content-page">
	<div class="content">
		<div class="container-fluid">
			<div class="row page-title align-items-center">
				<div class="col-12">
					<h4 class="mb-1 mt-0"><a href="products.php"></a><?= $msg ?></h4>
				</div>
			</div>
			<form method="POST" action="" enctype="multipart/form-data">
				<div class="row">
					<div class="col-12 col-sm-6">
						<div class="card">
							<div class="card-body">
								<h4 class="card-title">Детайли</h4>
								<h4 class="mt-1" style="font-size : 14px;padding : 5px;">Наименование<font color="red">*</font>
								</h4>
								<input type="text" name="product_name" value="" class="form-control" required>
								<h4 class="mt-1" style="font-size : 14px;padding : 5px;">Модел</h4>
								<input type="text" name="product_model" value="" class="form-control" required>
								<h4 class="mt-1" style="font-size : 14px;padding : 5px;">Име на продавача</h4>
								<input type="text" name="name" value="" class="form-control" required>
								<h4 class="mt-1" style="font-size : 14px;padding : 5px;">Телефон</h4>
								<input type="text" name="phone" value="" class="form-control" required>
								<div class="d-flex align-items-center justify-content-between my-5">
									<label for="product_price">Цена<font color="red">*</font></label>
									<input type="text" id="product_price" name="product_price" value="0.00" style="width : 100px;" class="form-control" required>
								</div>
								<h5 class="mb-1 mt-0">Категории<font color="red">*</font>
								</h5>
								<?php

								$SelectCategories = $mysqli->query("SELECT * FROM categories");
								if ($SelectCategories->num_rows > 0) {
									while ($viewCategories = $SelectCategories->fetch_assoc()) {
								?>
										<input type="checkbox" name="product_categories[]" value="<?= $viewCategories['category_id'] ?>" /> <?= $viewCategories['category_name'] ?><br />
								<?php
									}
								}
								?>
							</div>
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="card">
							<div class="card-body">
								<h4 class="card-title">Изображение</h4>
								<input class="btn" type="file" name="uploadfile" id="uploadfile" value="" />
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Описание на офертата</h5>
								<textarea class="form-control" id="editor1" class="ckeditor" name="product_description" required></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Анонс на офертата</h5>
								<textarea class="form-control" id="editor2" class="ckeditor" name="short_description" required></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<input type="submit" name="editPage" value="Запис на промените" class="btn btn-primary btn-sm mr-3">
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>