<form>
{html_options name="prefecture1" values=$id output=$location selected="002"}<br /><br />
{html_checkboxes name="prefecture2" values=$id output=$location selected="003"}<br /><br />
{html_radios name="prefecture3" values=$id output=$location selected="001"}<br /><br />
{html_radios name="prefecture4" options=$address selected="001" separator="<br />"}
</form>
