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
                <div class="size1"><a href="#">ID</a></div>
                <div class="size4">Фото</div>
                <div class="size4"><a href="#" style="color: green; text-decoration: underline;">Назва</a></div>
                <div class="size4">Опис</div>
                <div class="size2"><a href="#" style="color: red;">Наявн.</a></div>
                <div class="size2">Ціна</div>
                <div class="size3">Статус (id)</div>
                <div class="size3">Категорія (id)</div>
                <div class="size3">Бренд (id)</div>
                <div class="size2">Код 1С</div>
              </div>
              <?php foreach($productList as $product) { ?>
                <div class="zbTableRow" style="cursor: pointer;" onclick="document.location='adminproduct.php?id=<?php echo(filled($paramsString) ? $product["id"].'&'.$paramsString : $product["id"]) ?>';">
                  <div class="size1"><?php echo($product["id"]); ?></div>
                  <div class="size4 zbTablePhotoCell" <?php if (filled($product["image"])) { ?>style="background-image: URL('<?php echo(PATHFORUSERIMAGES.$product["image"]); ?>');"<?php } ?>></div>
                  <div class="size4 zbTableNameCell" title="<?php echo($product["name"]); ?>"><?php echo(($product["name"] != '') ? mb_strimwidth($product["name"],0,90,'...') : '<немає назви>'); ?></div>
                  <div class="size4" title="<?php echo($product["description"]); ?>"><?php echo(($product["description"] != '') ? mb_strimwidth($product["description"],0,100,'...') : '<немає опису>'); ?></div>
                  <div class="size2"><?php echo($product["value"]); ?></div>
                  <div class="size2"><?php echo($product["price"]); ?></div>
                  <div class="size3"><?php echo($product["statusname"]." (".$product["statusid"].")"); ?></div>
                  <div class="size3"><?php echo($product["categoryname"]." (".$product["categoryid"].")"); ?></div>
                  <div class="size3"><?php echo($product["brandname"]." (".$product["brandid"].")"); ?></div>
                  <div class="size2"><?php echo($product["code1c"]); ?></div>
                </div>
              <?php } ?>
            </div>

          </div>

<?php include('footer.php'); ?>