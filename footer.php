<?php
$cartSession = (isset($_SESSION["cart"])) ? $_SESSION["cart"] : "";
try {
	$cartItemsSQL = $mysqli->query("SELECT cart.cart_product_id, cart.cart_session, products.product_name, products.product_price, cart.cart_quantity, product_options.option_value FROM cart
		JOIN products ON cart.cart_product_id = products.product_id
		JOIN product_options ON cart.cart_product_id = product_options.product_id
		WHERE cart.cart_session = '" . trim($cartSession) . "' AND cart.cart_status = 0
		GROUP BY product_options.product_id");
} catch (Exception $e) {
	echo 'Грешка: ', $e->getMessage(), "\n";
}

echo '<script>';
if ($cartItemsSQL->num_rows > 0) {
	$amount = 0;
	$aqqu = '';
	echo 'var cartCount = ' . $cartItemsSQL->num_rows . "\r\n";
	while ($cartItem = $cartItemsSQL->fetch_object()) {
		$currPrice = $cartItem->product_price;
		$amount += $currPrice * $cartItem->cart_quantity;
		$aqqu .= '<li class="no-brd">' . '<a class="cart-img" href="product?id=' . $cartItem->cart_product_id . '"><img src="assets/images/product/' . $cartItem->option_value . '" alt="' . $cartItem->product_name . '"></a>' . '<p><a href="product?id=' . $cartItem->cart_product_id . '" class="ff-rl">' . $cartItem->product_name . '</a></p>' . '<p class="ff-rb">' . $cartItem->cart_quantity . ' x ' . number_format($currPrice, 2, ",", " ") . ' лв.</p></li>';
	}
	echo 'var cartContent = \'' . $aqqu . "'\r\n";
	echo 'var cartAmount = ' . $amount . "\r\n";
?>
	const count = document.getElementById("totalCount")
	const amount = document.getElementById("totalAmount")
	const content = document.getElementById("cartItems")
	count.textContent = cartCount
	amount.textContent = formatMoney(cartAmount) + " лв."
	content.innerHTML = cartContent
<?php
} else {
	echo 'const count = document.getElementById("totalCount")' . "\r\n";
	echo 'count.textContent = 0' . "\r\n";
	echo 'const menu = document.getElementById("cartMenu")' . "\r\n";
	echo 'menu.innerHTML = \'<h5>Няма продукти в количката.</h5> \'' . "\r\n";
}
?>
function formatMoney(number, decPlaces, decSep, thouSep) {
decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
decSep = typeof decSep === "undefined" ? "," : decSep;
thouSep = typeof thouSep === "undefined" ? " " : thouSep;
var sign = number < 0 ? "-" : "" ; var i=String(parseInt(number=Math.abs(Number(number) || 0).toFixed(decPlaces))); var j=(j=i.length)> 3 ? j % 3 : 0;

	return sign +
	(j ? i.substr(0, j) + thouSep : "") +
	i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
	(decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
	}
	</script>

	<script>
		function BnplChangeContainer() {
			const bnpl_label_container = document.getElementsByClassName("bnpl-label-container")[0];
			if (bnpl_label_container.style.visibility == 'visible') {
				bnpl_label_container.style.visibility = 'hidden';
				bnpl_label_container.style.opacity = 0;
				bnpl_label_container.style.transition = 'visibility 0s, opacity 0.5s ease';
			} else {
				bnpl_label_container.style.visibility = 'visible';
				bnpl_label_container.style.opacity = 1;
			}
		}
	</script>

	<?php
	if (isMobile()) {
	?>
		<!-- Start Footer Area -->
		<footer class="footer">
			<!-- Footer Top -->
			<div class="footer-top section">
				<div class="container">
					<div class="row">
						<div class="col-12 text-center">
							<!-- Single Widget -->
							<div class="single-footer about">
								<p class="text ff-rl">Електронен каталог за продажба</p>
							</div>
							<!-- End Single Widget -->
						</div>
						<div class="col-12 text-center">
							<!-- Single Widget -->
							<div class="single-footer links">
								<h4 class="mb-1">Продукти</h4>
								<ul>
									<li><a href="<?= $core ?>">Продукти</a></li>
								</ul>
							</div>
							<!-- End Single Widget -->
						</div>
						<div class="col-12 text-center">
							<!-- Single Widget -->
							<div class="single-footer links">
								<h4 class="mb-1">Информация</h4>
								<ul>
									<li><a href="<?= $core ?>uslugi">Услуги</a></li>
								</ul>
							</div>
							<!-- End Single Widget -->
						</div>
						<div class="col-12 text-center">
							<!-- Single Widget -->
							<div class="single-footer links">
								<ul>
									<li><a href="contact">Контакти</a></li>
								</ul>
							</div>
							<!-- End Single Widget -->
						</div>
						<div class="col-12 text-center">
							<!-- Single Widget -->
							<div class="single-footer links mb-1">
								<h4 class="mb-1">Свържете се с нас</h4>
								<ul>
									<li>+359 123 456</li>
									<li>+359 123 457</li>
								</ul>
							</div>
							<!-- End Single Widget -->
							<!-- Single Widget -->
							<div class="single-footer links">
								<h4 class="text-uppercase mb-1">Последвайте ни</h4>
								<span class="pr-1">
									<a href="https://www.facebook.com/" target="_blank">
										<svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 45 45">
											<g transform="translate(-1419 -186.418)">
												<circle cx="22.5" cy="22.5" r="22.5" transform="translate(1419 186.418)" fill="#ff4557" />
												<g transform="translate(1406.6 186.318)">
													<path d="M32.154,24.209h-3.1c-.5,0-.657-.188-.657-.657V19.767c0-.5.188-.657.657-.657h3.1V16.357A6.949,6.949,0,0,1,33,12.822a5.191,5.191,0,0,1,2.784-2.315,6.96,6.96,0,0,1,2.409-.407h3.066c.438,0,.626.188.626.626v3.566c0,.438-.188.626-.626.626-.845,0-1.689,0-2.534.031a1.13,1.13,0,0,0-1.283,1.283c-.031.939,0,1.846,0,2.816H41.07c.5,0,.688.188.688.688v3.785c0,.5-.156.657-.688.657H37.441v10.2c0,.532-.156.72-.72.72h-3.91c-.469,0-.657-.188-.657-.657V24.209Z" fill="#fff" />
												</g>
											</g>
										</svg>
									</a>
								</span>
								<span>
									<a href="https://instagram.com/" target="_blank">
										<svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 45 45">
											<g transform="translate(-1490 -186.418)">
												<circle cx="22.5" cy="22.5" r="22.5" transform="translate(1490 186.418)" fill="#ff4557" />
												<g transform="translate(1498.995 195.418)">
													<g transform="translate(0.005)">
														<path d="M20.044,0H6.685A6.7,6.7,0,0,0,0,6.68v13.36a6.7,6.7,0,0,0,6.68,6.68H20.044a6.7,6.7,0,0,0,6.68-6.68V6.68A6.7,6.7,0,0,0,20.044,0ZM24.5,20.039a4.458,4.458,0,0,1-4.453,4.453H6.685a4.459,4.459,0,0,1-4.453-4.453V6.68A4.458,4.458,0,0,1,6.685,2.227H20.044A4.457,4.457,0,0,1,24.5,6.68v13.36Z" transform="translate(-0.005)" fill="#fff" />
													</g>
													<g transform="translate(18.931 4.453)">
														<circle cx="1.67" cy="1.67" r="1.67" fill="#fff" />
													</g>
													<g transform="translate(6.685 6.68)">
														<path d="M109.085,102.4a6.68,6.68,0,1,0,6.68,6.68A6.679,6.679,0,0,0,109.085,102.4Zm0,11.133a4.453,4.453,0,1,1,4.453-4.454A4.453,4.453,0,0,1,109.085,113.533Z" transform="translate(-102.405 -102.4)" fill="#fff" />
													</g>
												</g>
											</g>
										</svg>
									</a>
								</span>
							</div>
							<!-- End Single Widget -->
						</div>
					</div>
				</div>
			</div>
			<!-- End Footer Top -->
		</footer>
		<!-- /End Footer Area -->

		<!-- Jquery -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/jquery-migrate-3.0.0.js"></script>
		<script src="assets/js/jquery-ui.min.js"></script>
		<!-- Popper JS -->
		<script src="assets/js/popper.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="assets/js/bootstrap.min.js"></script>
		<!-- Color JS -->
		<script src="assets/js/colors.js"></script>
		<!-- Slicknav JS -->
		<script src="assets/js/slicknav.min.js"></script>
		<!-- Owl Carousel JS -->
		<script src="assets/js/owl-carousel.js"></script>
		<!-- Magnific Popup JS -->
		<script src="assets/js/magnific-popup.js"></script>
		<!-- Waypoints JS -->
		<script src="assets/js/waypoints.min.js"></script>
		<!-- Countdown JS -->
		<script src="assets/js/finalcountdown.min.js"></script>
		<!-- Nice Select JS -->
		<script src="assets/js/nicesellect.js"></script>
		<!-- Flex Slider JS -->
		<script src="assets/js/flex-slider.js"></script>
		<!-- ScrollUp JS -->
		<script src="assets/js/scrollup.js"></script>
		<!-- Onepage Nav JS -->
		<script src="assets/js/onepage-nav.min.js"></script>
		<!-- Easing JS -->
		<script src="assets/js/easing.js"></script>
		<!-- Active JS -->
		<script src="assets/js/active.js"></script>
		<!-- Scripts JS -->
		<script src="assets/js/scripts.js"></script>
		<!-- Scripts Mobile JS -->
		<script src="assets/js/scripts-mobile.js"></script>
		</body>

		</html>

	<?php
	} else {
	?>
		<!-- Start Footer Area -->
		<footer class="footer">
			<!-- Footer Top -->
			<div class="footer-top section">
				<div class="container">
					<div class="row">
						<div class="col-lg-4 col-md-6 col-12">
							<!-- Single Widget -->
							<div class="single-footer about">
								<p class="text ff-rl">Настоящия проект е част от Дипломна работа</p>
							</div>
							<!-- End Single Widget -->
						</div>
						<div class="col-lg-2 col-md-6 col-12">
							<!-- Single Widget -->
							<div class="single-footer links">
								<h4 class="text-uppercase">Продукти</h4>
								<ul>
									<li><a href="<?= $core ?>">Продукти</a></li>
								</ul>
							</div>
							<!-- End Single Widget -->
						</div>
						<div class="col-lg-2 col-md-6 col-12">
							<!-- Single Widget -->
							<div class="single-footer links">
								<h4 class="text-uppercase">Информация</h4>
								<ul>
									<li>Онлайн обяви за продажба</li>
								</ul>
							</div>
							<!-- End Single Widget -->
						</div>
						<div class="col-lg-2 col-md-6 col-12">
							<!-- Single Widget -->
							<div class="single-footer links">
								<h4>Контакти</h4>
								<ul>
									<li><a href="<?= $core ?>contact">Връзка с нас</a></li>
								</ul>
							</div>
							<!-- End Single Widget -->
						</div>
						<div class="col-lg-2 col-md-6 col-12">
							<!-- Single Widget -->
							<div class="single-footer links mb-2">
								<h4 class="text-uppercase">Свържете се с нас</h4>
								<ul>
									<li>+359 123 456</li>
									<li>+359 123 457</li>
								</ul>
							</div>
							<!-- End Single Widget -->
							<!-- Single Widget -->
							<div class="single-footer links">
								<h4 class="text-uppercase mb-1">Последвайте ни</h4>
								<span class="pr-1">
									<a href="https://www.facebook.com/" target="_blank">
										<svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 45 45">
											<g transform="translate(-1419 -186.418)">
												<circle cx="22.5" cy="22.5" r="22.5" transform="translate(1419 186.418)" fill="#ff4557" />
												<g transform="translate(1406.6 186.318)">
													<path d="M32.154,24.209h-3.1c-.5,0-.657-.188-.657-.657V19.767c0-.5.188-.657.657-.657h3.1V16.357A6.949,6.949,0,0,1,33,12.822a5.191,5.191,0,0,1,2.784-2.315,6.96,6.96,0,0,1,2.409-.407h3.066c.438,0,.626.188.626.626v3.566c0,.438-.188.626-.626.626-.845,0-1.689,0-2.534.031a1.13,1.13,0,0,0-1.283,1.283c-.031.939,0,1.846,0,2.816H41.07c.5,0,.688.188.688.688v3.785c0,.5-.156.657-.688.657H37.441v10.2c0,.532-.156.72-.72.72h-3.91c-.469,0-.657-.188-.657-.657V24.209Z" fill="#fff" />
												</g>
											</g>
										</svg>
									</a>
								</span>
								<span>
									<a href="https://instagram.com/" target="_blank">
										<svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 45 45">
											<g transform="translate(-1490 -186.418)">
												<circle cx="22.5" cy="22.5" r="22.5" transform="translate(1490 186.418)" fill="#ff4557" />
												<g transform="translate(1498.995 195.418)">
													<g transform="translate(0.005)">
														<path d="M20.044,0H6.685A6.7,6.7,0,0,0,0,6.68v13.36a6.7,6.7,0,0,0,6.68,6.68H20.044a6.7,6.7,0,0,0,6.68-6.68V6.68A6.7,6.7,0,0,0,20.044,0ZM24.5,20.039a4.458,4.458,0,0,1-4.453,4.453H6.685a4.459,4.459,0,0,1-4.453-4.453V6.68A4.458,4.458,0,0,1,6.685,2.227H20.044A4.457,4.457,0,0,1,24.5,6.68v13.36Z" transform="translate(-0.005)" fill="#fff" />
													</g>
													<g transform="translate(18.931 4.453)">
														<circle cx="1.67" cy="1.67" r="1.67" fill="#fff" />
													</g>
													<g transform="translate(6.685 6.68)">
														<path d="M109.085,102.4a6.68,6.68,0,1,0,6.68,6.68A6.679,6.679,0,0,0,109.085,102.4Zm0,11.133a4.453,4.453,0,1,1,4.453-4.454A4.453,4.453,0,0,1,109.085,113.533Z" transform="translate(-102.405 -102.4)" fill="#fff" />
													</g>
												</g>
											</g>
										</svg>
									</a>
								</span>
							</div>
							<!-- End Single Widget -->
						</div>
					</div>
				</div>
			</div>
			<!-- End Footer Top -->
		</footer>
		<!-- /End Footer Area -->

		<!-- Jquery -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/jquery-migrate-3.0.0.js"></script>
		<script src="assets/js/jquery-ui.min.js"></script>
		<!-- Popper JS -->
		<script src="assets/js/popper.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="assets/js/bootstrap.min.js"></script>
		<!-- Color JS -->
		<script src="assets/js/colors.js"></script>
		<!-- Slicknav JS -->
		<script src="assets/js/slicknav.min.js"></script>
		<!-- Owl Carousel JS -->
		<script src="assets/js/owl-carousel.js"></script>
		<!-- Magnific Popup JS -->
		<script src="assets/js/magnific-popup.js"></script>
		<!-- Waypoints JS -->
		<script src="assets/js/waypoints.min.js"></script>
		<!-- Countdown JS -->
		<script src="assets/js/finalcountdown.min.js"></script>
		<!-- Nice Select JS -->
		<script src="assets/js/nicesellect.js"></script>
		<!-- Flex Slider JS -->
		<script src="assets/js/flex-slider.js"></script>
		<!-- ScrollUp JS -->
		<script src="assets/js/scrollup.js"></script>
		<!-- Onepage Nav JS -->
		<script src="assets/js/onepage-nav.min.js"></script>
		<!-- Easing JS -->
		<script src="assets/js/easing.js"></script>
		<!-- Active JS -->
		<script src="assets/js/active.js"></script>
		<!-- Scripts JS -->
		<script src="assets/js/scripts.js"></script>
		</body>

		</html>
	<?php
	}
	?>