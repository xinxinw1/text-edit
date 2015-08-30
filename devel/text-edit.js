/****** Online Text Editor Devel ******/

/* requires tools 1.x */
/* requires ajax 2.x */

if (navigator.userAgent.indexOf("Linux") != -1){
  $("name").style.font = "bold 16px \"DejaVu Sans Mono\"";
  $("text").style.font = "12px \"DejaVu Sans Mono\"";
}

window.onload = function (){
  $("name").value = origName;
  $("text").value = origText;
  document.title = origName + " | Online Text Editor Devel";
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
  
  document.onkeydown = checkSave;
  
  window.onbeforeunload = function (){
    if (origText != $("text").value)return "You changes have not been saved.";
  }
  
  function saveFile(name, text){
    var file = "text-edit.php";
    var param = "name=" + encodeURIComponent(name);
    param += "&text=" + encodeURIComponent(text);
    var func = function (resp){
      if (resp != "")alert(resp);
      else {
        origText = text;
        if (origName != name){
          window.location.assign("text-edit.php?name=" + encodeURIComponent(name));
        }
      }
    }
    var type = "POST";
    
    Ajax.sendRequest(file, param, func, type);
  }
}
