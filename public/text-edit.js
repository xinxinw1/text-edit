/****** Online Text Editor ******/

var ver = "2.9.0";

function $(a){
  return document.getElementById(a);
}

if (navigator.userAgent.indexOf("Linux") != -1){
  $("name").style.font = "bold 16px \"DejaVu Sans Mono\", \"Courier New\", monospace";
  var arr = $("buttons").childNodes;
  for (var i = 0; i < arr.length; i++){
    if (arr[i].nodeType == 1)arr[i].style.font = "bold 16px \"DejaVu Sans Mono\", \"Courier New\", monospace";
  }
  $("text").style.font = "12px \"DejaVu Sans Mono\", \"Courier New\", monospace";
}

var origTitle = origName + " | Online Text Editor " + ver;
var newTitle = "*" + origTitle;

window.onload = function (){
  $("name").value = origName;
  $("text").value = origText;
  document.title = origTitle;
}

function go(name){
  window.location.assign("?name=" + encodeURIComponent(name));
}

if (writable){
  function checkSave(e){
    if (window.event)e = event;
    var key = (e.keyCode)?e.keyCode:-1;
    if (e.ctrlKey && key == 83){
      saveFile($("name").value, $("text").value);
      return false;
    }
  }
  
  function checkEdit(){
    if (origText != $("text").value){
      document.title = newTitle;
      $("save").disabled = false;
    } else {
      document.title = origTitle;
      $("save").disabled = true;
    }
  }
  
  document.onkeydown = checkSave;
  document.onkeyup = checkEdit;
  $("save").onclick = function (){
    saveFile($("name").value, $("text").value);
    return false;
  }
  
  window.onbeforeunload = function (){
    if (origText != $("text").value)return "Your changes have not been saved.";
  }
  
  function ajax(){
    if (window.XMLHttpRequest)return new XMLHttpRequest();
    return new ActiveXObject("Microsoft.XMLHTTP");
  }
  
  function apost(a, o, f){
    var attempts = 0;
    (function inner(){
      var x = ajax();
      x.onreadystatechange = function (){
        if (x.readyState == 4){
          if (x.status == 200){
            f(x.responseText);
          } else if (x.status == 0 || x.status == 12029){
            if (attempts == 3)alert("Can't save file! Check your internet. HTTP Status " + x.status);
            else setTimeout(inner, 1000);
          } else {
            alert("Can't save file! HTTP Status " + x.status);
          }
        }
      }
      x.open("POST", a, true);
      x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      x.send(o);
      attempts++;
    })();
  }
  
  function saveFile(name, text){
    apost("index.php",
          "name=" + encodeURIComponent(name) +
          "&text=" + encodeURIComponent(text),
          function (r){
            if (r != "")alert(r);
            else {
              origText = text;
              if (origName != name)go(name);
              checkEdit();
            }
          });
  }
}
