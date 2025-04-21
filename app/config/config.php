<?php
//настройка на достъпа до базите данни
	$mysqli = new mysqli('localhost', 'olx', '123', 'pazar');
    $dbh = new PDO("mysql:host=localhost;dbname=pazar", "olx", "123",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
	mysqli_query($mysqli, "SET NAMES 'UTF8'");
//Задаване на имейл от който се изпращат съобщения
	$adminEmail = "test@test.com";
//Задаване на основната директория на сайта
	$core = '/pazar/';
//Задаване на пътищата и съответните изпълними файлове
	$routes = array(
		'home.php'      => $core,
		'product.php' => $core . 'product',
		'contact.php' => $core . 'contact',
		'cart.php' => $core . 'cart',
		'addproduct.php' => $core . 'addproduct'
	);
//Задаване на загавията на страниците
	$titles = array(
		'Дипломна Работа: Онлайн магазин' => $core,
		'Детайли' => $core . 'product',
		'Контакт с нас' => $core . 'contact',
		'Вход' => $core . 'login',
		'Количка' => $core . 'cart',
		'Добавяне на продукт' => $core . 'addproduct'
	);	
?>