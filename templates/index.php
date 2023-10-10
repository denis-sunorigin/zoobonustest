<?php include('header.php'); ?>

          <div class="mainContentAsTwoColumns">
            <div class="mainContentFirstColumn">
              <fieldset class="mb-3">
                <legend><h4>Категорії:</h4></legend>
                <? if (filled($categoriesList)) foreach($categoriesList as $category) { ?>
                  <div class="form-check">
                    <input type="radio" name="radios" class="form-check-input" id="catOption<?=$category["id"]?>">
                    <label class="form-check-label" for="catOption<?=$category["id"]?>"><?=$category["name"]?></label>
                  </div>
                <? } ?>
              </fieldset>
              <fieldset class="mb-3">
                <legend><h4>Бренди:</h4></legend>
                <? if (filled($brandList)) foreach($brandList as $brand) if ($brand["id"] != 1) { ?>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="brandOption<?=$brand["id"]?>">
                    <label class="form-check-label" for="brandOption<?=$brand["id"]?>"><?=$brand["name"]?></label>
                  </div>
                <? } ?>
              </fieldset>
            </div>
            <div class="mainContentSecondColumn">
              <h2>Товари в категорії "Корм" брендів "Chappi", "Royal Canin" (18)</h2>
              <div class="alignCenterVert columnGap15 canWrap fullWidthContainer">
                Сортування:
                <div>
                  <select class="form-select form-select-sm">
                    <option value="1" selected>Зростання ціни</option>
                    <option value="2">Зменшення ціни</option>
                    <option value="3">Назва</option>
                  </select>
                </div>
              </div>
              <div class="productItemsContainer">

                <? if (filled($productList)) { ?>
                  <? foreach($productList as $product) { ?>
                    <a href="#">
                      <div class="productItem" style="background-image: URL('<?=PATHFORUSERIMAGES.$product["image"]?>');">
                        <div class="productItemName">
                          <h4><?=$product["name"]?></h4>
                        </div>
                        <div class="productItemPrice">
                          <div><strong><?=$product["price"]?></strong></div>
                          <svg style="fill: green;"><use href="templates/images_static/icon24_approve.svg#icon24"></use></svg>
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