<?php include('header.php'); ?>

          <div class="mainContentAsSingleColumn">
            <h2>Адміністрування. Редагування довідника "<?=$dictName?>".</h2>

            <? if (filled($itemsList)) { ?>
              <? foreach ($itemsList as $dictElem) { ?>
                <div class="columnGap15 canWrap fullWidthContainer">
                  <div class="propertySelectGroup">
                    <div class="input-group">
                      <span class="input-group-text" id="dictElem<?=$dictElem["id"]?>Name">Назва:</span>
                      <input disabled type="text" value="<?=$dictElem["name"]?>" class="form-control" id="dictElem<?=$dictElem["id"]?>NameInput" aria-describedby="dictElem<?=$dictElem["id"]?>Name">
                      <div class="invalid-feedback" id="dictElem<?=$dictElem["id"]?>Error">
                        Текст помилки
                      </div>
                    </div>
                  </div>
                  <div class="propertySelectGroup">
                    <div class="input-group">
                      <span class="input-group-text" id="dictElem<?=$dictElem["id"]?>Description">Опис:</span>
                      <input disabled type="text" value="<?=$dictElem["description"]?>" class="form-control" id="dictElem<?=$dictElem["id"]?>DescriptionInput" aria-describedby="dictElem<?=$dictElem["id"]?>Description">
                      <div class="invalid-feedback" id="dictElem<?=$dictElem["id"]?>Error">
                        Текст помилки
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-outline-primary" type="button">Редагувати</button>
                  <button class="btn btn-outline-danger" type="button">Видалити</button>
                  <button class="btn btn-primary zbHidden" type="button">Зберегти</button>
                  <button class="btn btn-primary zbHidden" type="button">Скасувати</button>
                </div>
              <? } ?>
            <? } else { ?>
              <h4>Довідник порожній</h4>
            <? } ?>

            <div></div>
            <div class="columnGap15 canWrap fullWidthContainer">
              <button class="btn btn-primary" type="button">Додати елемент</button>
            </div>
            

          </div>

<?php include('footer.php'); ?>