<?php
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off') {
	header("Location: https://SITESID.athena.systems/login");
}
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed"
				data-toggle="collapse" data-target="#navbar" aria-expanded="false"
				aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">CO_NAME</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li class=""><a href="/home" title="">Home</a>
				</li>
			</ul>
		</div>
		<!--/.nav-collapse -->
	</div>
	<!--/.container-fluid -->
</nav>

<div style="width: 320px; margin-left: auto; margin-right: auto;">
<h3 style="margin-left: 20px;">CO_NAME Log In</h3>
<?php
if ($_GET ['pf'] == 'y') {
	?>
<div class="alert alert-danger" role="alert">
	Ooops ... <br>That Username and Password were not accepted<br>Please
	try again
</div>
<?php
}
?><br><br>

	<form action="https://SITESID.athena.systems/bin/pass.pl" method="post"
		class="section" id="login" name="login">
		<fieldset class="form-group">

			<div class="form-group row">

				<label class="form-control-label" for="id_username">Username</label><br>

					<input id="id_username" type="text" name="nick" maxlength="30"
						size="20" style="width: 120px;" class="form-control">

			</div>

			<div class="form-group row">
				<label class="form-control-label" for="id_password">Password</label><br>


					<input type="password" name="pw" id="id_password" maxlength="30"
						size="20" style="width: 120px;" class="form-control">

			</div>


			<br> <br>
			<fieldset class="form-group">
				<div class="text-right">
					<input value="Login" class="btn btn-primary" type="submit">
				</div>
			</fieldset>
		</fieldset>
		<input type="hidden" name="sid" value="OWLDROP">
	</form>
</div>
<br clear="all">
