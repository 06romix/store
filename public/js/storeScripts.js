"use strict";

function selectSort(){
  $.post('/config/', {sort: $('#sort').val()}, function(){location.reload();});
}

function selectPagination(){
  $.post('/config/', {limit: $('#pagination').val()}, function(){location.reload();});
}
