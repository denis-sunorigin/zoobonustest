<?php include('header.php'); ?>

          <div class="mainContentAsForm">
            <h3 class="mb-3">Вхід до системи</h3>
            <form>
              <div class="form-floating mb-3">
                <input type="login" class="form-control" id="floatingInput" placeholder="Логін">
                <label for="floatingInput">Логін</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Пароль">
                <label for="floatingPassword">Пароль</label>
              </div>
              <div class="fullWidthContainer alignCenterHor">
                <button class="btn btn-primary fullWidthContainer" type="submit">Увійти</button>
              </div>
            </form> 
          </div>

<?php include('footer.php'); ?>