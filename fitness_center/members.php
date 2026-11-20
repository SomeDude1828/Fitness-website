
<?php
require_once __DIR__ . '/db.php';

$stmt = $pdo->query(
    'SELECT id, email, terms_accepted, created_at
     FROM users
     ORDER BY id DESC'
);

$members = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Člani | Fitness Center</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="data-page">
        <h1>Člani Fitness Center</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Pogoji sprejeti</th>
                    <th>Datum registracije</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($members as $member): ?>
                <tr>
                    <td><?= htmlspecialchars((string)$member['id']) ?></td>
                    <td><?= htmlspecialchars($member['email']) ?></td>
                    <td><?= $member['terms_accepted'] ? 'Da' : 'Ne' ?></td>
                    <td><?= htmlspecialchars($member['created_at']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
