<?php include('header.php'); ?>

          <div class="mainContentAsTwoColumns">
            <div class="mainContentFirstColumn">
              <fieldset class="mb-3">
                <legend><h4>Категорії:</h4></legend>
                <? if (filled($categoriesList)) foreach($categoriesList as $category) { ?>
                  <div class="form-check">
                    <input <? if ($category["selected"]) { ?>checked<? } ?> type="radio" name="radios" class="form-check-input" id="catOption<?=$category["id"]?>" onclick="document.location='<?=$category["link"]?>';" title="<?=$category["description"]?>">
                    <label class="form-check-label" for="catOption<?=$category["id"]?>" title="<?=$category["description"]?>"><?=$category["name"]?></label>
                  </div>
                <? } ?>
              </fieldset>
              <fieldset class="mb-3">
                <legend><h4>Бренди:</h4></legend>
                <? if (filled($brandList)) foreach($brandList as $brand) { ?>
                  <div class="form-check">
                    <input <? if ($brand["selected"]) { ?>checked<? } ?> type="checkbox" class="form-check-input" id="brandOption<?=$brand["id"]?>" onclick="document.location='<?=$brand["link"]?>';" title="<?=$category["description"]?>">
                    <label class="form-check-label" for="brandOption<?=$brand["id"]?>" title="<?=$category["description"]?>"><?=$brand["name"]?></label>
                  </div>
                <? } ?>
              </fieldset>
            </div>
            <div class="mainContentSecondColumn">
              <h2>Товари в категорії "Корм" брендів "Chappi", "Royal Canin" (18)</h2>
              <div class="alignCenterVert columnGap15 canWrap fullWidthContainer">
                <? if (filled($sortOptions)) { ?>
                  Сортування:
                  <div>
                    <select class="form-select form-select-sm" onChange="document.location=this.value;">
                      <? foreach ($sortOptions as $sort) { ?>
                        <option value="<?=$sort["link"]?>" <? if ($sort["selected"]) { ?>selected<? } ?>><?=$sort["name"]?></option>
                      <? } ?>
                    </select>
                  </div>
                <? } ?>
              </div>
              <div class="productItemsContainer">

                <? if (filled($productList)) { ?>
                  <? foreach($productList as $product) { ?>
                    <a href="product.php?id=<? echo(filled($paramsString) ? $product["id"].'&'.$paramsString : $product["id"]) ?>" style="display: contents;">
                      <div class="productItem" <? if (filled($product["image"])) { ?>style="background-image: URL('<?=PATHFORUSERIMAGES.$product["image"]?>');"<? } ?>>
                        <div class="productItemName">
                          <h4><?=$product["name"]?></h4>
                        </div>
                        <div class="productItemPrice">
                          <? if ($product["value"] > 0) { ?>
                            <!-- Товар є в наявності -->
                            <div><strong><?=$product["price"]?></strong></div>
                            <svg style="fill: green;"><use href="templates/images_static/icon24_approve.svg#icon24"></use></svg>
                          <? } else { ?>
                            <!-- Товара немає в наявності -->
                            <div style="color: gray;"><strong><?=$product["price"]?></strong></div>
                            <svg style="fill: red;"><use href="templates/images_static/icon24_close.svg#icon24"></use></svg>
                          <? } ?>
                        </div>
                      </div>
                    </a>
                  <? } ?>
                <? } else { ?>
                  <h4>Не знайдено жодного товара із зазначеними параметрами</h4>
                <? } ?>

              </div>
            </div>
          </div>

<?php include('footer.php'); ?>