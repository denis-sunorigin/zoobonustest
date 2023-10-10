<?php include('header.php'); ?>

          <div class="mainContentAsTwoColumns">
            <div class="mainContentFirstColumn">
              <a href="index.php<?php if (filled($paramsString)) echo('?'.$paramsString); ?>"><h4><< Назад</h4></a>
              <?php if (filled($brand)) { ?><a href="index.php?brand=<?php echo($brand["id"]); ?>"><< Товари бренду "<?php echo($brand["name"]); ?>"</a><?php } ?>
              <?php if (filled($category)) { ?><a href="index.php?category=<?php echo($category["id"]); ?>"><< Товари категорії "<?php echo($category["name"]); ?>"</a><?php } ?>
              <?php if (filled($relevantProducts)) { ?>
                <h6>Рекомендовані товари:</h6>
                <div class="productItemsContainerSmallItems">
                  <?php foreach($relevantProducts as $relItem) { ?>
                    <a href="product.php?id=<?php echo($relItem["id"].'&'.$paramsString) ?>">
                      <div class="productItem smallItem" <?php if (filled($relItem["image"])) { ?>style="background-image: URL('<?php echo(PATHFORUSERIMAGES.$relItem["image"]); ?>');"<?php } ?>>
                        <div class="productItemName">
                          <h5><?php echo($relItem["name"]); ?></h5>
                        </div>
                        <div class="productItemPrice">
                          <div><?php echo($relItem["price"]); ?></div>
                        </div>
                      </div>
                    </a>
                  <?php } ?>
                </div>
              <?php } ?>
            </div>
            <div class="mainContentSecondColumn">
              <?php if (filled($product)) { ?>
                <h2><?php echo($product["name"]); ?></h2>
                <div class="productCardPhotoAndMainInfo">
                  <div class="productCardPhoto"<?php if (filled($product["image"])) { ?> style="background-image: URL('<?php echo(PATHFORUSERIMAGES.$product["image"]); ?>');"<?php } ?>></div>
                  <div class="productCardMainInfo">
                    <div><h4>Ціна: <?php echo($product["price"]); ?> грн<h4></div>
                    <?php if ($product["value"] > 0) { ?>
                      <div>Є в наявності (залишилось <?php echo($product["value"]); ?>)</div>
                    <?php } else { ?>
                      <div>Немає в наявності</div>
                    <?php } ?>
                    <div class="productCardCode1C">Код 1С: <?php echo($product["code1c"]); ?></div>
                  </div>
                </div>
                <div class="productCardDescription">
                  Опис:<br>
                  <?php echo($product["description"]); ?>
                </div>
              <?php } else { ?>
                <h4>Відсутня інформація про продукт, можливо це застаріле посилання.</h4>
              <?php } ?>
            </div>
          </div>

<?php include('footer.php'); ?>