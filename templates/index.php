<?php include('header.php'); ?>

          <div class="mainContentAsTwoColumns">
            <div class="mainContentFirstColumn">
              <fieldset class="mb-3">
                <legend><h4>Категорії:</h4></legend>
                <?php if (filled($categoriesList)) foreach($categoriesList as $category) { ?>
                  <div class="form-check">
                    <input <?php if ($category["selected"]) { ?>checked<?php } ?> type="radio" name="radios" class="form-check-input" id="catOption<?php echo($category["id"]); ?>" onclick="document.location='<?php echo($category["link"]); ?>';" title="<?php echo($category["description"]); ?>">
                    <label class="form-check-label" for="catOption<?php echo($category["id"]); ?>" title="<?php echo($category["description"]); ?>"><?php echo($category["name"]); ?></label>
                  </div>
                <?php } ?>
              </fieldset>
              <fieldset class="mb-3">
                <legend><h4>Бренди:</h4></legend>
                <?php if (filled($brandList)) foreach($brandList as $brand) { ?>
                  <div class="form-check">
                    <input <?php if ($brand["selected"]) { ?>checked<?php } ?> type="checkbox" class="form-check-input" id="brandOption<?php echo($brand["id"]); ?>" onclick="document.location='<?php echo($brand["link"]); ?>';" title="<?php echo($category["description"]); ?>">
                    <label class="form-check-label" for="brandOption<?php echo($brand["id"]); ?>" title="<?php echo($category["description"]); ?>"><?php echo($brand["name"]); ?></label>
                  </div>
                <?php } ?>
              </fieldset>
            </div>
            <div class="mainContentSecondColumn">
              <h2>Товари в категорії <?php echo ('"'.$selectedCategoryName.'" '.$selectedBrandsName.' ('.count(filled($productList) ? $productList : []).')'); ?></h2>
              <div class="alignCenterVert columnGap15 canWrap fullWidthContainer">
                <?php if (filled($sortOptions)) { ?>
                  Сортування:
                  <div>
                    <select class="form-select form-select-sm" onChange="document.location=this.value;">
                      <?php foreach ($sortOptions as $sort) { ?>
                        <option value="<?php echo($sort["link"]); ?>" <?php if ($sort["selected"]) { ?>selected<?php } ?>><?php echo($sort["name"]); ?></option>
                      <?php } ?>
                    </select>
                  </div>
                <?php } ?>
              </div>
              <div class="productItemsContainer">

                <?php if (filled($productList)) { ?>
                  <?php foreach($productList as $product) { ?>
                    <a href="product.php?id=<?php echo(filled($paramsString) ? $product["id"].'&'.$paramsString : $product["id"]) ?>" style="display: contents;">
                      <div class="productItem" <?php if (filled($product["image"])) { ?>style="background-image: URL('<?php echo(PATHFORUSERIMAGES.$product["image"]); ?>');"<?php } ?>>
                        <div class="productItemName">
                          <h4><?php echo($product["name"]); ?></h4>
                        </div>
                        <div class="productItemPrice">
                          <?php if ($product["value"] > 0) { ?>
                            <!-- Товар є в наявності -->
                            <div><strong><?php echo($product["price"]); ?></strong></div>
                            <svg style="fill: green;"><use href="templates/images_static/icon24_approve.svg#icon24"></use></svg>
                          <?php } else { ?>
                            <!-- Товара немає в наявності -->
                            <div style="color: gray;"><strong><?php echo($product["price"]); ?></strong></div>
                            <svg style="fill: red;"><use href="templates/images_static/icon24_close.svg#icon24"></use></svg>
                          <?php } ?>
                        </div>
                      </div>
                    </a>
                  <?php } ?>
                <?php } else { ?>
                  <h4>Не знайдено жодного товара із зазначеними параметрами</h4>
                <?php } ?>

              </div>
            </div>
          </div>

<?php include('footer.php'); ?>