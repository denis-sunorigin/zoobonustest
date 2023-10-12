<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZooBonus тестове завдання</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="templates/style.css" rel="stylesheet">
  </head>
  <style>
  </style>
  <body>
    <div class="fullPageBlock">
      <div class="fullPageColumn">
        <div class="menuBarBlock">
          <div class="menuBarLogoBlock">
            <a href="index.php" title="На головну сторінку"><img src="templates/images_static/logo.png"></a>
          </div>
          <div class="menuBarMenuBlock">
            <div class="dropdown">
              <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Адміністрування
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <?php if (isAuthorized()) { ?>
                  <li><a class="dropdown-item" href="admincatalog.php">Каталог товарів</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><h6 class="dropdown-header">Довідники</h6></li>
                  <li><a class="dropdown-item" href="admindictcategories.php">Категорії</a></li>
                  <li><a class="dropdown-item" href="admindictbrands.php">Бренди</a></li>
                  <li><a class="dropdown-item" href="admindictstatuses.php">Статуси товару</a></li>
                  <li><hr class="dropdown-divider"></li>
                <?php } ?>
                <li><a class="dropdown-item" href="dbdiag.php">Діагностика БД</a></li>
              </ul>
            </div>
            <?php if (isAuthorized()) { ?>
              <a href="logout.php">Вихід</a>
            <?php } else { ?>
              <a href="login.php">Вхід</a>
            <?php } ?>
          </div>
        </div>
        <div class="mainContentBlock">