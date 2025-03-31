<!DOCTYPE html>
<html>
<head>
    <title><?= esc($car['name']) ?> Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .car-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <a href="<?= base_url('/carlist'); ?>" class="btn btn-secondary mb-3">← Back to List</a>

    <h1><?= esc($car['name']) ?> <small class="text-muted">(<?= esc($car['brand']) ?>)</small></h1>
    <p><strong>Release Year:</strong> <?= esc($car['release_year']) ?></p>

    <?php if (!empty($car['poster'])): ?>
        <img src="<?= esc($car['poster']) ?>" alt="Car Poster" class="car-image">
    <?php endif; ?>

    <p><strong>Average Rating:</strong> ⭐ <?= number_format($car['average_rating'], 1); ?>/5</p>

    <hr>
    <h4>Reviews:</h4>
    <?php if (!empty($car['reviews'])): ?>
        <ul class="list-group">
            <?php foreach ($car['reviews'] as $review): ?>
                <li class="list-group-item">
                    <strong><?= esc($review['username']) ?>:</strong> <?= esc($review['review']) ?> (<?= $review['rating'] ?>/5)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No reviews yet.</p>
    <?php endif; ?>
</div>
</body>
</html>
