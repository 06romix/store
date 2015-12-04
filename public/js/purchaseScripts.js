"use strict";
$(document).ready(function(){

  $.validator.addMethod("equalToStoke", function(value, element) {
      return $("#stoke").text() >= value;
    },
    "Не вірна кількість");


  $('#orderForm').validate({
    rules: {
      quantity: {
        equalToStoke: true,
        required: true
      }
    },
    messages: {
      quantity: {
        required: 'Не вірна кількість'
      }
    }

  });

});