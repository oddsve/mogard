  var timeout    = 500;
  var closetimer = 0;
  var ddmenuitem = 0;
  
  function jsddm_open()
  {  jsddm_canceltimer();
     jsddm_close();
     ddmenuitem = $(this).find('ul').css('visibility', 'visible');}

 function jsddm_close() {

     if (ddmenuitem) ddmenuitem.css('visibility', 'hidden');
   };
  
  function jsddm_timer()
  {  closetimer = window.setTimeout(jsddm_close, timeout);}
  
  function jsddm_canceltimer()
  {  if(closetimer)
     {  window.clearTimeout(closetimer);
        closetimer = null;}}


        $(document).ready(function () {
            $(document).bind('touchend', function (event) { if( event.target.nodeName != "A" ) jsddm_close(); });
            $('#jsddm > li').bind('mouseover touchend', jsddm_open);
            $('#jsddm > li').bind('mouseout', jsddm_timer);
        });
  
  