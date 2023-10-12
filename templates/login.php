<?php include('header.php'); ?>

          <div class="mainContentAsForm">
            <h3 class="mb-3">Вхід до системи</h3>
            <form method="POST">
              <div class="form-floating mb-3">
                <input type="login" name="login" class="form-control" id="floatingInput" placeholder="Логін" required>
                <label for="floatingInput">Логін</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Пароль" required>
                <label for="floatingPassword">Пароль</label>
              </div>
              <div class="fullWidthContainer alignCenterHor">
                <button class="btn btn-primary fullWidthContainer" type="submit">Увійти</button>
              </div>
            </form>
            <div>&nbsp;</div>
            <div>Вхід до системи і додаткові функції адміністрування доступні лише після створення БД.<br>admin/admin</div>
            <div>&nbsp;</div>
            <?php if (filled($message)) { ?>
              <h5>Повідомлення про помилку:</h5>
              <div style="color: red;">
                <?php echo($message); ?>
              </div>
            <?php } ?>
          </div>

<?php include('footer.php'); ?>