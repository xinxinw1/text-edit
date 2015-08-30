/****** Online Text Editor 1.0 ******/

function $(a){
  return document.getElementById(a);
}

var ctrlDown = false;

function checkCtrlDown(e){
  if (window.event)e = event;
  if (e.ctrlKey)ctrlDown = true;
}

function checkCtrlUp(e){
  if (window.event)e = event;
  if (e.ctrlKey)ctrlDown = false;
}

function checkSave(e){
  if (window.event)e = event;
  var key = (e.keyCode)?e.keyCode:-1;
  var chr = (e.charCode)?e.charCode:-1;
  if (ctrlDown && (key == 83 || chr == 115)){
    saveFile($("name").value, $("text").value);
    origName = $("name").value;
    origText = $("text").value;
    return false;
  }
}

document.onkeydown = checkCtrlDown;
document.onkeyup = checkCtrlUp;
document.onkeypress = checkSave;

window.onbeforeunload = function (){
  if (origName != $("name").value)return false;
  if (origText != $("text").value)return false;
}

function saveFile(name, text){
  var file = "text-edit.php";
  var param = "name=" + encodeURIComponent(name);
  param += "&text=" + encodeURIComponent(text);
  var func = function (resp){
    if (resp != "")alert(resp);
  }
  
  ajaxRequest(file, param, func);
}

function ajaxRequest(file, param, func){
  var ajax;
  if (window.XMLHttpRequest){
    ajax = new XMLHttpRequest();
  } else {
    ajax = new ActiveXObject("Microsoft.XMLHTTP");
  }
  
  ajax.onreadystatechange = function (){
    if (ajax.readyState == 4){
      if (ajax.status == 200){
        func(ajax.responseText);
      } else {
        alert("An error has occurred! Status: " + ajax.status);
      }
    }
  }
  
  ajax.open("POST", file, true);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.send(param);
}
