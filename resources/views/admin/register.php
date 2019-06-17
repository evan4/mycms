<div class="container">

	<form id="form-reg" class="form-signin" action="" method="post">
		<div class="text-center mb-4">
			<h1 class="h3 mb-3 font-weight-normal">Sing up</h1>
		</div>

		<input type="hidden" id="csrf" name="csrf" value="<?= $data['csrf']; ?>">

		<div class="form-group">
			<label for="username">Username:</label>
			<input type="text" id="username" name="username" class="form-control" 
				placeholder="Username" required>
		</div>

		<div class="form-group">
			<label for="first_name">First name:</label>
			<input type="text" id="first_name" name="first_name" class="form-control" 
				placeholder="First name" required autofocus>
		</div>

		<div class="form-group">
			<label for="last_name">Last name:</label>
			<input type="text" id="last_name" name="last_name" class="form-control" 
				placeholder="Last name">
		</div>

		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" id="email" name="email" class="form-control" 
				placeholder="Email" required>
		</div>

		<div class="form-group">
			<label for="description">Description:</label>
			<textarea name="description" id="description" class="form-control" 
				cols="10" rows="3"></textarea>
		</div>

		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" class="form-control" 
				placeholder="Password" required>
		</div>

		<input class="btn btn-lg btn-primary btn-block" type="submit" value="Sign in">

	</form>
	
	<div class="row">
		<div class="result col-12"></div>
	</div>

</div>

<script src="/js/register.js"></script>
