<?php
class View_Login extends View_Base {
	
	public function renderMain() {
		
		$return =<<<html
		<form method="post" action="" accept-charset="UTF-8">
		<div class="auth-form-header">
			<h1>Sign in</h1>
		</div>
		<div class="auth-form-body">
			<label for="login_field"> Username </label>
			<input id="login_field" class="input-block" type="text" tabindex="1" name="login" autofocus="autofocus" autocapitalize="off">
			<label for="password">
				Password
			</label>
			<input id="password" class="input-block" type="password" tabindex="2" name="password" autocomplete="disabled">
			<input class="button" type="submit" value="Sign in" tabindex="3" id="commit" name="commit">
		</div>
		</form>
html;
	
		return $return;
	}
}