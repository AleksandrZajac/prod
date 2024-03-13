
<main class="page-authorization">
  <h1 class="h h--1">Авторизация</h1>
  <?php 
    if ($isAuth) {
        require $_SERVER['DOCUMENT_ROOT'] . '/include/success.php';
    } elseif (!$isAuth && $isAuth !== null) {
        require $_SERVER['DOCUMENT_ROOT'] . '/include/error.php';
    }
  ?>
  <form class="custom-form" action="/admin" method="post">
    <input type="email" class="custom-form__input" name="email" 
      placeholder="Введите емайл" value="<?=$userLogin ?? ''?>">
    <input type="password" class="custom-form__input" name="password" 
      placeholder="Введите пароль" value="<?=$password ?? ''?>">
    <button class="button" type="submit">Войти в личный кабинет</button>
  </form>
</main>
