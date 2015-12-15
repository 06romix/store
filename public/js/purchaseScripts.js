"use strict";

function addProductToBasket(id)
{
  $(document).ready(function(){
    var data = [];
    var quantity = +$('.orderForm input').val();
    data['status'] = 'success';
    data['message'] = 'Продукт добавленно в корзину';

    if (getCookie('basket[' + id + ']') == undefined) {
      setCookie('basket[' + id + ']', JSON.stringify({id: id, quantity: quantity}), {path: '/'});
      updateBasket(quantity);
      showMessage(data);

    } else {
      var product = JSON.parse(getCookie('basket[' + id + ']'));
      product.quantity += +quantity;
      if (checkQuantity(product.quantity)) {
        setCookie('basket[' + id + ']', JSON.stringify({id: id, quantity: product.quantity}), {path: '/'});
        updateBasket(quantity);
        showMessage(data);
      }
    }
  });
}

function deleteProductFromBasket(id, qua)
{
  if (getCookie('basket[' + id + ']') == undefined) return false;
  var product = JSON.parse(getCookie('basket[' + id + ']'));
  if (+qua < +product.quantity) {
    setCookie('basket[' + id + ']', JSON.stringify({id: id, quantity: +product.quantity - +qua}), {path: '/'});
    return true;
  } else {
    if (+qua == +product.quantity) {
      deleteCookie('basket[' + id + ']');
      return true;
    }
    return false;
  }
}

function updateBasket(quantity)
{
  var span = $('.count');
  span.text(+span.text() + +quantity);

  $.post('/updateBasket/', {}, function(jsonData){
    $('.basketProductList').html($.parseJSON(jsonData));
  });
}

function checkQuantity(quantity)
{
  var button = $('#addToBesket');
  if (!quantity) {
    quantity = +$('.orderForm input').val();
  }
  if ( +$("#stoke").text() < quantity ) {
    button.attr('disabled', true);
    makeFormMessage();
    return false;
  } else {
    button.attr('disabled', false);
    return true;
  }
}

function makeFormMessage()
{
  $('.orderQuantity').prepend('<label for="quantity" generated="true" class="error">Невірна кількість товару.</label>');
}

function showMessage(data)
{
  var div = '';
  if (data.status == 'success'){
    div = '<div class="array alert-dismissable alert-success">'
      + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
      + '<ul><li>' + data.message + '</li></ul></div>';
  } else {
    div = '<div class="array alert-dismissable alert-danger">'
      + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
      + '<ul><li>' + data.message + '</li></ul></div>';
  }
  $(div).insertAfter('.filtersLine')
}

// возвращает cookie с именем name, если есть, если нет, то undefined
function getCookie(name) {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

// устанавливает cookie c именем name и значением value
// options - объект с свойствами cookie (expires, path, domain, secure)
function setCookie(name, value, options) {
  options = options || {};

  var expires = options.expires;

  if (typeof expires == "number" && expires) {
    var d = new Date();
    d.setTime(d.getTime() + expires * 1000);
    expires = options.expires = d;
  }
  if (expires && expires.toUTCString) {
    options.expires = expires.toUTCString();
  }

  value = encodeURIComponent(value);

  var updatedCookie = name + "=" + value;

  for (var propName in options) {
    updatedCookie += "; " + propName;
    var propValue = options[propName];
    if (propValue !== true) {
      updatedCookie += "=" + propValue;
    }
  }

  document.cookie = updatedCookie;
}

// удаляет cookie с именем name
function deleteCookie(name) {
  setCookie(name, "", {
    expires: -1
  })
}