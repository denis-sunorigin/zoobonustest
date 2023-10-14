<?php include('header.php'); ?>

          <?php if (filled($className)) echo("<script>var className='".$className."';</script>"); ?>

          <div class="mainContentAsSingleColumn">
            <h2>Адміністрування. Редагування довідника "<?php echo($dictName); ?>".</h2>

            <?php if (filled($itemsList)) { ?>
              <div>Видалити можна лише елементи, які не використовуються.</div>
              <?php foreach ($itemsList as $dictElem) { ?>
                <div class="columnGap15 canWrap fullWidthContainer" data-dict-elem-id="<?php echo($dictElem["id"]); ?>">
                  <div class="propertySelectGroup">
                    <div class="input-group">
                      <span class="input-group-text" id="dictElem<?php echo($dictElem["id"]); ?>Name">Назва:</span>
                      <input disabled type="text" value="<?php echo($dictElem["name"]); ?>" class="form-control nameInputTag" id="dictElem<?php echo($dictElem["id"]); ?>NameInput" aria-describedby="dictElem<?php echo($dictElem["id"]); ?>Name">
                      <div class="invalid-feedback" id="dictElem<?php echo($dictElem["id"]); ?>Error">
                        Текст помилки
                      </div>
                    </div>
                  </div>
                  <div class="propertySelectGroup">
                    <div class="input-group">
                      <span class="input-group-text" id="dictElem<?php echo($dictElem["id"]); ?>Description">Опис:</span>
                      <input disabled type="text" value="<?php echo($dictElem["description"]); ?>" class="form-control descriptionInputTag" id="dictElem<?php echo($dictElem["id"]); ?>DescriptionInput" aria-describedby="dictElem<?php echo($dictElem["id"]); ?>Description">
                      <div class="invalid-feedback" id="dictElem<?php echo($dictElem["id"]); ?>Error">
                        Текст помилки
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-outline-primary editButtonTag" type="button" onclick="dictElemBeginEditClick(this.parentElement);">Редагувати</button>
                  <?php if ($dictElem["deletable"]) { ?>
                    <button class="btn btn-outline-danger deleteButtonTag" type="button" onclick="dictElemDeleteClick(this.parentElement);">Видалити</button>
                  <?php } ?>
                  <button class="btn btn-primary zbHidden confirmButtonTag" type="button" onclick="dictElemConfirmChangesClick(this.parentElement);">Зберегти</button>
                  <button class="btn btn-primary zbHidden cancelButtonTag" type="button" onclick="dictElemCancelEditClick(this.parentElement);">Скасувати</button>
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