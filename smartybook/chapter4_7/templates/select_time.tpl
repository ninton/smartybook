{*
	prefix=
	field_array=
	time=
	start_year=
	end_year=
*}
{if $start_year == ""}{assign var=start_year value=$smarty.now|date_format:"%Y"}{/if}
{if $end_year   == ""}{assign var=end_year   value=$smarty.now|date_format:"%Y"}{/if}
{if $field_array != ""}
{html_select_time prefix=$prefix field_array=$field_array time=$time display_minutes=0 display_seconds=0 use_24_hours=1    }時
{html_select_time prefix=$prefix field_array=$field_array time=$time display_hours=0   display_seconds=0                   }分
{html_select_time prefix=$prefix field_array=$field_array time=$time display_hours=0   display_minutes=0                   }秒
{else}
{html_select_time prefix=$prefix time=$time display_minutes=0 display_seconds=0 use_24_hours=1    }時
{html_select_time prefix=$prefix time=$time display_hours=0   display_seconds=0                   }分
{html_select_time prefix=$prefix time=$time display_hours=0   display_minutes=0                   }秒
{/if}