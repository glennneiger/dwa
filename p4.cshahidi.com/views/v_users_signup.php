<h2>Please Sign up for New Account</h2>

<!-- "form_ID" and class "formular" are for new jQuery Validation plugin -->
<form id="formID" class="formular" method="POST" action="/users/p_signup">

	<div class="login-info">
		<p>First Name</p>
		<input type="text" name="first_name" class="validate[required] text-input" />		
		
		<p>Last Name</p>
		<input type="text" name="last_name" class="validate[required] text-input" />				
		
		<p>Email</p>
		<input type="text" name="email" class="validate[required,custom[email]] text_input" id="email">		
		
		<p>Password</p>
		<input type="password" name="password" class="validate[required] text_input" id="password">		
		<br>
		
		<!-- Insert in $_POST the $role variable ("partner" vs "principal") that login() has set -->
		<input type="hidden" name="role" value="<?=$role?>">
		
		
		<input type="submit" value="Sign Up">
	</div>	
</form>


<!-- Use new jQuery validation Plugin script -->
<script type='text/javascript'>

	// binds form submission and fields to the validation engine
	$("#formID").validationEngine('attach');

</script>	
		