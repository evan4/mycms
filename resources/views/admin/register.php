<div class="container">

	<form id="form-login" class="form-signin" action="" method="post">
		<div class="text-center mb-4">
			<h1 class="h3 mb-3 font-weight-normal">Sing up</h1>
			<p>Build form controls with floating labels via the
				<code>:placeholder-shown</code> pseudo-element.
				<a href="https://caniuse.com/#feat=css-placeholder-shown">Works in latest Chrome, Safari, and Firefox.</a>
			</p>
		</div>

		<div class="form-group">
			<label for="email">Email address:</label>
			<input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>
		</div>

		<input type="hidden" id="csrf" name="csrf" value="<?= $data['csrf']; ?>">

		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
		</div>

		<div class="checkbox mb-3">
			<label>
				<input type="checkbox" name="remember" value="remember-me"> Remember me
			</label>
		</div>

		<input class="btn btn-lg btn-primary btn-block" type="submit">Sign in</input>

		<p class="text-center">
			<a href="/">back to home page</a>
		</p>
	</form>
	
	<div class="row">
		<div class="result col-12"></div>
	</div>

</div>

<script src="/js/login.js"></script>