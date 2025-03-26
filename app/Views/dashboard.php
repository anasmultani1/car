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
                        <div>
                            <a href="<?= base_url('/edit-car/' . $car['id']); ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                            <a href="<?= base_url('/delete-car/' . $car['id']); ?>" class="btn btn-danger btn-sm">Delete</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            
            <h3>All Reviews</h3>
            <ul class="list-group mb-4">
                <?php foreach ($allReviews as $review): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= $review['review']; ?> (Rating: <?= $review['rating']; ?>/5)
                        <div>
                            <a href="<?= base_url('/edit-review/' . $review['id']); ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                            <a href="<?= base_url('/delete-review/' . $review['id']); ?>" class="btn btn-danger btn-sm">Delete</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>
