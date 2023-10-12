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

            <?php if (filled($productList)) { ?>
              <div class="zbTable">
                <div class="zbTableHeader">
                  <div class="size1"><a href="<?php echo($sorts[0]["link"]); ?>" style="text-decoration: underline; <?php if ($sorts[0]["active_forward"]) echo('color: green;'); if ($sorts[0]["active_backward"]) echo('color: red;'); ?>">ID</a></div>
                  <div class="size4">Фото</div>
                  <div class="size4"><a href="<?php echo($sorts[1]["link"]); ?>" style="text-decoration: underline; <?php if ($sorts[1]["active_forward"]) echo('color: green;'); if ($sorts[1]["active_backward"]) echo('color: red;'); ?>">Назва</a></div>
                  <div class="size4">Опис</div>
                  <div class="size2"><a href="<?php echo($sorts[2]["link"]); ?>" style="text-decoration: underline; <?php if ($sorts[2]["active_forward"]) echo('color: green;'); if ($sorts[2]["active_backward"]) echo('color: red;'); ?>">Наявн.</a></div>
                  <div class="size2"><a href="<?php echo($sorts[3]["link"]); ?>" style="text-decoration: underline; <?php if ($sorts[3]["active_forward"]) echo('color: green;'); if ($sorts[3]["active_backward"]) echo('color: red;'); ?>">Ціна</a></div>
                  <div class="size3"><a href="<?php echo($sorts[4]["link"]); ?>" style="text-decoration: underline; <?php if ($sorts[4]["active_forward"]) echo('color: green;'); if ($sorts[4]["active_backward"]) echo('color: red;'); ?>">Статус</a> 
                    &nbsp; (<a href="<?php echo($sorts[5]["link"]); ?>" style="text-decoration: underline; <?php if ($sorts[5]["active_forward"]) echo('color: green;'); if ($sorts[5]["active_backward"]) echo('color: red;'); ?>">id</a>)</div>
                  <div class="size3"><a href="<?php echo($sorts[6]["link"]); ?>" style="text-decoration: underline; <?php if ($sorts[6]["active_forward"]) echo('color: green;'); if ($sorts[6]["active_backward"]) echo('color: red;'); ?>">Категорія</a> 
                    &nbsp; (<a href="<?php echo($sorts[7]["link"]); ?>" style="text-decoration: underline; <?php if ($sorts[7]["active_forward"]) echo('color: green;'); if ($sorts[7]["active_backward"]) echo('color: red;'); ?>">id</a>)</div>
                  <div class="size3"><a href="<?php echo($sorts[8]["link"]); ?>" style="text-decoration: underline; <?php if ($sorts[8]["active_forward"]) echo('color: green;'); if ($sorts[8]["active_backward"]) echo('color: red;'); ?>">Бренд</a> 
                    &nbsp; (<a href="<?php echo($sorts[9]["link"]); ?>" style="text-decoration: underline; <?php if ($sorts[9]["active_forward"]) echo('color: green;'); if ($sorts[9]["active_backward"]) echo('color: red;'); ?>">id</a>)</div>
                  <div class="size2"><a href="<?php echo($sorts[10]["link"]); ?>" style="text-decoration: underline; <?php if ($sorts[10]["active_forward"]) echo('color: green;'); if ($sorts[10]["active_backward"]) echo('color: red;'); ?>">Код 1С</a></div>
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
            <?php } else { ?>
              <h4>Каталог товарів порожній</h4>
            <?php } ?>

          </div>

<?php include('footer.php'); ?>