<!DOCTYPE html>
<html>
<head>
    <title>Car List</title>
</head>
<body>
    <h1>All Cars</h1>
    <a href="<?= base_url('/add-car'); ?>">Add New Car</a>
    <ul>
        <?php foreach ($cars as $car): ?>
            <li><?= $car['name']; ?> - <?= $car['brand']; ?> (<?= $car['release_year']; ?>)</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
