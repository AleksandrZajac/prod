<main class="shop-page">
  <header class="intro">
    <div class="intro__wrapper">
      <h1 class=" intro__title">COATS</h1>
      <p class="intro__info">Collection 2018</p>
    </div>
  </header>
  <section class="shop container">
    <section class="shop__filter filter">
      <form action="<?=parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)?>" method="get">
      <div class="filter__wrapper">
        <b class="filter__title">Категории</b>
        <ul class="filter__list">
        <?php foreach ($catergories as $key => $value): ?>
          <li>
            <a class="filter__list-item <?=(isset($catergories[$key]['style'])) ? $catergories[$key]['style'] : '' ?>"
            href="/sale/category/<?=$catergories[$key]['path']?>"><?=$catergories[$key]['name']?></a>
          </li>
          <?php endforeach;?>
        </ul>
      </div>
        <div class="filter__wrapper">
          <b class="filter__title">Фильтры</b>
          <div class="filter__range range">
            <span class="range__info">Цена</span>
            <div class="range__line" aria-label="Range Line"></div>
            <div class="range__res">
              <span class="range__res-item min-price" data-attr="<?=minPrice($minBasePrice)?>"><?=minPrice($minBasePrice)?> руб.</span>
              <input type="hidden" class="min-price-value" name="min-price" data-attr="<?=$minBasePrice?>" value="<?=minPrice($minBasePrice)?>">
              <span class="range__res-item max-price" data-attr="<?=maxPrice($maxBasePrice)?>"><?=maxPrice($maxBasePrice)?> руб.</span>
              <input type="hidden" class="max-price-value" name="max-price" data-attr="<?=$maxBasePrice?>" value="<?=maxPrice($maxBasePrice)?>">
            </div>
          </div>
        </div>
        <button class="button" type="submit" style="width: 100%">Применить</button>
    </section>
    
    <div class="shop__wrapper">
    <section class="shop__sorting">
        <div class="shop__sorting-item custom-form__select-wrapper">
          <select class="custom-form__select sort" name="category" id="sort">
            <option hidden="" value="">Сортировка</option>
            <?php if (isset($_GET['category']) && $_GET['category'] === 'price'): ?>
            <option value="price" selected>По цене</option>
            <?php elseif (isset($_GET['category']) && $_GET['category'] !== 'price'): ?> 
            <option value="price">По цене</option>
            <?php elseif (!isset($_GET['category'])): ?> 
            <option value="price">По цене</option>
            <option value="name">По названию</option>
            <?php endif;?>
            <?php if (isset($_GET['category']) && $_GET['category'] === 'name'): ?>
            <option value="name" selected>По названию</option>
            <?php elseif (isset($_GET['category']) && $_GET['category'] !== 'name'): ?> 
            <option value="name">По названию</option>
            <?php endif;?>
          </select>
        </div>
        <div class="shop__sorting-item custom-form__select-wrapper">
          <select class="custom-form__select order" name="prices" id="order">
            <option hidden="" value="">Порядок</option>
            <?php if (isset($_GET['prices']) && $_GET['prices'] === 'asc'): ?>
            <option value="asc" selected>По возрастанию</option>
            <?php elseif (isset($_GET['prices']) && $_GET['prices'] !== 'asc'): ?> 
            <option value="asc">По возрастанию</option>
            <?php elseif (!isset($_GET['prices'])): ?> 
            <option value="asc">По возрастанию</option>
            <option value="desc">По убыванию</option>
            <?php endif;?>
            <?php if (isset($_GET['prices']) && $_GET['prices'] === 'desc'): ?>
            <option value="desc" selected>По убыванию</option>
            <?php elseif (isset($_GET['prices']) && $_GET['prices'] !== 'desc'): ?> 
            <option value="desc">По убыванию</option>
            <?php endif;?>
          </select>
          </form>
        </div>
        <p class="shop__sorting-res">Найдено <span class="res-sort"><?=$options['count']?></span> моделей</p>
      </section>
      <section class="shop__list">
      <?php foreach ($products as $key => $value): ?>
        <article class="shop__item product" tabindex="0" data-attr="<?=$products[$key]['id']?>">
          <div class="product__image">
            <img src="/<?=$products[$key]['image']?>" alt="product-name">
          </div>
          <p class="product__name"><?=$products[$key]['name']?></p>
          <span class="product__price"><?=$products[$key]['price']?> руб.</span>
        </article>
        <?php endforeach;?>
      </section>

      <ul class="shop__paginator paginator">
      <?php for ($i = 1; $i < $options['total'] + 1; $i++): ?>
        <?php if (!empty($options['count'])): ?>
        <li>
          <a class="paginator__item" href="<?=rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') . '?' . path() . $i?>"><?=$i?></a>
        </li>
        <?php endif;?>
      <?php endfor;?>
      </ul>

    </div>
  </section>
  <section class="shop-page__order" hidden="">
    <div class="shop-page__wrapper">
      <h2 class="h h--1">Оформление заказа</h2>
      <form action="#" method="post" class="custom-form js-order" id="js-order">
        <fieldset class="custom-form__group">
          <legend class="custom-form__title">Укажите свои личные данные</legend>
          <p class="custom-form__info">
            <span class="req">*</span> поля обязательные для заполнения<br>
          </p>
          <div class="custom-form__column">
            <label class="custom-form__input-wrapper" for="surname">
              <input id="surname" class="custom-form__input" type="text" name="surname" required="">
              <p class="custom-form__input-label">Фамилия <span class="req">*</span></p>
            </label>
            <label class="custom-form__input-wrapper" for="name">
              <input id="name" class="custom-form__input" type="text" name="name" required="">
              <p class="custom-form__input-label">Имя <span class="req">*</span></p>
            </label>
            <label class="custom-form__input-wrapper" for="thirdName">
              <input id="thirdName" class="custom-form__input" type="text" name="thirdName">
              <p class="custom-form__input-label">Отчество</p>
            </label>
            <label class="custom-form__input-wrapper" for="phone">
              <input id="phone" class="custom-form__input" type="tel" name="phone" required="">
              <p class="custom-form__input-label">Телефон <span class="req">*</span></p>
            </label>
            <label class="custom-form__input-wrapper" for="email">
              <input id="email" class="custom-form__input" type="email" name="email" required="">
              <p class="custom-form__input-label">Почта <span class="req">*</span></p>
            </label>
          </div>
        </fieldset>
        <fieldset class="custom-form__group js-radio">
          <legend class="custom-form__title custom-form__title--radio">Способ доставки</legend>
          <input id="dev-no" class="custom-form__radio" type="radio" name="delivery" value="dev-no" checked="">
          <label for="dev-no" class="custom-form__radio-label">Самовывоз</label>
          <input id="dev-yes" class="custom-form__radio" type="radio" name="delivery" value="dev-yes">
          <label for="dev-yes" class="custom-form__radio-label">Курьерная доставка</label>
        </fieldset>
        <div class="shop-page__delivery shop-page__delivery--no">
          <table class="custom-table">
            <caption class="custom-table__title">Пункт самовывоза</caption>
            <tr>
              <td class="custom-table__head">Адрес:</td>
              <td>Москва г, Тверская ул,<br> 4 Метро «Охотный ряд»</td>
            </tr>
            <tr>
              <td class="custom-table__head">Время работы:</td>
              <td>пн-вс 09:00-22:00</td>
            </tr>
            <tr>
              <td class="custom-table__head">Оплата:</td>
              <td>Наличными или банковской картой</td>
            </tr>
            <tr>
              <td class="custom-table__head">Срок доставки: </td>
              <td class="date">13 декабря—15 декабря</td>
            </tr>
          </table>
        </div>
        <div class="shop-page__delivery shop-page__delivery--yes" hidden="">
        <fieldset class="page-add__group custom-form__group">
            <input type="radio" name="delivery_method_id" id="standard-delivery" class="custom-form__checkbox" value="1" checked>
            <label for="standard-delivery" class="custom-form__checkbox-label"><?=$showDeliveryPrices[0]['description']?> <?=$showDeliveryPrices[0]['delivery_price']?> руб.</label>
          </fieldset>
          <fieldset class="page-add__group custom-form__group">
            <input type="radio" name="delivery_method_id" id="day-of-purchase" class="custom-form__checkbox" value="2">
            <label for="day-of-purchase" class="custom-form__checkbox-label"><?=$showDeliveryPrices[1]['description']?> <?=$showDeliveryPrices[1]['delivery_price']?> руб.</label>
          </fieldset>
          <fieldset class="page-add__group custom-form__group">
            <input type="radio" name="delivery_method_id" id="delivery-in-moscow" class="custom-form__checkbox" value="3">
           <label for="delivery-in-moscow" class="custom-form__checkbox-label"><?=$showDeliveryPrices[2]['description']?> <?=$showDeliveryPrices[2]['delivery_price']?> руб.</label>
          </fieldset>
          <fieldset class="custom-form__group">
            <legend class="custom-form__title">Адрес</legend>
              <span class="req">*</span> поля обязательные для заполнения
            </p>
            <div class="custom-form__row">
              <label class="custom-form__input-wrapper" for="city">
                <input id="city" class="custom-form__input" type="text" name="city">
                <p class="custom-form__input-label">Введите город<span class="req">*</span></p>
              </label>
              <label class="custom-form__input-wrapper" for="street">
                <input id="street" class="custom-form__input" type="text" name="street">
                <p class="custom-form__input-label">Введите улицу<span class="req">*</span></p>
              </label>
              <div class="custom-form__input-wrapper select-container" id="is-street" style="width: 100%;">
                <select class="custom-form__select" name="is-street">
                <option class="choose-street" style="background-color: rgb(206, 206, 206); color: rgb(16, 16, 16);">Выберите улицу</option>
                </select>
              </div>
              <label class="custom-form__input-wrapper" for="home">
                <input id="home" class="custom-form__input custom-form__input--small" type="text" name="home">
                <p class="custom-form__input-label">Дом <span class="req">*</span></p>
              </label>
              <label class="custom-form__input-wrapper" for="aprt">
                <input id="aprt" class="custom-form__input custom-form__input--small" type="text" name="aprt">
                <p class="custom-form__input-label">Квартира <span class="req">*</span></p>
              </label>
            </div>
          </fieldset>
        </div>
        <div><input class="product_id" type="hidden" name="product_id"></div>
        <fieldset class="custom-form__group shop-page__pay">
          <legend class="custom-form__title custom-form__title--radio">Способ оплаты</legend>
          <input id="cash" class="custom-form__radio" type="radio" name="pay" value="cash">
          <label for="cash" class="custom-form__radio-label">Наличные</label>
          <input id="card" class="custom-form__radio" type="radio" name="pay" value="card" checked="">
          <label for="card" class="custom-form__radio-label">Банковской картой</label>
        </fieldset>
        <fieldset class="custom-form__group shop-page__comment">
          <legend class="custom-form__title custom-form__title--comment">Комментарии к заказу</legend>
          <textarea class="custom-form__textarea" name="comment"></textarea>
        </fieldset>
        <button id="send_order" class="button" type="submit">Отправить заказ</button>
      </form>
    </div>
  </section>
  <section class="shop-page__popup-end" hidden="">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Спасибо за заказ!</h2>
      <p class="shop-page__end-message">Ваш заказ успешно оформлен, с вами свяжутся в ближайшее время</p>
      <button class="button" onclick="document.location='/'">Продолжить покупки</button>
    </div>
  </section>
</main>
