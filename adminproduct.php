<?php include('header.php'); ?>

          <div class="mainContentAsSingleColumn">
            <h2>Адміністрування. Корм для чіхуахуа "Нямням".</h2>
            <div class="alignCenterVert columnGap15 canWrap fullWidthContainer mb-3">
              <a href="#"><< повернутись до каталога</a>
            </div>
            <div class="input-group">
              <span class="input-group-text" id="property1">Назва:</span>
              <input type="text" class="form-control" id="property1input" aria-describedby="property1">
            </div>
            <div class="input-group">
              <span class="input-group-text">Опис:</span>
              <textarea rows="4" class="form-control"></textarea>
            </div>
            <div class="columnGap15 canWrap fullWidthContainer">
              <div class="adminProductCardPhoto" style="background-image: URL('images/pic2.png');"></div>
              <div class="propertySelectGroup rowGap15">
                <button class="btn btn-primary btn-sm" type="button">Обрати зображення</button>
                <button class="btn btn-secondary btn-sm" type="button">Видалити зображення</button>
              </div>
            </div>
            <div class="columnGap15 canWrap fullWidthContainer">
              <div class="propertySelectGroup">
                <label class="form-label">Бренд</label>
                <select class="form-select">
                  <option value="1">Бренд 1</option>
                  <option value="2">Chappi</option>
                  <option value="3">Royal Canin</option>
                </select>
                <div class="invalid-feedback">
                  Оберіть статус
                </div>
              </div>
              <div class="propertySelectGroup">
                <label class="form-label">Категорія</label>
                <select class="form-select is-invalid">
                  <option value="1" selected>Категорія 0</option>
                  <option value="2">Категорія 1</option>
                  <option value="3">Категорія 2</option>
                </select>
                <div class="invalid-feedback">
                  Оберіть статус
                </div>
              </div>
              <div class="propertySelectGroup">
                <label class="form-label">Статус товару</label>
                  <select class="form-select is-invalid" required>
                  <option selected disabled value="">Оберіть статус...</option>
                  <option value="1">Категорія 0</option>
                  <option value="2">Категорія 1</option>
                  <option value="3">Категорія 2</option>
                </select>
                <div class="invalid-feedback">
                  Оберіть статус
                </div>
              </div>
            </div>
            <div class="columnGap15 canWrap fullWidthContainer">
              <div class="propertySelectGroup">
                <div class="input-group">
                  <span class="input-group-text" id="property2">Кількість:</span>
                  <input type="number" class="form-control is-invalid" id="property2input" aria-describedby="property2">
                  <div class="invalid-feedback">
                    Оберіть статус
                  </div>
                </div>
              </div>
              <div class="propertySelectGroup">
                <div class="input-group">
                  <span class="input-group-text" id="property3">Ціна:</span>
                  <input type="number" class="form-control is-invalid" id="property3input" aria-describedby="property3">
                  <span class="input-group-text">грн</span>
                  <div class="invalid-feedback">
                    Оберіть статус
                  </div>
                </div>
              </div>
              <div class="propertySelectGroup">
                <div class="input-group">
                  <span class="input-group-text" id="property4">Код 1С:</span>
                  <input type="text" class="form-control is-invalid" id="property4input" aria-describedby="property4">
                  <div class="invalid-feedback">
                    Оберіть статус
                  </div>
                </div>
              </div>
            </div>
            <div></div>
            <div class="columnGap15 canWrap fullWidthContainer">
              <button class="btn btn-primary" type="button">Зберегти</button>
              <button class="btn btn-primary" type="button">Скасувати</button>
              <button class="btn btn-danger" type="button">Видалити товар</button>
            </div>
            

          </div>

<?php include('footer.php'); ?>