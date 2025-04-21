<?php

if (isset($_GET['id']) && $_GET['id'] != 0) {
    $catId = $_GET['id'];
    try {
        $category = $mysqli->query("SELECT *  FROM categories WHERE category_id=" . $catId);
        if ($category->num_rows > 0) {
            $row = $category->fetch_object();
            $catName = $row->category_name;
            $catDesc = $row->category_desc;
        } else {
            $catName = '';
            $catDesc = '';
        }
    } catch (Exception $e) {
        echo 'Грешка: ', $e->getMessage(), "\n";
    }
} elseif ((isset($_GET['id']) && $_GET['id'] == 0) || (!isset($_GET['id'])) ||  (isset($_GET['id']) && $_GET['id'] == "")) {
    $catName = "";
    $catDesc = "";
    $catId = 0;
}

$count = (isset($_GET['count'])) ? intval($_GET['count']) : 15;
$page = (isset($_GET['pagenr'])) ? intval($_GET['pagenr']) : 1;
$order = (isset($_GET['order']) && $_GET['order'] == 2) ? 'DESC' : 'ASC';
$priceMinStr = (isset($_GET['min'])) ? " AND products.product_price >= " . $_GET['min'] : "";
$priceMaxStr = (isset($_GET['max'])) ? " AND products.product_price <= " . $_GET['max'] : "";
$qryStr = (isset($_GET['q'])) ? " AND (products.product_name LIKE '%" . $_GET['q'] . "%' OR products.product_description LIKE '%" . $_GET['q'] . "%'OR products.product_model LIKE '%" . $_GET['q'] . "%')" : "";
$prodCat = ($catId > 0) ? " WHERE category_products.category_id = " . $_GET['id'] : " WHERE category_products.category_id > 0";
$start = ($page == 1) ? 0 : ($page - 1) * $count;
$qryProd = "SELECT products.product_id as id, products.product_name, products.product_model, product_options.option_value as product_image, products.product_price FROM products
                    LEFT JOIN category_products ON category_products.product_id = products.product_id                   
                    LEFT JOIN product_options ON product_options.product_id = products.product_id" .
    $prodCat .
    $qryStr . " GROUP BY products.product_id ORDER BY products.product_price " . $order . " 
                LIMIT " . $start . ", " . $count;
$qryCount =  "SELECT COUNT(*) FROM products
                    LEFT JOIN category_products ON category_products.product_id = products.product_id
                    LEFT JOIN product_options ON product_options.product_id = products.product_id" .
    $prodCat . $qryStr . " GROUP BY products.product_id";
try {
    $products = $mysqli->query($qryProd);
    $productsCountSQL = $mysqli->query($qryCount);
    $productsCount = $productsCountSQL->num_rows;
} catch (Exception $e) {
    echo 'Грешка: ', $e->getMessage(), "\n";
}
?>

<?php
if (isMobile()) {
?>
    <?php
    if ($catName != "") {
    ?>
        <!-- Start Cat Area -->
        <section>
            <div class="container mt-8 mb-3">
                <div class="row mb-3 clr-ib">
                    <div class="col-12 mb-1 text-center ff-rb">
                        <h3><?= $catName ?></h3>
                    </div>
                    <div class="col-12 breadcrumbs-top text-center">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb p-0 mb-0 pl-0">
                                <li class="breadcrumb-item ">
                                    <a href="<?= $core ?>search">Обяви</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <?= $catName ?>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-12 text-center mt-1 px-lg10-md-5-mb-1">
                        <p class="ff-rl"><?= $catDesc ?></p>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Cat Area -->
    <?php
    }
    ?>
    <!-- Start Products -->
    <section>
        <div class="container my-5">
            <div class="row">
                <div class="col-12">
                    <div class="row mb-1">
                        <div class="col-12 mb-1 text-center">
                            <div class="row mt-3">
                                <div id="input-sort-w" class="col-12 ff-rl">
                                    <select id="input-sort">
                                        <option value="1" <?= ($order == 'ASC') ? "selected" : "" ?>>Цена (възх.)</option>
                                        <option value="2" <?= ($order == 'DESC') ? "selected" : "" ?>>Цена (низх.)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-m1px">
                        <?php
                        while ($product = $products->fetch_object()) {
                        ?>
                            <div class="col-12 product-pw-w text-center pb-1">
                                <div class="product-pw">
                                    <div class="prd-th-img">
                                        <a href="<?= $core ?>product?id=<?= $product->id ?>">
                                            <img src="assets/images/product/<?= $product->product_image ?>" alt="<?= $product->product_name ?>">
                                        </a>
                                    </div>
                                    <div class="product-inf">
                                        <h5>
                                            <a class="ff-rl" href="<?= $core ?>product?id=<?= $product->id ?>"><?= $product->product_name ?></br>
                                                <?= $product->product_model ?></a>
                                        </h5>
                                        <div class="product-price mt-1 mb-1">
                                                <span class="price"><?= number_format($product->product_price, 2, ',', ' ') ?> лв.</span>
                                        </div>
                                        <div class="mb-1">
                                            <?php
                                            $urlStr = removeParam($_SERVER['REQUEST_URI'], 'buy');
                                            $urlStr = removeParam($urlStr, 'img');
                                            ?>
                                            <a href="<?= $urlStr ?>?buy=<?= $product->id ?>&img=<?= ($product->product_image != "") ? $product->product_image : "" ?>" class="btn">Виж</a>
                                            <!--<a href="<?= $core ?>product?id=<?= $product->id ?>" class="btn">Купи</a>-->
                                        </div>
                                        <div class="ff-rl text-uppercase"></div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Products -->

    <!-- Start Pagination -->
    <section>
        <div class="container">
            <div class="row no-gutters">
                <div class="col-12 mb-3 pagination-block justify-content-center">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link page-link-prev" href="<?= removeParam($_SERVER['REQUEST_URI'], "pagenr") ?>&pagenr=<?= $page - 1 ?>" tabindex="-1" <?= ($page == 1) ? ' style="pointer-events: none;cursor: default; color:#D3D5D4"' : '' ?>>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path>
                                </svg>
                            </a>
                        </li>
                        <?php
                        $pagesTotal = ceil($productsCount / $count);
                        for ($pg = 1; $pg <= $pagesTotal; $pg++) {
                            if ($page + 3 >= ($pg) && $page - 1 <= ($pg)) {
                        ?>
                                <li class="page-item <?= ($page == $pg) ? 'active' : '' ?>"">
							<a class=" page-link" href="<?= removeParam($_SERVER['REQUEST_URI'], "pagenr") ?>&pagenr=<?= $pg ?>"><?= $pg ?></a>
                                </li>
                        <?php
                            }
                        }
                        ?>
                        <!-- <li class="page-item"> -->
                        <!-- <span class="brd-0 px-1 page-link" href="#">...</span> -->
                        <!-- </li> -->
                        <li class="page-item">
                            <a class="page-link page-link-next" href="<?= removeParam($_SERVER['REQUEST_URI'], "pagenr") ?>&pagenr=<?= $page + 1 ?>" <?= ($page == $pagesTotal || $pagesTotal == 0) ? ' style="pointer-events: none;cursor: default; color:#D3D5D4"' : '' ?>>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"></path>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- End Pagination -->
<?php
} else {
?>
    <!-- Start Cat Area -->
    <?php
    if ($catName != "") {
    ?>

        <section>
            <div class="container my-3">
                <div class="row breadcrumbs-top mb-3">
                    <div class="col-12">
                        <div class="breadcrumb-wrapper d-none d-sm-block">
                            <ol class="breadcrumb p-0 mb-0 pl-0">
                                <li class="breadcrumb-item ">
                                    <a href="<?= $core ?>search">Обяви</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <?= $catName ?>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Cat Area -->

    <?php
    }
    ?>
    <!-- Start Products -->
    <section>
        <div class="container mb-3">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 mb-2 text-left ff-rb">
                            <h3><?= $catName ?></h3>
                        </div>
                        <div class="col-12 ff-rl text-left">
                            <?= $catDesc ?>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-12 col-md-5 mb-1 text-left ff-rb">
                            <h5 id="numResults"><?= $productsCount ?> обяви</h5>
                        </div>
                        <div class="col-12 col-md-7 mb-1 text-right text-uppercase">
                            <div class="row">
                                <div class="col-6 ff-rl lh-2">
                                    Покажи:
                                    <select id="selectResults" onchange="setFilters('count', 'selectResults')">
                                        <option value="15" <?= ($count == 15) ? 'selected' : '' ?>>15</option>
                                        <option value="25" <?= ($count == 25) ? 'selected' : '' ?>>25</option>
                                        <option value="50" <?= ($count == 50) ? 'selected' : '' ?>>50</option>
                                        <option value="75" <?= ($count == 75) ? 'selected' : '' ?>>75</option>
                                        <option value="100" <?= ($count == 100) ? 'selected' : '' ?>>100</option>
                                    </select>
                                </div>
                                <div class="col-6 ff-rl lh-2">
                                    Сортиране по:
                                    <select id="input-sort" onchange="setFilters('order', 'input-sort')">
                                        <option value="1" <?= ($order == 'ASC') ? "selected" : "" ?>>Цена (възх.)</option>
                                        <option value="2" <?= ($order == 'DESC') ? "selected" : "" ?>>Цена (низх.)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mx-m1px">
                        <?php
                        while ($product = $products->fetch_object()) {
                        ?>
                            <div class="col-lg-3 col-md-3 col-12 product-pw-w text-center pb-1">
                                <div class="product-pw bg-light pb-2">
                                    <div class="prd-th-img">
                                        <a href="<?= $core ?>product?id=<?= $product->id ?>">                                            
                                            <img src="assets/images/product/<?= $product->product_image ?>" alt="<?= $product->product_name ?>">
                                        </a>
                                    </div>
                                    <div class="product-inf">
                                        <h5>
                                            <a class="ff-rl" href="<?= $core ?>product?id=<?= $product->id ?>"><?= $product->product_name ?></br>
                                                <?= $product->product_model ?></a>
                                        </h5>
                                        <div class="product-price mt-1 mb-1">
                                                <span class="price"><?= number_format($product->product_price, 2, ',', ' ') ?> лв.</span>
                                        </div>
                                        <div class="mb-1">
                                            <?php
                                            $urlStr = removeParam($_SERVER['REQUEST_URI'], 'buy');
                                            $urlStr = removeParam($urlStr, 'img');
                                            ?>
                                            <a href="<?= $core ?>product?id=<?= $product->id ?>" class="btn">Виж</a>
                                        </div>
                                        <div class="ff-rl text-uppercase"></div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Products -->

    <!-- Start Pagination -->
    <section>
        <div class="container">
            <div class="row no-gutters">
                <div class="col-12 mb-3 pagination-block">
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <a class="page-link page-link-prev" href="<?= removeParam($_SERVER['REQUEST_URI'], "pagenr") ?>&pagenr=<?= $page - 1 ?>" tabindex="-1" <?= ($page == 1) ? ' style="pointer-events: none;cursor: default; color:#D3D5D4"' : '' ?>>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path>
                                </svg>
                            </a>
                        </li>
                        <?php
                        $pagesTotal = ceil($productsCount / $count);
                        for ($pg = 1; $pg <= $pagesTotal; $pg++) {
                        ?>
                            <li class="page-item <?= ($page == $pg) ? 'active' : '' ?>">
                                <a class="page-link" href="<?= removeParam($_SERVER['REQUEST_URI'], "pagenr") ?>&pagenr=<?= $pg ?>"><?= $pg ?></a>
                            </li>
                        <?php
                        }
                        ?>
                        <!-- <li class="page-item">
                        <span class="brd-0 px-1 page-link" href="#">...</span>
                    </li> -->
                        <li class="page-item">
                            <a class="page-link page-link-next" href="<?= removeParam($_SERVER['REQUEST_URI'], "pagenr") ?>&pagenr=<?= $page + 1 ?>" <?= ($page == $pagesTotal || $pagesTotal == 0) ? ' style="pointer-events: none;cursor: default; color:#D3D5D4"' : '' ?>>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"></path>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- End Pagination -->
<?php
}
?>
<script>
    function setFilters(filter, object) {
        var selectBox = document.getElementById(object)
        var selectedResults = +selectBox.options[selectBox.selectedIndex].value
        const parser = new URL(window.location);
        parser.searchParams.set(filter, selectedResults);
        parser.searchParams.delete("pagenr");
        window.location = parser.href;
    }

    function setFilterByAttr(e) {
        var currUrl = new URL(window.location.href)
        var params = currUrl.searchParams
        params.delete('pagenr')
        var currFilter = (params.get('filters') !== null) ? params.get('filters').split(',') : [];
        if (e.checked) {
            currFilter.push(e.id)
        } else {
            let ind = currFilter.indexOf(e.id)
            currFilter.splice(ind, 1)
        }
        params.set('filters', currFilter.toString())
        if (currFilter.length == 0) params.delete('filters')
        window.location.href = currUrl
    }

    function setNewPriceRange() {
        var min = document.getElementById('min').value
        var max = document.getElementById('max').value
        window.location.href = '<?= $core ?>' + 'search?id=<?= $catId ?>&min=' + min + '&max=' + max
    }
</script>