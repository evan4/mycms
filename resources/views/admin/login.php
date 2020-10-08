<div class="container">

	<form id="form-login" class="form-signin" action="/auth" method="post">
		<div class="text-center mb-4">
			<h1 class="h3 mb-3 font-weight-normal">Login</h1>
		</div>

		<input type="hidden" name="csrf" value="<?=csrf();?>">

		<div class="form-group">
			<label for="email">Email address:</label>
			<input type="email" id="email" name="email" class="form-control" 
				placeholder="Email address" required>
		</div>

		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" class="form-control"
				placeholder="Password" required>
		</div>

		<!-- <p><a href="/forgot">Trouble signing in?</a></p>
 -->
		<input class="btn btn-lg btn-primary btn-block" type="submit" value="Sign in">

	</form>
	
	<div class="row">
		<div class="result col-12"></div>
	</div>

</div>

<script src="/js/login.js"></script>