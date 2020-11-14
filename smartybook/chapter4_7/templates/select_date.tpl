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
{html_select_date prefix=$prefix field_array=$field_array time=$time display_months=0  display_days=0    start_year=$start_year end_year=$end_year}年
{html_select_date prefix=$prefix field_array=$field_array time=$time display_years=0   display_days=0    month_format="%#m"}月
{html_select_date prefix=$prefix field_array=$field_array time=$time display_years=0   display_months=0  day_format="%d"   }日
{else}
{html_select_date prefix=$prefix time=$time display_months=0  display_days=0    start_year=$start_year end_year=$end_year}年
{html_select_date prefix=$prefix time=$time display_years=0   display_days=0    month_format="%#m"}月
{html_select_date prefix=$prefix time=$time display_years=0   display_months=0  day_format="%d"   }日
{/if}