/****** Online Text Editor 1.2 ******/

function $(a){
  return document.getElementById(a);
}

if (navigator.userAgent.indexOf("Linux") != -1){
  $("name").style.font = "bold 16px \"DejaVu Sans Mono\"";
  $("text").style.font = "12px \"DejaVu Sans Mono\"";
}

function checkSave(e){
  if (window.event)e = event;
  var key = (e.keyCode)?e.keyCode:-1;
  if (e.ctrlKey && key == 83){
    saveFile($("name").value, $("text").value);
    origName = $("name").value;
    origText = $("text").value;
    return false;
  }
}

document.onkeydown = checkSave;

window.onbeforeunload = function (){
  if (origName != $("name").value)return "You changes have not been saved.";
  if (origText != $("text").value)return "You changes have not been saved.";
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
