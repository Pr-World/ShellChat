<?php
$uname = $_COOKIE['id'] ?? 0;
$passw = $_COOKIE['auth'] ?? 0;
if (!$uname || !$passw) { header('location: login/'); }
// to-do
// make a proper dashboard to chat with others, probably in a holiday im too lazzzyyyzyzyzyzyzy
try {
    $conn = new PDO(
        "mysql:host=localhost;dbname=ShellChat", "root", "", [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]
    );

    // set up attr for anti - seql injection
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);

    // prepare & execute statement
    $stmt = $conn->prepare("SELECT * FROM Users WHERE id=:id AND passw_hash=:auth");
    $stmt->execute(['id'=>$_POST['id'], 'pwhash'=>$_POST['auth']);

    $user = $stmt->fetch() ?? null;
    // close the connection
    $conn = null;

    if(!$user) {
        header('location: login/');
    } else {    
        $name = $user['Name'];
        $id = $user['id'];
        $pw_hash = $user['passw_hash'];
        $mailid = $user['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShellChat</title>
    <link rel="stylesheet" href="/ShellChat/pico.min.css">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script defer src="script.js"></script>
</head>
<body>
    <div class='container'>
        <header>
            <h1>ShellChat - DashBoard</h1>
            <h2>Welcome to ShellChat - <?php echo $name; ?></h2>
        </header>
    </div>
</body>
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
        <div class="container" style="width:50%; min-width:500px">
            <button class='primary-btn' onclick="location.href='?'">Go back</a>
        </div>
    </main>
</body>
</html>
<?php
}
?>