
<?php
require_once __DIR__ . '/fitness_center/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $terms = isset($_POST['terms']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Vpišite veljaven email.';
    } elseif (strlen($password) < 8) {
        $message = 'Geslo mora vsebovati vsaj 8 znakov.';
    } elseif (!$terms) {
        $message = 'Sprejeti morate pogoje uporabe.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare(
                'INSERT INTO users (email, password_hash, terms_accepted)
                 VALUES (?, ?, ?)'
            );

            $stmt->execute([$email, $hash, 1]);

            $message = 'Registracija uspešna!';
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $message = 'Ta email je že registriran.';
            } else {
                $message = 'Pri registraciji je prišlo do napake.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vpiši se | Fitness Center</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="site-header">
        <a class="shield" href="index.html">FC</a>
        <a class="brand" href="index.html">FITNESS CENTER</a>
        <a class="account-icon" href="signup.php"></a>
    </header>

    <nav class="main-nav">
        <a href="index.html">DOMOV</a>
        <a href="locations.html">LOKACIJE</a>
        <a href="pricing.html">CENIK</a>
        <a href="contact.html">KONTAKT</a>
        <a class="active" href="signup.php">VPIŠI SE</a>
    </nav>

    <main class="subpage">
        <form class="form-card" action="signup.php" method="post">
            <label for="email">Email</label>
            <input id="email" name="email" type="email"
                   placeholder="Vpiši" required>

            <label for="password">Password</label>
            <input id="password" name="password" type="password"
                   placeholder="Vpiši" minlength="8" required>

            <label class="check-row">
                <input type="checkbox" name="terms" required>
                Strinjam se s pogoji uporabe
            </label>

            <button type="submit">Registriraj se</button>

            <?php if ($message): ?>
                <p><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>
        </form>
    </main>
</body>
</html>
