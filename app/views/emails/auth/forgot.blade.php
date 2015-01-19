<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Password Reset</h2>
		<h3>Hello {{ $username }}</h3>
		<div>
			To reset your password, use the following link.<br/>
		</div>
		<p>New Password: {{ $password }}</p> 

		--------------
		<br>
		{{ $link }}
		<br>
		--------------
	</body>
</html>