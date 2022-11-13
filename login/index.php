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
$ready = ($_POST['pass'] ?? 0) && preg_match(
    "/^[A-Za-z0-9\.-]+@[A-Za-z0-9\.-]+\.[A-Za-z0-9]+$/", $_POST['email'] ?? ""
);
if(!$ready && $submit) {
?>
<body>
    <main class="container" style="width:40%; min-width:500px" align="center">
        <hgroup>
            <h1>ShellChat Login - ERROR</h1>
            <h2>Attempt to login with invalid info</h2>
        </hgroup>
        <h1>Invalid input found while processing in backend side.</h1>
        <button class='primary-btn' onclick="location.href='?'">Go back</a>
    </main>
</body>
<?
} else if(!$submit) {
?>
<body>
    <main class="container" style="width:40%; min-width:500px" align="center">
        <hgroup>
            <h1>ShellChat Login</h1>
            <h2>Log into ShellChat!</h2>
        </hgroup>
        <form method="post">
            <input
                id="email" type="email" name="email" placeholder="Enter your email"
                aria-label="Enter email: " aria-invalid="true" required
            >
            <input
                id="pass" type="password" name="pass" placeholder="Enter your password"
                aria-label = "Enter Password: " aria-invalid="true" required
            >
            <input class='primary-btn' type='submit' value='Login' name='submit'>
            <a href="/ShellChat/register/">Not registered yet, Click here to register</a>
        </form>
    </main>
</body>
</html>
<?php
} else {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=ShellChat", "root", "", [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
        // to-do
        // implement login
    } catch (\PDOException $e) {
?>
<body>
    <main class="container" style="width:40%; min-width:500px" align="center">
        <hgroup>
            <h1>ShellChat Database Error</h1>
            <h2>Server side database error</h2>
        </hgroup>
        <h2>Internal server error - share with developers</h2>
        <p>Error: <?php echo $e->getMessage();?><br>Errcode: <?php echo (int)$e->getCode(); ?></p>
        <button class='primary-btn' onclick="location.href='?'">Go back</a>
    </main>
</body>
<?
    }
}
?>