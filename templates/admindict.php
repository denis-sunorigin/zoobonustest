<?php include('header.php'); ?>

          <div class="mainContentAsSingleColumn">
            <h2>Адміністрування. Редагування довідника "<?php echo($dictName); ?>".</h2>

            <?php if (filled($itemsList)) { ?>
              <?php foreach ($itemsList as $dictElem) { ?>
                <div class="columnGap15 canWrap fullWidthContainer">
                  <div class="propertySelectGroup">
                    <div class="input-group">
                      <span class="input-group-text" id="dictElem<?php echo($dictElem["id"]); ?>Name">Назва:</span>
                      <input disabled type="text" value="<?php echo($dictElem["name"]); ?>" class="form-control" id="dictElem<?php echo($dictElem["id"]); ?>NameInput" aria-describedby="dictElem<?php echo($dictElem["id"]); ?>Name">
                      <div class="invalid-feedback" id="dictElem<?php echo($dictElem["id"]); ?>Error">
                        Текст помилки
                      </div>
                    </div>
                  </div>
                  <div class="propertySelectGroup">
                    <div class="input-group">
                      <span class="input-group-text" id="dictElem<?php echo($dictElem["id"]); ?>Description">Опис:</span>
                      <input disabled type="text" value="<?php echo($dictElem["description"]); ?>" class="form-control" id="dictElem<?php echo($dictElem["id"]); ?>DescriptionInput" aria-describedby="dictElem<?php echo($dictElem["id"]); ?>Description">
                      <div class="invalid-feedback" id="dictElem<?php echo($dictElem["id"]); ?>Error">
                        Текст помилки
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-outline-primary" type="button">Редагувати</button>
                  <button class="btn btn-outline-danger" type="button">Видалити</button>
                  <button class="btn btn-primary zbHidden" type="button">Зберегти</button>
                  <button class="btn btn-primary zbHidden" type="button">Скасувати</button>
                </div>
              <?php } ?>
            <?php } else { ?>
              <h4>Довідник порожній</h4>
            <?php } ?>

            <div></div>
            <div class="columnGap15 canWrap fullWidthContainer">
              <button class="btn btn-primary" type="button">Додати елемент</button>
            </div>
            

          </div>

<?php include('footer.php'); ?>