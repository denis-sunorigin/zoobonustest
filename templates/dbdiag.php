<?php include('header.php'); ?>

          <div class="mainContentAsForm">
            <div style="flex-direction: column; text-align: left; align-items: flex-start; max-width: 500px;">
              <h3 class="mb-3">Діагностика з'єднання з БД</h3>
              <h4>Поточні налаштування:</h4>
              <div>Сервер: <?php echo(DBHOST); ?></div>
              <div>Порт: <?php echo(DBPORT); ?></div>
              <div>Ім'я БД: <?php echo(DBNAME); ?></div>
              <div>Користувач БД: <?php echo(DBUSER); ?></div>
              <div>Пароль: <приховано></div>
              <div>Налаштування зберігаються в файлі settings.php</div>
              <div>&nbsp;</div>
              <?php if (empty($error)) { ?>
                <h4>Помилок не виявлено</h4>
                <a style="color: var(--zbColorGreen90);" href="index.php">Перейти на головну сторінку.</a>
              <?php } else { ?>
                <h4>Поточна помилка:</h4>
                <div><?php echo($error); ?></div>
              <?php } ?>
              <button class="btn btn-primary" type="button" style="white-space: nowrap;" onclick="document.location='dbdiag.php';">Оновити статус</button>
              <div>&nbsp;</div>
              <h4>Службові функції:</h4>
              <div>Пароль за замовченням: admin</div>
              <div class="fullWidthContainer" style="flex-direction: column; text-align: left; align-items: flex-start; row-gap: 15px;">
                <div class="input-group" style="max-width: 240px; min-width: 180px;">
                  <span class="input-group-text" id="password">Пароль:</span>
                  <input type="password" class="form-control" id="property1input" aria-describedby="password" oninput="document.getElementById('password1').value=this.value; document.getElementById('password2').value=this.value; document.getElementById('password3').value=this.value;">
                </div>
                <div style="flex-wrap: wrap; width: 100%; column-gap: 10px; row-gap: 10px;">
                  <form action="dbdiag.php" method="POST">
                    <input type="hidden" name="dbaction" value="createdb">
                    <input type="hidden" name="password" value="" id="password1">
                    <button class="btn btn-primary" type="submit" style="white-space: nowrap;">Створити БД</button>
                  </form>
                  <form action="dbdiag.php" method="POST">
                    <input type="hidden" name="dbaction" value="createtables">
                    <input type="hidden" name="password" value="" id="password2">
                    <button class="btn btn-primary" type="submit" style="white-space: nowrap;">Створити таблиці</button>
                  </form>
                  <form action="dbdiag.php" method="POST">
                    <input type="hidden" name="dbaction" value="filltables">
                    <input type="hidden" name="password" value="" id="password3">
                    <button class="btn btn-primary" type="submit" style="white-space: nowrap;">Наповнити таблиці</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

<?php include('footer.php'); ?>