<?php include('header.php'); ?>

          <div class="mainContentAsTwoColumns">
            <div class="mainContentFirstColumn">
              <a href="index.php<? if (filled($paramsString)) echo('?'.$paramsString); ?>"><h4><< Назад</h4></a>
              <? if (filled($brand)) { ?><a href="index.php?brand=<?=$brand["id"]?>">Товари бренду "<?=$brand["name"]?>"</a><? } ?>
              <? if (filled($category)) { ?><a href="index.php?category=<?=$category["id"]?>">Товари категорії "<?=$category["name"]?>"</a><? } ?>
              <? if (filled($relevantProducts)) { ?>
                <h6>Рекомендовані товари:</h6>
                <div class="productItemsContainerSmallItems">
                  <? foreach($relevantProducts as $relItem) { ?>
                    <a href="product.php?id=<? echo($relItem["id"].'&'.$paramsString) ?>">
                      <div class="productItem smallItem" <? if (filled($relItem["image"])) { ?>style="background-image: URL('<?=PATHFORUSERIMAGES.$relItem["image"]?>');"<? } ?>>
                        <div class="productItemName">
                          <h5><?=$relItem["name"]?></h5>
                        </div>
                        <div class="productItemPrice">
                          <div><?=$relItem["price"]?></div>
                        </div>
                      </div>
                    </a>
                  <? } ?>
                </div>
              <? } ?>
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