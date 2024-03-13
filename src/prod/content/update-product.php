<main class="page-add" id="page-update">
  <h1 class="h h--1">Изменение товара</h1>
  <p class="custom-form__info"></p>
  <form class="custom-form" action="#" method="post">
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
      <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
        <input type="text" class="custom-form__input" name="product-name" 
        value="<?=$product['name']?>" id="product-name" placeholder="Название товара">
      </label>
      <label for="product-price" class="custom-form__input-wrapper">
        <input type="text" class="custom-form__input" name="product-price" 
        value="<?=$product['price']?>" id="product-price" placeholder="Цена товара">
      </label>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
      <ul class="add-list">
        <li class="add-list__item add-list__item--add">
          <input type="file" name="product-photo" id="product-photo" hidden="">
          <input type="hidden" name="id" value="<?=$product['id']?>" id="product-id">
          <label for="product-photo">Добавить фотографию</label>
        </li>
        <li class="add-list__item add-list__item--active product-image">
          <img src="/<?=$product['image']?>" alt="" id="product-image">
          <input type="hidden" name="default-photo" value="<?=$product['image']?>" class="default-image">
        </li>
      </ul>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Раздел</legend>
      <div class="page-add__select">
        <select name="category" class="custom-form__select" multiple="multiple">
          <option hidden="">Название раздела</option>
          <option value="female" <?=in_array('Женщины', $category) === true?'selected':''?>>Женщины</option>
          <option value="male" <?=in_array('Мужчины', $category) === true?'selected':''?>>Мужчины</option>
          <option value="children" <?=in_array('Дети', $category) === true?'selected':''?>>Дети</option>
          <option value="access" <?=in_array('Аксессуары', $category) === true?'selected':''?>>Аксессуары</option>
        </select>
      </div>
      <input type="checkbox" name="new" id="new" class="custom-form__checkbox" 
      <?=in_array('Новинка', $filter) === true ? 'checked' : '' ?>>
      <label for="new" class="custom-form__checkbox-label">Новинка</label>
      <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" <?=in_array('Распродажа', $filter) === true ? 'checked' : '' ?>>
      <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
    </fieldset>
    <button class="button" type="submit">Изменить товар</button>
  </form>
  <section class="shop-page__popup-end page-add__popup-end" hidden="">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно изменен</h2>
    </div>
  </section>
</main>
