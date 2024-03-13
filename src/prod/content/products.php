<main class="page-products">
  <h1 class="h h--1">Товары</h1>
  <a class="page-products__button button" href="/admin/add-product">Добавить товар</a>
  <p class="message"></p>
  <div class="page-products__header">
    <span class="page-products__header-field">Название товара</span>
    <span class="page-products__header-field">ID</span>
    <span class="page-products__header-field">Цена</span>
    <span class="page-products__header-field">Категория</span>
    <span class="page-products__header-field">Фильтр</span>
  </div>
  <ul class="page-products__list">
  <?php foreach ($productsList as $key => $value): ?>
    <li class="product-item page-products__item">
      <b class="product-item__name"><?=$value['name']?></b>
      <span class="product-item__field"><?=$value['id']?></span>
      <span class="product-item__field"><?=$value['price']?> руб.</span>
      <span class="product-item__field">
      <?php foreach ($value['category'] as $itemCategory): ?>
        <div>
          <?=$itemCategory?>
        </div>
      <?php endforeach;?>
      </span>
      <span class="product-item__field">
      <?php foreach ($value['filter'] as $itemFilter): ?>
        <div>
          <?=$itemFilter?>
        </div>
      <?php endforeach;?>
      </span>
      <a href="/admin/update-product/?id=<?=$value['id']?>" class="product-item__edit" aria-label="Редактировать"></a>
      <button class="product-item__delete" data-attr="<?=$value['id']?>"></button>
    </li>
  <?php endforeach;?>
  </ul>
  <form id="product_id"><input class="product_id" type="hidden" name="product_id"></form>
  <br>
  <ul class="shop__paginator paginator">
    <?php for ($i = 1; $i < $productOptions['total'] + 1; $i++): ?>
      <li>
        <a class="paginator__item" href="/admin/products/?page=<?=$i?>"><?=$i?></a>
      </li>
    <?php endfor;?>
  </ul>
</main>
