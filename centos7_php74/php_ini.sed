s/;date.timezone =/date.timezone = Asia\/Tokyo/
s/display_errors = Off/display_errors = On/
s/log_errors = Off/log_errors = On/
s/error_reporting = E_ALL .*/error_reporting = E_ALL/
s/post_max_size = 8M/post_max_size = 100M/
s/upload_max_filesize = 2M/upload_max_filesize = 100M/
s/;mbstring.language =.*/mbstring.language = Japanese/
s/;mbstring.internal_encoding =.*/mbstring.internal_encoding = UTF-8/
s/;mbstring.http_input =.*/mbstring.http_input = pass/
s/;mbstring.http_output =.*/mbstring.http_output = pass/
s/;mbstring.encoding_translation = .*/mbstring.encoding_translation = Off/
s/track_errors=On/;track_errors=On/
