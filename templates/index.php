<?php include('header.php'); ?>

          <div class="mainContentAsTwoColumns">
            <div class="mainContentFirstColumn">
              <fieldset class="mb-3">
                <legend><h4>Категорії:</h4></legend>
                <div class="form-check">
                  <input type="radio" name="radios" class="form-check-input" id="catOption1">
                  <label class="form-check-label" for="catOption1">Категорія 1</label>
                </div>
                <div class="mb-3 form-check">
                  <input type="radio" name="radios" class="form-check-input" id="catOption2">
                  <label class="form-check-label" for="catOption2">Категорія 2</label>
                </div>
              </fieldset>
              <fieldset class="mb-3">
                <legend><h4>Бренди:</h4></legend>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="brandOption1">
                  <label class="form-check-label" for="brandOption1">Chappi</label>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="brandOption2">
                  <label class="form-check-label" for="brandOption2">Royal Canin</label>
                </div>
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
                <a href="#">
                  <div class="productItem" style="background-image: URL('images_user/pic2.png');">
                    <div class="productItemName">
                      <h4>Корм "Chappi"</h4>
                    </div>
                    <div class="productItemPrice">
                      <div><strong>9.99</strong></div>
                      <svg style="fill: green;"><use href="templates/images_static/icon24_approve.svg#icon24"></use></svg>
                    </div>
                  </div>
                </a>
                <a href="#">
                  <div class="productItem" style="background-image: URL('images_user/pic4.png');">
                    <div class="productItemName">
                      <h4>Корм "Chappi"</h4>
                    </div>
                    <div class="productItemPrice">
                      <div style="color: gray;"><strong>9.99</strong></div>
                      <svg style="fill: red;"><use href="templates/images_static/icon24_close.svg#icon24"></use></svg>
                    </div>
                  </div>
                </a>
                <a href="#">
                  <div class="productItem">
                    <div class="productItemName">
                      <h4>Корм "Chappi"</h4>
                    </div>
                    <div class="productItemPrice">
                      <div><strong>9.99</strong></div>
                      <svg style="fill: green;"><use href="templates/images_static/icon24_approve.svg#icon24"></use></svg>
                    </div>
                  </div>
                </a>
                <a href="#">
                  <div class="productItem" style="background-image: URL('images_user/pic3.png');">
                    <div class="productItemName">
                      <h4>Корм "Chappi"</h4>
                    </div>
                    <div class="productItemPrice">
                      <div><strong>9.99</strong></div>
                      <svg style="fill: green;"><use href="templates/images_static/icon24_approve.svg#icon24"></use></svg>
                    </div>
                  </div>
                </a>
                <a href="#">
                  <div class="productItem" style="background-image: URL('images_user/pic5.png');">
                    <div class="productItemName">
                      <h4>Корм "Chappi"</h4>
                    </div>
                    <div class="productItemPrice">
                      <div><strong>9.99</strong></div>
                      <svg style="fill: green;"><use href="templates/images_static/icon24_approve.svg#icon24"></use></svg>
                    </div>
                  </div>
                </a>
                <a href="#">
                  <div class="productItem" style="background-image: URL('images_user/pic6.png');">
                    <div class="productItemName">
                      <h4>Корм "Chappi"</h4>
                    </div>
                    <div class="productItemPrice">
                      <div style="color: gray;"><strong>9.99</strong></div>
                      <svg style="fill: red;"><use href="templates/images_static/icon24_close.svg#icon24"></use></svg>
                    </div>
                  </div>
                </a>
                <a href="#">
                  <div class="productItem" style="background-image: URL('images_user/pic7.png');">
                    <div class="productItemName">
                      <h4>Корм "Chappi"</h4>
                    </div>
                    <div class="productItemPrice">
                      <div><strong>9.99</strong></div>
                      <svg style="fill: green;"><use href="templates/images_static/icon24_approve.svg#icon24"></use></svg>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>

<?php include('footer.php'); ?>