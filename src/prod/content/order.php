<main class="page-order">
  <h1 class="h h--1">Список заказов</h1>
  <ul class="page-order__list">
  <?php foreach ($ordersList as $order): ?>
    <li class="order-item page-order__item">
      <div class="order-item__wrapper">
        <div class="order-item__group order-item__group--id">
          <span class="order-item__title">Номер заказа</span>
          <span class="order-item__info order-item__info--id"><?=$order['id']?></span>
        </div>
        <div class="order-item__group">
          <span class="order-item__title">Сумма заказа</span>
          <?=$order['price']?> руб.
        </div>
        <button class="order-item__toggle"></button>
      </div>
      <div class="order-item__wrapper">
        <div class="order-item__group order-item__group--margin">
          <span class="order-item__title">Заказчик</span>
          <span class="order-item__info">
            <?=htmlspecialchars($order['name']) . ' ' . htmlspecialchars($order['surname']) . ' ' . htmlspecialchars($order['thirdName'])?>
          </span>
        </div>
        <div class="order-item__group">
          <span class="order-item__title">Номер телефона</span>
          <span class="order-item__info">+<?=htmlspecialchars($order['phone'])?></span>
        </div>
        <div class="order-item__group">
          <span class="order-item__title">Способ доставки</span>
          <span class="order-item__info"><?=$order['delivery']?></span>
        </div>
        <div class="order-item__group">
          <span class="order-item__title">Способ оплаты</span>
          <span class="order-item__info"><?=$order['payment_method']?></span>
        </div>
        <div class="order-item__group order-item__group--status">
          <span class="order-item__title">Статус заказа</span>
          <span class="order-item__info <?=$order['status_style']?>">
            <?=$order['status_name']?>
          </span>
          <button class="order-item__btn" data-attr="<?=$order['id']?>">Изменить</button>
          <form id="order-status">
          <input id="order-id" type="hidden">
          <input id="order-current-status" type="hidden">
          </form>         
        </div>
      </div>
      <div class="order-item__wrapper">
        <div class="order-item__group">
          <span class="order-item__title">Адрес доставки</span>
          <span class="order-item__info">
          <?php if ($order['delivery'] === 'Курьерская доставка'): ?>
            <?='г.' . ' ' . htmlspecialchars($order['city']) . ' ' . 'ул.' . ' ' . htmlspecialchars($order['street']) . ' ' . 'кв.' . ' ' . htmlspecialchars($order['aprt'])?>
          <?php endif;?>
          </span>
        </div>
      </div>
      <div class="order-item__wrapper">
        <div class="order-item__group">
          <span class="order-item__title">Комментарий к заказу</span>
          <span class="order-item__info"><?=htmlspecialchars($order['comment'])?></span>
        </div>
      </div>
    </li>
  <?php endforeach;?>  
  </ul>
</main>
