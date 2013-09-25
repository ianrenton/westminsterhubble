
$(document).ready(function() {

  var bannerhtml = '<div id="irbannerwrap"><span id="irbanner">Westminster Hubble has been discontinued. Old data can be viewed but the database is no longer being updated. <a href="http://blog.ianrenton.com/the-end-of-westminster-hubble/" class="irlink">Read about it &raquo;</a></span></div>';
  var bannercss = 'div#itbannerwrap { width:100%; text-align:center; margin: 0 0 10px 0; padding: 0;} span#irbanner {background-color:#dd6666; color:black; font-family:sans-serif; text-align:center; font-size:14px; text-decoration: none; margin: 5px auto; padding:5px; border: 2px solid red; position:relative; top:0; z-index:9999;} a.irlink {color:text; text-decoration:underline; padding: 15px 10px 5px 10px; margin:0;}';

  // Add CSS and HTML to body using jQuery
  addCss(bannercss);
  $('body').prepend(bannerhtml);

});

// Nice cross-browser way of adding styles from JS
// Stolen from http://yuiblog.com/blog/2007/06/07/style/
function addCss(cssCode) {
var styleElement = document.createElement("style");
  styleElement.type = "text/css";
  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = cssCode;
  } else {
    styleElement.appendChild(document.createTextNode(cssCode));
  }
  document.getElementsByTagName("head")[0].appendChild(styleElement);
}


