/****** Online Text Editor 2.0 ******/

/* requires tools 4.5.0 */
/* requires ajax 4.3.0 */

if (navigator.userAgent.indexOf("Linux") != -1){
  $("name").style.font = "bold 16px \"DejaVu Sans Mono\"";
  $("text").style.font = "12px \"DejaVu Sans Mono\"";
}

window.onload = function (){
  $("name").value = origName;
  $("text").value = origText;
  document.title = origName + " | Online Text Editor 2.0";
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
    if (origText != $("text").value)return "Your changes have not been saved.";
  }
  
  $.sefn(function (e){
    $.al("Can't save file! HTTP Status $1", e.data.status);
  });
  
  function saveFile(name, text){
    $.apost("text-edit.php",
            {name: encodeURIComponent(name), text: encodeURIComponent(text)},
            function (r){
              if (r != "")alert(r);
              else {
                origText = text;
                if (origName != name){
                  window.location.assign("text-edit.php?name=" + encodeURIComponent(name));
                }
              }
            });
  }
}
