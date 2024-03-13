'use strict';
console.log('hello');
const toggleHidden = (...fields) => {

  fields.forEach((field) => {

    if (field.hidden === true) {

      field.hidden = false;

    } else {

      field.hidden = true;

    }
  });
};

const labelHidden = (form) => {

  form.addEventListener('focusout', (evt) => {

    const field = evt.target;
    const label = field.nextElementSibling;

    if (field.tagName === 'INPUT' && field.value && label) {

      label.hidden = true;

    } else if (label) {

      label.hidden = false;

    }
  });
};

const toggleDelivery = (elem) => {

  const delivery = elem.querySelector('.js-radio');
  const deliveryYes = elem.querySelector('.shop-page__delivery--yes');
  const deliveryNo = elem.querySelector('.shop-page__delivery--no');
  const fields = deliveryYes.querySelectorAll('.custom-form__input');

  delivery.addEventListener('change', (evt) => {

    if (evt.target.id === 'dev-no') {

      fields.forEach(inp => {
        if (inp.required === true) {
          inp.required = false;
        }
      });


      toggleHidden(deliveryYes, deliveryNo);

      deliveryNo.classList.add('fade');
      setTimeout(() => {
        deliveryNo.classList.remove('fade');
      }, 1000);

    } else {

      fields.forEach(inp => {
        if (inp.required === false) {
          inp.required = true;
        }
      });

      toggleHidden(deliveryYes, deliveryNo);

      deliveryYes.classList.add('fade');
      setTimeout(() => {
        deliveryYes.classList.remove('fade');
      }, 1000);
    }
  });
};

const filterWrapper = document.querySelector('.filter__list');
if (filterWrapper) {

  filterWrapper.addEventListener('click', evt => {

    const filterList = filterWrapper.querySelectorAll('.filter__list-item');

    filterList.forEach(filter => {

      if (filter.classList.contains('active')) {

        filter.classList.remove('active');

      }

    });

    const filter = evt.target;

    filter.classList.add('active');

  });

}

const shopList = document.querySelector('.shop__list');

if (shopList) {

  shopList.addEventListener('click', (evt) => {

    const prod = evt.path || (evt.composedPath && evt.composedPath());;

    if (prod.some(pathItem => pathItem.classList && pathItem.classList.contains('shop__item'))) {

      const shopOrder = document.querySelector('.shop-page__order');

      toggleHidden(document.querySelector('.intro'), document.querySelector('.shop'), shopOrder);

      window.scroll(0, 0);

      shopOrder.classList.add('fade');
      setTimeout(() => shopOrder.classList.remove('fade'), 1000);

      const form = shopOrder.querySelector('.custom-form');
      labelHidden(form);

      toggleDelivery(shopOrder);

      const buttonOrder = shopOrder.querySelector('.button');
      const popupEnd = document.querySelector('.shop-page__popup-end');

      buttonOrder.addEventListener('click', (evt) => {

        form.noValidate = true;

        const inputs = Array.from(shopOrder.querySelectorAll('[required]'));

        inputs.forEach(inp => {

          if (!!inp.value) {

            if (inp.classList.contains('custom-form__input--error')) {
              inp.classList.remove('custom-form__input--error');

            }

          } else {

            inp.classList.add('custom-form__input--error');

          }
        });

        if (inputs.every(inp => !!inp.value)) {

          evt.preventDefault();

          toggleHidden(shopOrder, popupEnd);

          popupEnd.classList.add('fade');
          setTimeout(() => popupEnd.classList.remove('fade'), 1000);

          window.scroll(0, 0);

          const buttonEnd = popupEnd.querySelector('.button');

          buttonEnd.addEventListener('click', () => {


            popupEnd.classList.add('fade-reverse');

            setTimeout(() => {

              popupEnd.classList.remove('fade-reverse');

              toggleHidden(popupEnd, document.querySelector('.intro'), document.querySelector('.shop'));

            }, 1000);

          });

        } else {
          window.scroll(0, 0);
          evt.preventDefault();
        }
      });
    }
  });
}

const pageOrderList = document.querySelector('.page-order__list');
if (pageOrderList) {

  pageOrderList.addEventListener('click', evt => {


    if (evt.target.classList && evt.target.classList.contains('order-item__toggle')) {
      var path = evt.path || (evt.composedPath && evt.composedPath());
      Array.from(path).forEach(element => {

        if (element.classList && element.classList.contains('page-order__item')) {

          element.classList.toggle('order-item--active');

        }

      });

      evt.target.classList.toggle('order-item__toggle--active');

    }

    if (evt.target.classList && evt.target.classList.contains('order-item__btn')) {

      const status = evt.target.previousElementSibling;
      const orderId = evt.target.getAttribute('data-attr');
      const changeOrderId = document.querySelector('#order-id');
      const orderStatus = document.querySelector('#order-current-status');
      if (status.classList && status.classList.contains('order-item__info--no')) {
        status.textContent = 'Выполнено';
        changeOrderId.name = 'order-id';
        orderStatus.name = 'order-status';
        changeOrderId.value = orderId;
        orderStatus.value = status.textContent;
        changeOrderStatus();
      } else {
        status.textContent = 'Не выполнено';
        changeOrderId.name = 'order-id';
        orderStatus.name = 'order-status';
        changeOrderId.value = orderId;
        orderStatus.value = status.textContent;
        changeOrderStatus();
      }

      status.classList.toggle('order-item__info--no');
      status.classList.toggle('order-item__info--yes');
    }


  });

}

const checkList = (list, btn) => {

  if (list.children.length === 1) {

    btn.hidden = false;

  } else {
    btn.hidden = true;
  }

};
const addList = document.querySelector('.add-list');

if (document.querySelector('.product-image')) {
  const addButton = addList.querySelector('.add-list__item--add');
  const productImage = document.querySelector('.product-image');
  productImage.addEventListener('click', evt => {
    addList.removeChild(evt.target);
    checkList(addList, addButton);
  });
}

if (addList) {

  const form = document.querySelector('.custom-form');
  labelHidden(form);

  const addButton = addList.querySelector('.add-list__item--add');
  const addInput = addList.querySelector('#product-photo');

  checkList(addList, addButton);

  addInput.addEventListener('change', evt => {

    const template = document.createElement('LI');
    const img = document.createElement('IMG');

    template.className = 'add-list__item add-list__item--active';
    template.addEventListener('click', evt => {
      addList.removeChild(evt.target);
      addInput.value = '';
      checkList(addList, addButton);
    });

    const file = evt.target.files[0];
    const reader = new FileReader();

    reader.onload = (evt) => {
      img.src = evt.target.result;
      template.appendChild(img);
      addList.appendChild(template);
      checkList(addList, addButton);
    };

    reader.readAsDataURL(file);

  });

}


const productsList = document.querySelector('.page-products__list');
if (productsList) {

  productsList.addEventListener('click', (evt) => {

    const target = evt.target;

    if (target.classList && target.classList.contains('product-item__delete')) {

      productsList.removeChild(target.parentElement);

    }

  });

}

// jquery range maxmin
if (document.querySelector('.shop-page')) {
  const minPrice = document.querySelector('.min-price').getAttribute('data-attr');
  const maxPrice = document.querySelector('.max-price').getAttribute('data-attr');
  const minBasePrice = document.querySelector('.min-price-value').getAttribute('data-attr');
  const maxBasePrice = document.querySelector('.max-price-value').getAttribute('data-attr');
  $('.range__line').slider({
    min: Number(minBasePrice),
    max: Number(maxBasePrice),
    values: [minPrice, maxPrice],
    range: true,
    stop: function (event, ui) {

      $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
      $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');

    },
    slide: function (event, ui) {

      $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
      $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');
      const min = document.querySelector('.min-price').textContent;
      const max = document.querySelector('.max-price').textContent;
      const minValue = document.querySelector('.min-price-value');
      const maxValue = document.querySelector('.max-price-value');
      minValue.value = ui.values[0];
      maxValue.value = ui.values[1];
    }
  });

  jQuery(function () {
    jQuery('#sort').change(function () {
      this.form.submit();
    });
  });

  jQuery(function () {
    jQuery('#order').change(function () {
      this.form.submit();
    });
  });
}

if (document.querySelector('.shop-page__order')) {
  const product = document.querySelectorAll('.shop__item');
  const productId = document.querySelector('.product_id');
  const select = document.querySelector('select');
  const street = document.querySelector('#street');
  $('#is-street').css("display", "none");
  if (product) {
    for (let i = 0; i < product.length; i++) {
      product[i].addEventListener('click', (evt) => {
        productId.value = product[i].getAttribute('data-attr');
      });
    }
  }

  const showHint = (str) => {
    $('#is-street').css("display", "block");
    if (str.length == 0) {
      return;
    } else {
      $.ajax({
        url: "/actions/ajax/select_street.php",
        method: "POST",
        data: $('#street').serialize(),
        dataType: "JSON",
        timeout: 3000,
        success: (data) => {
          if (data !== 'нет совпадений') {
            $(".search-street").remove();
            const documentFragment = $(document.createDocumentFragment());
            for (let i = 0; i < data.length; ++i) {
              const option = $('<option class="search-street" value="' + data[i] + '">' + data[i] + '</option>');
              documentFragment.append(option);
            }

            $('.custom-form__select').append(documentFragment);
            $('.custom-form__select').attr('size', data.length + 1);
            const streets = document.querySelectorAll('.search-street');
            const inputStreet = document.querySelector('#street');

            for (let i = 0; i < streets.length; i++) {
              streets[i].addEventListener('click', (evt) => {
                inputStreet.value = streets[i].value;
                $('#is-street').css("display", "none");
                $('.choose-street').css("display", "block");
              });
            }
          }

          if (data === 'нет совпадений') {
            $(".search-street").remove();
            const documentFragment = $(document.createDocumentFragment());
            const option = $('<option class="search-street" value="' + data + '">' + data + '</option>');
            documentFragment.append(option);
            $('.custom-form__select').append(documentFragment);
            $('.custom-form__select').attr('size', 2);
            $('.search-street').css("display", "block");
          }
        },
        error: (xhr) => {
          alert('Возникла ошибка: ' + xhr.responseCode);
        }
      });
    }
  }

  const listener = (event) => {
    showHint(event.key);
  };

  if (document.querySelector('input[name="delivery_method_id"]')) {
    document.querySelectorAll('input[name="delivery_method_id"]').forEach((elem) => {
      elem.addEventListener("change", function (evt) {
        if (evt.target.value === '2' || evt.target.value === '3') {
          street.addEventListener('keyup', listener, false);
        }
        if (evt.target.value === '1') {
          street.removeEventListener('keyup', listener, false);
          $(".search-street").remove();
          $('#is-street').css("display", "none");
          $('.custom-form__select').attr('size', 0);
          $('.search-street').css("display", "none");
        }
      });
    });
  }

  const validate = () => {
    const shopPageOrder = document.querySelector('.shop-page__order');
    const shopPopupEnd = document.querySelector('.shop-page__popup-end');
    shopPageOrder.hidden = false;
    shopPopupEnd.hidden = true;
  };

  const sendOrder = document.querySelector('#send_order');
  sendOrder.addEventListener('click', (evt) => {
    $.ajax({
      url: "/actions/ajax/add_order.php",
      method: "POST",
      data: $('#js-order').serialize(),
      dataType: "JSON",
      timeout: 3000,
      success: (data) => {
        if (data !== 'success') {
          validate();
        }
        $(".custom-span").remove();
        const documentFragment = $(document.createDocumentFragment());
        for (let i = 0; i < data.length; ++i) {
          const span = $('<span class="custom-span" style="color: red">' + data[i] + '</span>' + '<br class="custom-span">');
          documentFragment.append(span);
        }
        const orderForm = document.querySelector('.js-order');
        $('.custom-form__info').append(documentFragment);
      },
      error: (xhr) => {
        alert('Возникла ошибка: ' + xhr.responseCode);
      }
    });
  });
}

const changeOrderStatus = () => {
  if (document.querySelector('.page-order')) {
    $.ajax({
      url: "/actions/ajax/change_status.php",
      method: "POST",
      data: $('#order-status').serialize(),
      dataType: "JSON",
      timeout: 3000,
      success: 'success',
      error: (xhr) => {
        alert('Возникла ошибка: ' + xhr.responseCode);
      }
    });
  }
}

if (document.querySelector('#page-add')) {
  const newCheckbox = document.querySelector('#new');
  const saleCheckbox = document.querySelector('#sale');
  const form = document.querySelector('.custom-form');
  const popupEnd = document.querySelector('.page-add__popup-end');
  let newConsoleText = '';
  let saleConsoleText = '';
  const setNewConsoleValue = () => {
    if (newCheckbox.checked) {
      newConsoleText = newCheckbox.value;
    } else {
      newConsoleText = ``;
    }
  };

  const setSaleConsoleValue = () => {
    if (saleCheckbox.checked) {
      saleConsoleText = saleCheckbox.value;
    } else {
      saleConsoleText = ``;
    }
  }

  newCheckbox.addEventListener('change', () => {
    setNewConsoleValue();
  });

  saleCheckbox.addEventListener('change', () => {
    setSaleConsoleValue();
  });

  const addProduct = () => {
    form.hidden = true;
    popupEnd.hidden = false;
  };

  $(".button").click(function (evt) {
    evt.preventDefault();
    if (window.FormData === undefined) {
      alert('В вашем браузере FormData не поддерживается')
    } else {
      const formData = new FormData();
      formData.append('file', $("#product-photo")[0].files[0]);
      formData.append('name', $("#product-name").val());
      formData.append('price', $("#product-price").val());
      formData.append('category', $(".custom-form__select").val());
      formData.append('new', newConsoleText);
      formData.append('sale', saleConsoleText);
      $.ajax({
        type: "POST",
        url: '/actions/ajax/add_product.php',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        dataType: 'json',
        success: function (msg) {
          if (msg.errors.length === 0) {
            addProduct();
          } else {
            $(".custom-span").remove();
            const documentFragment = $(document.createDocumentFragment());
            for (let i = 0; i < msg.errors.length; ++i) {
              const span = $('<span class="custom-span" style="color: red">' + msg.errors[i] + '</span>' + '<br class="custom-span">');
              documentFragment.append(span);
            }
            $('.custom-form__info').append(documentFragment);
          }
        },
        error: (xhr) => {
          alert('Возникла ошибка: ' + xhr.responseCode);
        }
      });
    }
  });
}

if (document.querySelector('.page-products')) {
  const productItem = document.querySelectorAll('.product-item__delete');
  const productId = document.querySelector('.product_id');
  if (productItem) {
    for (let i = 0; i < productItem.length; i++) {
      productItem[i].addEventListener('click', (evt) => {
        productId.value = productItem[i].getAttribute('data-attr');
        deleteProduct();
      });
    }
  }

  const deleteProduct = () => {
    $.ajax({
      url: "/actions/ajax/delete_product.php",
      method: "POST",
      data: $('#product_id').serialize(),
      dataType: "JSON",
      timeout: 3000,
      success: (data) => {
        const message = document.querySelector('.message');
        message.textContent = data;
        if (data === 'Произошла ошибка удаления') {
          message.style = `color: red`;
        } else {
          message.style = `color: green`;
        }
      },
      error: (xhr) => {
        alert('Возникла ошибка: ' + xhr.responseCode);
      }
    });
  }
}

if (document.querySelector('#page-update')) {
  const newCheckbox = document.querySelector('#new');
  const saleCheckbox = document.querySelector('#sale');
  const form = document.querySelector('.custom-form');
  const popupEnd = document.querySelector('.page-add__popup-end');
  let newConsoleText = '';
  let saleConsoleText = '';

  const setNewConsoleValue = () => {
    if (newCheckbox.checked) {
      newConsoleText = newCheckbox.value;
    } else {
      newConsoleText = ``;
    }
    return newConsoleText;
  };

  const setSaleConsoleValue = () => {
    if (saleCheckbox.checked) {
      saleConsoleText = saleCheckbox.value;
    } else {
      saleConsoleText = ``;
    }
    return saleConsoleText;
  }

  newConsoleText = setNewConsoleValue();
  saleConsoleText = setSaleConsoleValue();

  newCheckbox.addEventListener('change', () => {
    setNewConsoleValue();
  });

  saleCheckbox.addEventListener('change', () => {
    setSaleConsoleValue();
  });

  const addProduct = () => {
    form.hidden = true;
    popupEnd.hidden = false;
  };

  $(".button").click(function (evt) {
    evt.preventDefault();
    if (window.FormData === undefined) {
      alert('В вашем браузере FormData не поддерживается')
    } else {
      const formData = new FormData();
      formData.append('file', $("#product-photo")[0].files[0]);
      formData.append('id', $("#product-id").val());
      formData.append('default_image_name', $(".default-image").val());
      formData.append('name', $("#product-name").val());
      formData.append('price', $("#product-price").val());
      formData.append('category', $(".custom-form__select").val());
      formData.append('new', newConsoleText);
      formData.append('sale', saleConsoleText);
      $.ajax({
        type: "POST",
        url: '/actions/ajax/update_product.php',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        dataType: 'json',
        success: function (msg) {
          if (msg.errors.length === 0) {
            addProduct();
          } else {
            $(".custom-span").remove();
            const documentFragment = $(document.createDocumentFragment());
            for (let i = 0; i < msg.errors.length; ++i) {
              const span = $('<span class="custom-span" style="color: red">' + msg.errors[i] + '</span>' + '<br class="custom-span">');
              documentFragment.append(span);
            }
            $('.custom-form__info').append(documentFragment);
          }
        },
        error: (xhr) => {
          alert('Возникла ошибка: ' + xhr.responseCode);
        }
      });
    }
  });
}

if (document.querySelector('.delivery-customization')) {
  const delivery = document.querySelector('.custom-form');
  const orderSum = document.querySelector('#order_sum');
  const deliveryPrice = document.querySelector('#delivery_price');
  const form = document.querySelector('.custom-form');
  const popupEnd = document.querySelector('.page-add__popup-end');
  delivery.value = '1';

  if (document.querySelector('input[name="delivery_method_id"]')) {
    document.querySelectorAll('input[name="delivery_method_id"]').forEach((elem) => {

      elem.addEventListener("change", function (evt) {
        delivery.value = evt.target.value;
        $.ajax({
          url: "/actions/ajax/delivery-values.php",
          method: "POST",
          data: $('#delivery').serialize(),
          dataType: "JSON",
          timeout: 3000,
          success: (data) => {
            if (data['order_sum'] && data['delivery_price']) {
              orderSum.value = data['order_sum'];
              deliveryPrice.value = data['delivery_price'];
            } else {
              alert('Возникла ошибка: попробуйте перегрузить страницу');
            }
          },
          error: (xhr) => {
            alert('Возникла ошибка: ' + xhr.responseCode);
          }
        });
      });
    });
  }

  const addProduct = () => {
    form.hidden = true;
    popupEnd.hidden = false;
  };

  $(".button").click(function (evt) {
    evt.preventDefault();
    if (window.FormData === undefined) {
      alert('В вашем браузере FormData не поддерживается')
    } else {
      const formData = new FormData();
      formData.append('order_sum', $("#order_sum").val());
      formData.append('delivery_price', $("#delivery_price").val());
      formData.append('delivery_value', delivery.value);
      $.ajax({
        type: "POST",
        url: '/actions/ajax/delivery-customization.php',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        dataType: 'json',
        success: function (msg) {
          if (msg.errors.length === 0) {
            addProduct();
          } else {
            $(".custom-span").remove();
            const documentFragment = $(document.createDocumentFragment());
            for (let i = 0; i < msg.errors.length; ++i) {
              const span = $('<span class="custom-span" style="color: red">' + msg.errors[i] + '</span>' + '<br class="custom-span">');
              documentFragment.append(span);
            }
            $('.custom-form__info').append(documentFragment);
          }
        },
        error: (xhr) => {
          alert('Возникла ошибка: ' + xhr.responseCode);
        }
      });
    }
  });
}
