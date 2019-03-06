<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>Главная</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css" />
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
</head>
<body>

	<?php include \core\App::helper()->getPrepareAppPatch("views/$content_view") ?>

    <p style="font-size: 0.55em;
        padding: 20px;">version: <?= \core\App::config()->getParams('app_version') ?></p>

    <script src="/js/jquery.min.js" type="text/javascript"></script>
    <script src="/js/tether.min.js" type="text/javascript"></script>
    <script src="/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>
