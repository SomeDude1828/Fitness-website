<?php
require_once 'db.php';
$stmt = $pdo->query(
    'SELECT
        members.id,
        members.email,
        members.terms_accepted,
        members.created_at,
        membership_plans.name AS plan_name,
        locations.name AS location_name
    FROM members
    LEFT JOIN membership_plans ON membership_plans.id = members.plan_id
    LEFT JOIN locations ON locations.id = members.location_id
    ORDER BY members.id DESC'
);
$members = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <th>Članstvo</th>
                    <th>Lokacija</th>
                    <th>Pogoji sprejeti</th>
                    <th>Datum registracije</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($members as $member): ?>
                <tr>
                    <td><?= htmlspecialchars((string) $member['id']) ?></td>
                    <td><?= htmlspecialchars($member['email']) ?></td>
                    <td><?= htmlspecialchars($member['plan_name'] ?? 'Ni izbran paket') ?></td>
                    <td><?= htmlspecialchars($member['location_name'] ?? 'Ni izbrana lokacija') ?></td>
                    <td><?= $member['terms_accepted'] ? 'Da' : 'Ne' ?></td>
                    <td><?= htmlspecialchars($member['created_at']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>