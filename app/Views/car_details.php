<!DOCTYPE html>
<html>
<head>
    <title><?= esc($car['name']) ?> Details</title>

    <!-- Load Bootstrap locally -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">

    <style>
        .car-image {
            max-width:100%;
            height:auto;
            border-radius:10px;
            margin-bottom:20px;
        }
        body {
            background-color:#f8f9fa;
            font-family: Arial, sans-serif;
        }
        .card {
            border-radius:10px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
<div class="container mt-5">

    <a href="<?= base_url('/carlist'); ?>" class="btn btn-secondary mb-3">? Back to List</a>

    <div class="card p-4 shadow-sm mb-5">
        <h1><?= esc($car['name']) ?> <small class="text-muted">(<?= esc($car['brand']) ?>)</small></h1>
        <p><strong>Release Year:</strong> <?= esc($car['release_year']) ?></p>

        <?php if (!empty($car['poster'])): ?>
            <img src="<?= esc($car['poster']) ?>" alt="Car Poster" class="car-image">
        <?php endif; ?>

        <p><strong>Engine:</strong> <?= esc($car['engine']) ?></p>
        <p><strong>Fuel:</strong> <?= esc($car['fuel']) ?></p>
        <p><strong>Transmission:</strong> <?= esc($car['transmission']) ?></p>
        <p><strong>Drive:</strong> <?= esc($car['drive']) ?></p>
        <p><strong>Doors:</strong> <?= esc($car['doors']) ?></p>
        <p><strong>Seats:</strong> <?= esc($car['seats']) ?></p>
        <p><strong>Average Rating:</strong> ? <?= number_format($car['average_rating'], 1); ?>/5</p>
    </div>

    <h3 class="mt-5">? Reviews</h3>

    <?php if (!empty($car['reviews'])): ?>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php foreach ($car['reviews'] as $review): ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-1"><?= esc($review['username']) ?></h5>
                            <p class="card-text"><?= esc($review['review']) ?></p>
                            <p class="text-muted">Rating: ? <?= $review['rating'] ?>/5</p>

                            <?php if (session()->get('user_id') == $review['user_id']): ?>
                                <div class="mt-2">
                                    <a href="<?= base_url('/edit-review/' . $review['id']); ?>" class="btn btn-sm btn-warning me-2">Edit</a>
                                    <a href="<?= base_url('/delete-review/' . $review['id']); ?>" class="btn btn-sm btn-danger">Delete</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info mt-3">No reviews yet. Be the first to leave one!</div>
    <?php endif; ?>

    <hr>
    <h4 class="mt-5">?? Leave a Review</h4>

    <?php if (session()->has('user_id')): ?>
        <form action="<?= base_url('/submit-review'); ?>" method="post" class="p-4 bg-light rounded shadow-sm mt-3">
            <input type="hidden" name="car_id" value="<?= esc($car['id']); ?>">
            <input type="hidden" name="username" value="<?= esc(session()->get('username')); ?>">

            <div class="mb-3">
                <label for="review" class="form-label">Your Review</label>
                <textarea name="review" id="review" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <select name="rating" id="rating" class="form-select" required>
                    <option value="">-- Choose --</option>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?>/5</option>
                    <?php endfor; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    <?php else: ?>
        <div class="alert alert-warning mt-3">
            You must <a href="<?= base_url('/login'); ?>">log in</a> to post a review.
        </div>
    <?php endif; ?>
</div>
</body>
</html>
