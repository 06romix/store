"use strict";

function deleteProduct(id, name)
{
  if(confirm('Видалити продукт: ' + name)){
    $.post('delete/' + id + '/', {}, function(jsonData){
      console.log(jsonData);
      var data = $.parseJSON(jsonData);
      if (data.status == 'success') removeEntity(id);
      showMessage(data);
    });
  }
}



function showMessage(data)
{
  var newDiv = $('<div class="array alert-dismissable alert-success"></div>');
  var content = (data.status == 'success')
    ? '<ul><li>' + data.message + '</li></ul>'
    : '<ul><li>' + data.message + '</li></ul>';

  newDiv.html(content);

  newDiv.insertAfter('.filtersLine');

  setTimeout(function(){
    newDiv.animate({opacity: 0}, 1000, function(){
      newDiv.animate({'margin-top': '-20px'}, 500, function(){newDiv.remove();});
    });
  }, 500);
}

function removeEntity(id)
{
  console.log('remove');
  $('#' + id).hide(300, function(){
    this.remove();
    console.log('hide');
  });
}