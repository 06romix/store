"use strict";
$(document).ready(function(){

  $.validator.addMethod("notnumbers", function(value, element) {
      console.log(!/[0-9]/.test(value));
      return !/[0-9]/.test(value);
    },
    "Please don't insert numbers.");

  $.validator.addMethod("mobTel", function(value, element) {
      //console.log(!/\+?[0-9 )(-]+/.test(value));
      return /\+?[0-9 )(-]+/.test(value);
    },
    "Введіть коректний номер.");

  $('#formR').validate({
    rules: {
      name: {
        required: true,
        rangelength: [2, 20]
      },
      email: {
        required: true,
        email: true,
        rangelength: [5, 50]
      },
      tel: {
        required: true,
        mobTel: true,
        rangelength: [10, 20]
      },
      pass: {
        required: true,
        rangelength: [5, 16]
      },
      rePass: {
        required: true,
        equalTo: "#password",
        rangelength: [5, 16]
      }
    },
    messages: {
      name: {
        required: 'Це поле обовязкове для заповнення.',
        rangelength: 'Довжинна поля 2-20 символів.'
      },
      email: {
        required: 'Це поле обовязкове для заповнення.',
        email: "Введіть коректний email."
      },
      tel: {
        required: 'Це поле обовязкове для заповнення.',
        rangelength: 'Довжинна поля 10-20 символів.'
      },
      pass: {
        required: 'Це поле обовязкове для заповнення.',
        rangelength: 'Довжинна поля 5-16 символів'
      },
      rePass: {
        required: 'Це поле обовязкове для заповнення.',
        rangelength: 'Довжинна поля 5-16 символів.',
        equalTo : 'Паролі не співпадають.'
      }
    }

  });

});

