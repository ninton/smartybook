<?php

/**
 * プラグイン
 *
 * @description     プラグインです
 * @author          kara_d
 * @version         0.1[2008/01/24]
 * @see
 */

function smarty_function_login_form($params, &$smarty)
{
    $self = $params["self"];
    $username = htmlspecialchars($params["username"]);
    $result = <<<LOGIN
<form method="post" action="$self" class="message" id="cmsForm" name="cmsForm">
	<fieldset>
		<table cellspacing="0">
			<tr>
				<th><label for="username">ユーザー名</label></th>
				<td><input type="text" name="username" value="$username" /></td>
			</tr>
			<tr>
				<th><label for="password">パスワード</label></th>
				<td><input type="password" name="password" /></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td><input type="image" src="./images/form_btn_post.gif" alt="送信" width="94" height="24" /></td>
			</tr>
		</table>
	</fieldset>
</form>
LOGIN;
    return $result;
}
