<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/ShellChat/pico.min.css">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script defer src="script.js"></script>
</head>
<?php
$submit = $_POST['submit'] ?? 0;
$ready = (strlen($_POST['pass'] ?? "") > 7 ) && preg_match(
    "/^[A-Za-z0-9\.-]+@[A-Za-z0-9\.-]+\.[A-Za-z0-9]+$/", $_POST['email'] ?? ""
) && preg_match(
    "/^[A-Za-z]{3,} [A-Za-z]{3,}( [A-Za-z]{3,}|)$/", $_POST['name'] ?? ""
);
if ($submit && !$ready) {
?>
<body>
    <main class="container" style="width:40%; min-width:500px" align="center">
        <hgroup>
            <h1>ShellChat Register - ERROR</h1>
            <h2>Attempt to register with invalid info</h2>
        </hgroup>
        <h1>Invalid input found while processing in backend side.</h1>
        <button class='primary-btn' onclick="location.href='?'">Go back</a>
    </main>
</body>
<?php
} else if (!$submit) {
?>
<body>
    <main class="container" style="width:40%; min-width:500px" align="center">
        <hgroup>
            <h1>ShellChat Register</h1>
            <h2>Join ShellChat!</h2>
        </hgroup>
        <form method="post">
            <input
                id="email" type="email" name="email" placeholder="Enter your email"
                aria-label="Enter email: " aria-invalid="true" required
            >
            <input
                id="name" type="text" name="name" placeholder="Enter your name"
                aria-label="Enter name: " aria-invalid="true" required
            >
            <input
                id="pass" type="password" name="pass" placeholder="Enter your password"
                aria-label = "Enter Password: " aria-invalid="true" required
            >
            <input class='primary-btn' type='submit' value='Register' name='submit'>
            <a href="/ShellChat/login/">Already registered, Click here to login</a>
        </form>
    </main>
</body>
</html>
<?php
} else {
    try {
        
        // set up a new connection
        $conn = new PDO(
            "mysql:host=localhost;dbname=ShellChat", "root", "", [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]
        );

        // set up attr for anti - seql injection
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);

        // check if user already exists
        $stmt = $conn->prepare("SELECT * FROM Users WHERE email=:email")
        $stmt->execute([':email'=>$_POST['email']]);
        $exists = $stmt->fetch() ?? null;
        // to-do check if user exists & refrain - done
        if ($exists) {
            // close connection
            $conn = null;
?>
<body>
    <main class="container" style="width:40%; min-width:500px" align="center">
        <hgroup>
            <h1>ShellChat Register - ERROR</h1>
            <h2>User already exists.</h2>
        </hgroup>
        <h1>Invalid input found while processing in backend side.</h1>
        <button class='primary-btn' onclick="location.href='?'">Go back</a>
    </main>
</body>
<?php
        } else {
            // prepare & execute statement
            $stmt = $conn->prepare("INSERT INTO Users(Name,passw_hash,email) VALUES (:name, :pwhash, :email)");
            $stmt->execute([':name'=>$_POST['name'],'email'=>$_POST['email'], 'pwhash'=>hash('sha256', $_POST['pass'])]);
            // close connection
            $conn = null;
?>
<body>
    <main class="container" style="width:40%; min-width:500px" align="center">
        <hgroup>
            <h1>ShellChat Register</h1>
            <h2>Registered successfully!</h2>
        </hgroup>
        <h1>Login with the credentials!</h1>
        <button class='primary-btn' onclick="location.href='/ShellChat/login/'">Login</a>
    </main>
</body>
</html>
<?php
        }
    } catch (\PDOException $e) {
?>
<body>
    <main class="container" align="center">
        <hgroup>
            <h1>ShellChat Database Error</h1>
            <h2>Server side database error - reloading may resolve problem.</h2>
        </hgroup>
        <h2>Internal server error - share with developers</h2>
        <p>Error: <?php echo $e->getMessage();?><br>Errcode: <?php echo (int)$e->getCode(); ?></p>
        <div class="container" style="width:40%; min-width:500px">
            <button class='primary-btn' onclick="location.href='?'">Go back</a>
        </div>
    </main>
</body>
</html>
<?
    }
}
?>