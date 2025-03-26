<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Dashboard</h1>

        <?php if ($isAdmin): ?>
            <h2>Admin Panel</h2>
            
            <h3>All Cars</h3>
            <ul class="list-group mb-4">
                <?php foreach ($cars as $car): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= $car['name']; ?> (<?= $car['brand']; ?>)
                        <a href="<?= base_url('/delete-car/' . $car['id']); ?>" class="btn btn-danger btn-sm">Delete</a>
                    </li>
                <?php endforeach; ?>
            </ul>
            
            <h3>All Reviews</h3>
            <ul class="list-group mb-4">
                <?php foreach ($allReviews as $review): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong><?= $review['username']; ?>:</strong> <?= $review['review']; ?> (Rating: <?= $review['rating']; ?>/5)
                        <a href="<?= base_url('/delete-review/' . $review['id']); ?>" class="btn btn-danger btn-sm">Delete</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <h2>Your Reviews</h2>
            <ul class="list-group mb-4">
                <?php foreach ($reviews as $review): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= $review['review']; ?> (Rating: <?= $review['rating']; ?>/5)
                        <a href="<?= base_url('/delete-review/' . $review['id']); ?>" class="btn btn-danger btn-sm">Delete</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <a href="<?= base_url('/carlist'); ?>" class="btn btn-primary">Back to Car List</a>
    </div>
</body>
</html>
