<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Explorer &#128663;</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .car-image {
            height: 180px;
            width: 100%;
            object-fit: cover;
            border-radius: 10px;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: scale(1.02);
        }
        .average-rating {
            color: #f39c12;
            font-weight: bold;
        }
        .username-box {
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        @media (max-width: 576px) {
            h2 {
                font-size: 1.4rem;
                text-align: center;
            }
            .car-image {
                height: 150px;
            }
            .btn, .form-control {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<div class="container mt-4">

    <!-- Header & Search + User Info -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-2">
        <h2 class="mb-0">&#128663; Car Explorer</h2>

        <div class="d-flex flex-column flex-md-row align-items-center gap-2 w-100 w-md-auto">

            <form method="get" action="<?= base_url('/carlist'); ?>" class="d-flex flex-grow-1">
                <input type="text" name="search" class="form-control" placeholder="&#128269; Search make (e.g. BMW)" value="<?= isset($search) ? esc($search) : ''; ?>">
                <button type="submit" class="btn btn-primary ms-2">Search</button>
            </form>

            <?php if (session()->get('user_id')): ?>
                <div class="username-box mt-2 mt-md-0">
                    <span class="text-dark">&#128075; Welcome, <strong><?= esc(session()->get('username')) ?></strong></span>
                    <a href="<?= base_url('/logout'); ?>" class="btn btn-outline-danger btn-sm ms-md-2">&#128275; Logout</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- API Results -->
    <?php if (!empty($apiCars)): ?>
        <h4 class="mb-3">&#128187; External Results</h4>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($apiCars as $car): ?>
                <div class="col">
                    <div class="card h-100 text-center p-2">
                        <img src="<?= esc($car['poster']); ?>" class="car-image" alt="Car Image">
                        <div class="card-body">
                            <h6 class="fw-bold">&#128663; <?= esc($car['model_name']); ?> (<?= esc($car['model_year']); ?>)</h6>
                            <small class="text-muted d-block">Make: <?= esc($car['make_display']); ?></small>
                            <form action="<?= base_url('/save-car-and-redirect'); ?>" method="post" class="mt-3">
                                <input type="hidden" name="model_name" value="<?= esc($car['model_name']); ?>">
                                <input type="hidden" name="make" value="<?= esc($car['make_display']); ?>">
                                <input type="hidden" name="model_year" value="<?= esc($car['model_year']); ?>">
                                <input type="hidden" name="poster" value="<?= esc($car['poster']); ?>">
                                <input type="hidden" name="engine" value="<?= esc($car['engine']); ?>">
                                <input type="hidden" name="fuel" value="<?= esc($car['fuel']); ?>">
                                <input type="hidden" name="transmission" value="<?= esc($car['transmission']); ?>">
                                <input type="hidden" name="drive" value="<?= esc($car['drive']); ?>">
                                <input type="hidden" name="doors" value="<?= esc($car['doors']); ?>">
                                <input type="hidden" name="seats" value="<?= esc($car['seats']); ?>">
                                <button type="submit" class="btn btn-success btn-sm mt-2 w-100">&#128190; Save to Local</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Local Cars -->
    <?php if (!empty($cars)): ?>
        <h4 class="mt-5 mb-3">&#128202; Cars in Our Database</h4>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($cars as $car): ?>
                <div class="col">
                    <div class="card h-100 text-center p-2">
                        <?php if (!empty($car['poster'])): ?>
                            <img src="<?= esc($car['poster']); ?>" class="car-image" alt="Car Poster">
                        <?php else: ?>
                            <div class="car-image bg-light d-flex align-items-center justify-content-center text-muted">No Image</div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h6 class="fw-bold">&#128663; <?= esc($car['name']); ?> (<?= esc($car['brand']); ?>)</h6>
                            <p class="average-rating">&#11088; <?= number_format($car['average_rating'], 1); ?> / 5</p>
                            <a href="<?= base_url('/car/' . $car['id']); ?>" class="btn btn-info btn-sm mt-2 w-100">&#128269; View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- No Results -->
    <?php if (empty($apiCars) && empty($cars)): ?>
        <div class="alert alert-warning mt-4 text-center">
            &#10060; No results found. Try a different keyword.
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
