<?php include('header.php'); ?>

          <div class="mainContentAsSingleColumn">
            <h2>Адміністрування. Товари.</h2>
            <div class="alignCenterVert columnGap15 canWrap fullWidthContainer mb-3">
              <div>
                <select class="form-select form-select-sm" onChange="document.location=this.value;">
                  <?php foreach($categoriesList as $category) { ?>
                    <option value="<?php echo($category["link"]); ?>" <?php if ($category["selected"]) { ?>selected<?php } ?>><?php echo($category["name"]); ?></option>
                  <?php } ?>
                </select>
              </div>
              <div>
                <select disabled class="form-select form-select-sm">
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
                <div class="size4">Фото</div>
                <div class="size4">Назва</div>
                <div class="size4">Опис</div>
                <div class="size2">Наявн.</div>
                <div class="size2">Ціна</div>
                <div class="size3">Статус</div>
                <div class="size3">Категорія</div>
                <div class="size3">Бренд</div>
                <div class="size2">Код 1С</div>
              </div>
              <?php foreach($productList as $product) { ?>
                <div class="zbTableRow">
                  <div class="size1"><?php echo($product["id"]); ?></div>
                  <div class="size4 zbTablePhotoCell" style="background-image: URL('<?php echo(PATHFORUSERIMAGES.$product["image"]); ?>');"></div>
                  <div class="size4 zbTableNameCell"><?php echo($product["name"]); ?></div>
                  <div class="size4"><?php echo(($product["description"] != '') ? mb_strimwidth($product["description"],0,100,'...') : '<немає опису>'); ?></div>
                  <div class="size2"><?php echo($product["value"]); ?></div>
                  <div class="size2"><?php echo($product["price"]); ?></div>
                  <div class="size3"><?php echo($product["statusid"]); ?></div>
                  <div class="size3"><?php echo($product["categoryid"]); ?></div>
                  <div class="size3"><?php echo($product["brandid"]); ?></div>
                  <div class="size2"><?php echo($product["code1c"]); ?></div>
                </div>
              <?php } ?>
            </div>

          </div>

<?php include('footer.php'); ?>