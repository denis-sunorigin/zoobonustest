<?php include('header.php'); ?>

          <div class="mainContentAsTwoColumns">
            <div class="mainContentFirstColumn">
              <a href="#"><h4><< Назад</h4></a>
              <a href="#">Товари бренду "Chappi"</a>
              <a href="#">Товари категорії "Корм для пташок"</a>
              <h6>Рекомендовані товари:</h6>
              <div class="productItemsContainerSmallItems">
                <a href="#">
                  <div class="productItem smallItem" style="background-image: URL('images_user/pic2.png');">
                    <div class="productItemName">
                      <h5>Корм "Chappi"</h5>
                    </div>
                    <div class="productItemPrice">
                      <div>9.99</div>
                    </div>
                  </div>
                </a>
                <a href="#">
                  <div class="productItem smallItem" style="background-image: URL('images_user/pic2.png');">
                    <div class="productItemName">
                      <h5>Корм "Chappi"</h5>
                    </div>
                    <div class="productItemPrice">
                      <div>9.99</div>
                    </div>
                  </div>
                </a>
                <a href="#">
                  <div class="productItem smallItem" style="background-image: URL('images_user/pic2.png');">
                    <div class="productItemName">
                      <h5>Корм "Chappi"</h5>
                    </div>
                    <div class="productItemPrice">
                      <div>9.99</div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <div class="mainContentSecondColumn">
              <? if (filled($product)) { ?>
                <h2><?=$product["name"]?></h2>
                <div class="productCardPhotoAndMainInfo">
                  <div class="productCardPhoto"<? if (filled($product["image"])) { ?> style="background-image: URL('<?=PATHFORUSERIMAGES.$product["image"]?>');"<? } ?>></div>
                  <div class="productCardMainInfo">
                    <div><h4>Ціна: <?=$product["price"]?> грн<h4></div>
                    <? if ($product["value"] > 0) { ?>
                      <div>Є в наявності (залишилось <?=$product["value"]?>)</div>
                    <? } else { ?>
                      <div>Немає в наявності</div>
                    <? } ?>
                    <div class="productCardCode1C">Код 1С: <?=$product["code1c"]?></div>
                  </div>
                </div>
                <div class="productCardDescription">
                  Опис:<br>
                  <?=$product["description"]?>
                </div>
              <? } else { ?>
                <h4>Відсутня інформація про продукт, можливо це застаріле посилання.</h4>
              <? } ?>
            </div>
          </div>

<?php include('footer.php'); ?>