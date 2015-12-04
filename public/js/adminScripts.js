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
  $(div).insertAfter('#addProduct')
}

function removeEntity(id)
{
  console.log('remove');
  $('#' + id).hide(300, function(){
    this.remove();
    console.log('hide');
  });
}