var ie45,ns6,ns4,dom;
var auto_refresh = setInterval(
function ()
{
$('#server').load('vnz-leech.php').fadeIn("slow");
}, 300000); // refresh every 10000 milliseconds

if (navigator.appName=="Microsoft Internet Explorer")
  ie45=parseInt(navigator.appVersion)>=4;
else if (navigator.appName=="Netscape"){
  ns6=parseInt(navigator.appVersion)>=5;
  ns4=parseInt(navigator.appVersion)<5;}
dom=ie45 || ns6;

function showhide(id) {
el = document.all ? document.all[id] : 
  dom ? document.getElementById(id) : 
  document.layers[id];
els = dom ? el.style : el;
if (dom){
  if (els.display == "none")
    els.display = "";
  else els.display = "none";
  }
else if (ns4){
  if (els.display == "show")
    els.display = "hide";
  else els.display = "show";
  }
}