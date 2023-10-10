<?php include('header.php'); ?>

          <div class="mainContentAsSingleColumn">
            <h2>Адміністрування. Товари.</h2>
            <div class="alignCenterVert columnGap15 canWrap fullWidthContainer mb-3">
              <div>
                <select class="form-select form-select-sm">
                  <option value="1" selected>Всі категорії</option>
                  <option value="2">Категорія 1</option>
                  <option value="3">Категорія 2</option>
                </select>
              </div>
              <div>
                <select class="form-select form-select-sm">
                  <option value="1" selected>Всі бренди</option>
                  <option value="2">Chappi</option>
                  <option value="3">Royal Canin</option>
                </select>
              </div>
              <button class="btn btn-primary btn-sm" type="button">Додати товар</button>
            </div>

            <div class="zbTable">
              <div class="zbTableHeader">
                <div class="size1">ID</div>
                <div class="size2">Фото</div>
                <div class="size4">Назва</div>
                <div class="size4">Опис</div>
                <div class="size2">Наявн.</div>
                <div class="size2">Ціна</div>
                <div class="size3">Статус</div>
                <div class="size3">Категорія</div>
                <div class="size3">Бренд</div>
                <div class="size2">Код 1С</div>
              </div>
              <div class="zbTableRow">
                <div class="size1">1</div>
                <div class="size2 zbTablePhotoCell" style="background-image: URL('images_user/pic4.png');"></div>
                <div class="size4 zbTableNameCell">Корм для голубів</div>
                <div class="size4">Комплекс збагачений вітамінами</div>
                <div class="size2">9 999</div>
                <div class="size2">9 999.99</div>
                <div class="size3">Доступний</div>
                <div class="size3">Категорія 1</div>
                <div class="size3">Chappi</div>
                <div class="size2">285367</div>
              </div>
              <div class="zbTableRow">
                <div class="size1">2</div>
                <div class="size2 zbTablePhotoCell" style="background-image: URL('images_user/pic5.png');"></div>
                <div class="size4 zbTableNameCell">Корм для чіхуахуа</div>
                <div class="size4">З мінералами і екстрактами</div>
                <div class="size2">9 999</div>
                <div class="size2">9 999.99</div>
                <div class="size3">Прихований</div>
                <div class="size3">Категорія 2</div>
                <div class="size3">Royal Canin</div>
                <div class="size2">347151</div>
              </div>
            </div>

          </div>

<?php include('footer.php'); ?>