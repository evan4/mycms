<div class="container">

	<form id="form-login" class="form-signin" action="" method="post">
		<div class="text-center mb-4">
			<h1 class="h3 mb-3 font-weight-normal">Let's get you into your account</h1>
		</div>

		<input type="hidden" id="csrf" name="csrf" value="<?= csrf(); ?>">
		
		<div class="form-group">
			<label for="email">Sign-in email address:</label>
			<input type="email" id="email" name="email" class="form-control"
				 placeholder="Email address" required autofocus>
		</div>

		<input class="btn btn-lg btn-primary btn-block" 
			type="submit" value="Recovery password"/>

	</form>
	
	<div class="row">
		<div class="result col-12"></div>
	</div>

</div>

<script src="/js/login.js"></script>