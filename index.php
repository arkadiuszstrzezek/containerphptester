<?php
$host = getenv('DB_HOST');
$db = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $vote = $_POST['vote'] === 'dog' ? 'dog' : 'cat';
        $stmt = $pdo->prepare("UPDATE votes SET count = count + 1 WHERE animal = :animal");
        $stmt->execute(['animal' => $vote]);
    }

    $stmt = $pdo->query("SELECT animal, count FROM votes");
    $votes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote for Dogs or Cats</title>
</head>
<body>
    <h1>Vote for your favorite!</h1>
    <form method="POST">
        <button name="vote" value="dog">Vote for Dogs</button>
        <button name="vote" value="cat">Vote for Cats</button>
    </form>
    <h2>Results:</h2>
    <ul>
        <?php foreach ($votes as $vote): ?>
            <li><?= htmlspecialchars($vote['animal']) ?>: <?= (int)$vote['count'] ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
