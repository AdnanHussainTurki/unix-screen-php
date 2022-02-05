<?php


$subject = "[H[JUser created:  0
New password: Retype new password: passwd: password updated successfully
Password Updated:  0
Directory Permission Change:  0
All done!
exitcode_by_script:0
__EXITCODE:0__END
";
$subject = str_replace("\r", "", $subject);
$matches = preg_grep("/(^__EXIT)(.*?)(__END$)/",explode("\n", $subject));
var_dump($matches);
$matches = implode(",",$matches);
$exitcode =( int) (str_replace("__END","",str_replace("__EXITCODE:","",$matches)));
var_dump($exitcode);