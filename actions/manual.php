<h3>Manual</h3>
<?php
echo "Drag these two bookmarklets to you bookmark bar: <br/><br/>";
echo " <a href=\"/crave/$username/$password\">Crave</a>";
$decode = "String.prototype.hexDecode = function(){var r='';for(var i=0;i<this.length;i+=2){r+=unescape('%'+this.substr(i,2));}return r;}";
$encode = "String.prototype.hexEncode = function(){var r='';var i=0;var h;while(i<this.length){h=this.charCodeAt(i++).toString(16);while(h.length<2){h=h;}r+=h;}return r;}";
$url = "http://$_SERVER[SERVER_NAME]/review/$username/$password/";
echo " <a href=\"javascript:$encode;document.location='$url'+String(document.location).hexEncode()\">Review</a>";
echo " <a href=\"/profile/$username/$password\">Profile</a>";