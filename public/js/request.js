'use strict';
var apiV = 0.1;


var json = 'json=' + JSON.stringify({
  name: "Роман",
  surname: "Р"
});

var json1 = JSON.stringify({
    name: "Роман",
    surname: "Р"
  });

function methodGet(resource, param)
{
  if (typeof param == 'number') param += '/';
  if (typeof resource == 'string') resource += '/';
  var xhr = new XMLHttpRequest();
  xhr.open('GET', '/api/' + apiV + '/' + resource + param, true);
  xhr.send();
  xhr.onload = function(){status(xhr);}
}

function methodPost()
{
  var xhr = new XMLHttpRequest();
  xhr.open('POST', '/api/' + apiV + '/products/', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send(json);
  xhr.onload = function(){status(xhr);}
}

function methodPut()
{
  var xhr = new XMLHttpRequest();
  xhr.open('PUT', '/api/' + apiV + '/products/', true);
  xhr.send(json1);
  xhr.onload = function(){status(xhr);}
}

function methodDelete()
{
  var xhr = new XMLHttpRequest();
  xhr.open('DELETE', '/api/' + apiV + '/products/', true);
  xhr.send();
  xhr.onload = function(){status(xhr);}
}

function status(xhr)
{
  if (xhr.status != 200) {
    console.log( xhr.status + ': ' + xhr.statusText );
  } else {
    console.log( JSON.parse(xhr.responseText) );
  }
}
