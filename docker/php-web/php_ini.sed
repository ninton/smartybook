s/;date.timezone =/date.timezone = Asia\/Tokyo/
s/display_errors = Off/display_errors = On/
s/expose_php = On/expose_php = Off/g
s/log_errors = Off/log_errors = On/
s/error_reporting = E_ALL .*/error_reporting = E_ALL/
s/post_max_size = 8M/post_max_size = 100M/
s/upload_max_filesize = 2M/upload_max_filesize = 100M/
s/;mbstring.language =.*/mbstring.language = Japanese/
