<main class="page-add delivery-customization" id="delivery-customization">
  <h1 class="h h--1">Настройки доставки</h1>
  <p class="custom-form__info"></p>
  <form class="custom-form" action="#" method="post" id="delivery">
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Если выбран способ доставки “Курьерская доставка” и сумма заказа менее ... рублей</legend>
        <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
        <input type="text" class="custom-form__input" name="order_sum" id="order_sum" placeholder="Сумма заказа" value="<?=$showSetting['order_sum']?>">
      </label>
      </fieldset>
      <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Стоимость заказа увеличивается на стоимость доставки – ... рублей</legend>
        <label for="product-price" class="custom-form__input-wrapper">
        <input type="text" class="custom-form__input" name="delivery_price" id="delivery_price" placeholder="Стоимость доставки" value="<?=$showSetting['delivery_price']?>">
      </label>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <input type="radio" name="delivery_method_id" id="standard-delivery" class="custom-form__checkbox" value="1" checked>
      <label for="standard-delivery" class="custom-form__checkbox-label">Стандартная доставка</label>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <input type="radio" name="delivery_method_id" id="day-of-purchase" class="custom-form__checkbox" value="2">
      <label for="day-of-purchase" class="custom-form__checkbox-label">В день покупки для жителей по Москве в пределах МКАД</label>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <input type="radio" name="delivery_method_id" id="delivery-in-moscow" class="custom-form__checkbox" value="3">
      <label for="delivery-in-moscow" class="custom-form__checkbox-label">Доставка с примеркой перед покупкой по Москве в пределах МКАД</label>
    </fieldset>
    <!-- <input type="hidden" name="delivery-method" class="custom-form"> -->
    <button class="button" id="send-product" type="submit">Изменить настройки</button>
  </form>
  <section class="shop-page__popup-end page-add__popup-end" hidden="">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Настройки успешно изменены</h2>
    </div>
  </section>
</main>