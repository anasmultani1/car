<!DOCTYPE html>
<html>
<head>
    <title><?= esc($car['name']) ?> Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
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

    <!-- Back Button -->
    <a href="<?= base_url('/carlist'); ?>" class="btn btn-secondary mb-4">&larr; Back to Car List</a>

    <!-- Car Details -->
    <div class="card p-4 mb-5 shadow-sm">
        <h2><?= esc($car['name']) ?> <small class="text-muted">(<?= esc($car['brand']) ?>)</small></h2>
        <p><strong>Release Year:</strong> <?= esc($car['release_year']) ?></p>

        <?php if (!empty($car['poster'])): ?>
            <img src="<?= esc($car['poster']) ?>" alt="Car Poster" class="car-image">
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6">
                <p><strong>Engine:</strong> <?= esc($car['engine']) ?></p>
                <p><strong>Fuel:</strong> <?= esc($car['fuel']) ?></p>
                <p><strong>Transmission:</strong> <?= esc($car['transmission']) ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Drive:</strong> <?= esc($car['drive']) ?></p>
                <p><strong>Doors:</strong> <?= esc($car['doors']) ?></p>
                <p><strong>Seats:</strong> <?= esc($car['seats']) ?></p>
            </div>
        </div>

        <p class="mt-3"><strong>Average Rating:</strong> <?= number_format($car['average_rating'], 1); ?>/5</p>
    </div>

    <!-- Reviews Section -->
    <h4 class="mb-3">User Reviews</h4>

    <?php if (!empty($car['reviews'])): ?>
        <div class="row row-cols-1 row-cols-md-2 g-4 mb-4">
            <?php foreach ($car['reviews'] as $review): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title text-primary"><?= esc($review['username']) ?></h6>
                            <p class="card-text"><?= esc($review['review']) ?></p>
                            <p class="text-muted mb-2">Rating: <?= $review['rating'] ?>/5</p>

                            <?php if (session()->get('user_id') == $review['user_id']): ?>
                                <a href="<?= base_url('/edit-review/' . $review['id']); ?>" class="btn btn-sm btn-warning me-2">Edit</a>
                                <a href="<?= base_url('/delete-review/' . $review['id']); ?>" class="btn btn-sm btn-danger">Delete</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-muted">No reviews for this car yet. Be the first!</p>
    <?php endif; ?>

    <!-- Leave a Review -->
    <h4 class="mt-5">Leave a Review</h4>

    <?php if (session()->has('user_id')): ?>
        <form action="<?= base_url('/review/save'); ?>" method="post" class="card p-4 shadow-sm mt-3">
            <input type="hidden" name="car_id" value="<?= esc($car['id']); ?>">

            <div class="mb-3">
                <label class="form-label">Review</label>
                <textarea name="review" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Rating</label>
                <select name="rating" class="form-select" required>
                    <option value="">-- Select --</option>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?>/5</option>
                    <?php endfor; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit Review</button>
        </form>
    <?php else: ?>
        <div class="alert alert-warning mt-3">
            You must <a href="<?= base_url('/login'); ?>">log in</a> to leave a review.
        </div>
    <?php endif; ?>

</div>
</body>
</html>
