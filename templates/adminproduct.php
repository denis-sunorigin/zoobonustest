<?php include('header.php'); ?>

          <div class="mainContentAsSingleColumn">
            <h2>Адміністрування. Корм для чіхуахуа "Нямням".</h2>
            <div class="alignCenterVert columnGap15 canWrap fullWidthContainer mb-3">
              <a id="backLink" href="admincatalog.php<?php if (filled($paramsString)) echo('?'.$paramsString); ?>"><< повернутись до каталога</a>
            </div>
            <div class="input-group">
              <span class="input-group-text">Назва:</span>
              <input type="text" oninput="checkValue(this);" class="form-control" id="productNameInput" aria-describedby="property1" value="<?php echo($product["name"]); ?>">
              <div class="invalid-feedback" id="productNameError">
                Це обовʼязкове поле
              </div>
            </div>
            <div class="input-group">
              <span class="input-group-text">Опис:</span>
              <textarea rows="8" class="form-control" id="productDescriptionTextarea"><?php echo($product["description"]); ?></textarea>
            </div>
            <div class="columnGap15 canWrap fullWidthContainer">
              <div class="adminProductCardPhoto" id="adminProductCardPhoto" <?php if (filled($product["image"])) echo("data-file-path='".PATHFORUSERIMAGES.$product["image"]."' style=\"background-image: URL('".PATHFORUSERIMAGES.$product["image"]."');\""); ?>></div>
              <div class="propertySelectGroup rowGap15">
                <input type="file" accept=".jpg, .jpeg, .png" id="imageSelectInput" onchange="productImageSelectClick(this.files[0], <?php echo($product['id']); ?>); this.value=null;" style="display:none" />
                <button class="btn btn-primary btn-sm" type="button" onclick="document.getElementById('imageSelectInput').click();">Обрати зображення</button>
                <button class="btn btn-secondary btn-sm" type="button" onclick="productImageDeleteClick();">Видалити зображення</button>
              </div>
            </div>
            <div class="columnGap15 canWrap fullWidthContainer">
              <div class="propertySelectGroup">
                <label class="form-label">Бренд</label>
                <select class="form-select" data-brand-id="<?php echo($selectedBrandId); ?>" id="productBrandSelect" required onchange="this.dataset.brandId = this.options[this.selectedIndex].dataset.brandId;">
                  <?php foreach($brandList as $brand) { ?>
                    <option data-brand-id="<?php echo($brand["id"]); ?>" value="<?php echo($brand["name"]); ?>" <?php if ($brand["selected"]) echo("selected"); ?>><?php echo($brand["name"]); ?></option>
                  <?php } ?>
                </select>
                <div class="invalid-feedback">
                  Оберіть торгову марку
                </div>
              </div>
              <div class="propertySelectGroup">
                <label class="form-label">Категорія</label>
                <select class="form-select" data-category-id="<?php echo($selectedCategoryId); ?>" id="productCategorySelect" required onchange="this.dataset.categoryId = this.options[this.selectedIndex].dataset.categoryId;">
                  <?php foreach($categoryList as $category) { ?>
                    <option data-category-id="<?php echo($category["id"]); ?>" value="<?php echo($category["name"]); ?>" <?php if ($category["selected"]) echo("selected"); ?>><?php echo($category["name"]); ?></option>
                  <?php } ?>
                </select>
                <div class="invalid-feedback">
                  Оберіть категорію
                </div>
              </div>
              <div class="propertySelectGroup">
                <label class="form-label">Статус товару</label>
                  <select class="form-select" data-status-id="<?php echo($selectedStatusId); ?>" id="productStatusSelect" required onchange="this.dataset.statusId = this.options[this.selectedIndex].dataset.statusId;">
                  <!-- <option selected disabled value="">Оберіть статус...</option> -->
                  <?php foreach($statusList as $status) { ?>
                    <option data-status-id="<?php echo($status["id"]); ?>" value="<?php echo($status["name"]); ?>" <?php if ($status["selected"]) echo("selected"); ?>><?php echo($status["name"]); ?></option>
                  <?php } ?>
                </select>
                <div class="invalid-feedback">
                  Оберіть статус
                </div>
              </div>
            </div>
            <div class="columnGap15 canWrap fullWidthContainer">
              <div class="propertySelectGroup">
                <div class="input-group">
                  <span class="input-group-text">Кількість:</span>
                  <input type="number" class="form-control" id="productValueInput" aria-describedby="property2" value="<?php echo($product["value"]); ?>">
                  <div class="invalid-feedback">
                    Текст помилки
                  </div>
                </div>
              </div>
              <div class="propertySelectGroup">
                <div class="input-group">
                  <span class="input-group-text">Ціна:</span>
                  <input type="number" class="form-control" id="productPriceInput" aria-describedby="property3" value="<?php echo($product["price"]); ?>">
                  <span class="input-group-text">грн</span>
                  <div class="invalid-feedback">
                    Текст помилки
                  </div>
                </div>
              </div>
              <div class="propertySelectGroup">
                <div class="input-group">
                  <span class="input-group-text">Код 1С:</span>
                  <input type="text" class="form-control" id="productCode1CInput" aria-describedby="property4" value="<?php echo($product["code1c"]); ?>">
                  <div class="invalid-feedback">
                    Текст помилки
                  </div>
                </div>
              </div>
            </div>
            <div></div>
            <div class="columnGap15 canWrap fullWidthContainer">
              <button class="btn btn-primary" type="button" onclick="productSaveClick(<?php echo($product['id']); ?>);">Зберегти</button>
              <button class="btn btn-primary" type="button" onclick="productReloadDataClick(<?php echo($product['id']); ?>);">Скасувати зміни</button>
              <button class="btn btn-danger" type="button" onclick="productDeleteClick(<?php echo($product['id']); ?>);">Видалити товар</button>
            </div>
            

          </div>

<?php include('footer.php'); ?>