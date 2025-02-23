<?php
exec(mysqldump -u='root' -p='' -all-databases | gzip -9 > C:/xampp/htdocs/sms/template/all.sql);
?>