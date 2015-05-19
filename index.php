<?php
if(isset($_POST['submit'])) {
	$name = htmlspecialchars(trim($_POST["name"]));
	$email = htmlspecialchars(trim($_POST["email"]));
	$comments = htmlspecialchars(trim($_POST["comments"]));
	
	if (empty($name)) {
		$msg = "Name is required";
	}
	elseif (empty($email)) {
		$msg = "Email is required";
	}
	elseif (empty($comments)) {
		$msg = "Comment is required";
	}
	else {
		$mysqli = new mysqli("localhost", "user", "pass", "phptest");
		if (mysqli_connect_errno()) {
		    $msg = "Connection Error";
		}
		$date = date("Y-m-d h:i:s");
		$ip = $_SERVER["SERVER_ADDR"];
		$useragent = $_SERVER["HTTP_USER_AGENT"];
		$stmt = $mysqli->prepare("INSERT INTO comments (name, email, comment, date, ipAddress, useragent) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssss", $name, $email, $comments, $date, $ip, $useragent);

		if ($stmt->execute()) {
			$msg = "Record Added";
		}
		else {
			$msg = "Form Error";
		}
		$stmt->close();
		$mysqli->close();
	}
}
?>

<html>
	<head>
	</head>
	<body>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		Name <input type="text" id="name" name="name" /><br />
		Email <input type="text" id="email" name="email" /><br />
		Comments <textarea id="comments" cols="10" rows="5" name="comments"></textarea><br />
		<input type="submit" name="submit" value="submit" />
		</form>
		<?php if (!empty($msg)) { echo $msg;} ?>
	</body>
</html>