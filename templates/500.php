<?php include('header.php'); ?>

          <div class="mainContentAsForm">
            <div style="flex-direction: column; text-align: left; align-items: flex-start; max-width: 500px;">
              <h3 class="mb-3">Помилка під час звернення до сервера (500)</h3>
              Додаткова інформаці про помилку: <?php echo(empty($error) ? '<відсутня>' : $error); ?><br>
              <br>
              Ви можете
              <a style="color: var(--zbColorGreen90);" href="dbdiag.php">перейти на сторінку діагностики БД</a>
              або
		          <a style="color: var(--zbColorGreen90);" href="index.php">перейти на головну сторінку</a>
              або
              <a style="color: var(--zbColorGreen90);" href="login.php">перейти на сторінку авторизації</a>
            </div>
          </div>

<?php include('footer.php'); ?>