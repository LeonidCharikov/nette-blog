<?php
session_start();

$dbHost = 'localhost';
$dbName = 'blog';
$dbUser = 'root';
$dbPass = 'student';

// Připojení k databázi
try {
    $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'Chyba při připojení k databázi: ' . $e->getMessage();
}

// kontrola, zda je uživatel přihlášen
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}



// načtení všech příspěvků z databáze
$query = $db->query("SELECT * FROM articles");


// přidání nového příspěvku
if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $content = mysqli_real_escape_string($db, $_POST['content']);
    $created_at = date('Y-m-d H:i:s');
    $author_id = $_SESSION['users']['id'];

    $query = "INSERT INTO articles (title, description, content, created_at, author_id) VALUES ('$title', '$description', '$content', '$created_at', $author_id)";
    mysqli_query($db, $query);

    header('Location: index.php');
    exit();
}

// odhlášení uživatele
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog</title>
</head>
<body>
    <h1>Vítejte na blogu</h1>
    <p>Přihlášený uživatel: <?php echo $_SESSION['users']['name']; ?> | <a href="?logout=true">Odhlásit se</a></p>

    <h2>Vytvořit nový příspěvek</h2>
    <form method="post" action="index.php">
        <label>Název:</label><br>
        <input type="text" name="title"><br>
        <label>Popis:</label><br>
        <textarea name="description"></textarea><br>
        <label>Obsah:</label><br>
        <textarea name="content"></textarea><br>
        <input type="submit" name="submit" value="Vytvořit">
    </form>

    <h2>Seznam příspěvků</h2>
    <ul>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <li>
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo $row['description']; ?></p>
                <p><?php echo $row['content']; ?></p>
                <p><?php echo $row['created_at']; ?> | Autor: <?php echo $row['author_id']; ?></p>
            </li>
        <?php } ?>
    </ul>
</body>
</html>