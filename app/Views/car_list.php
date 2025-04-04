<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Explorer</title>

    <!-- Bootstrap 5 -->
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
    </style>
</head>
<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Car Explorer</h2>
        <form method="get" action="<?= base_url('/carlist'); ?>" class="d-flex">
            <input type="text" name="search" class="form-control" placeholder="Search make (e.g. BMW)" value="<?= isset($search) ? esc($search) : ''; ?>">
            <button type="submit" class="btn btn-primary ms-2">Search</button>
        </form>
    </div>

    <!-- API Results -->
    <?php if (!empty($apiCars)): ?>
        <h4 class="mb-3">External Results</h4>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
            <?php foreach ($apiCars as $car): ?>
                <div class="col">
                    <div class="card h-100 text-center p-2">
                        <img src="<?= esc($car['poster']); ?>" class="car-image" alt="Car Image">
                        <div class="card-body">
                            <h6 class="fw-bold"><?= esc($car['model_name']); ?> (<?= esc($car['model_year']); ?>)</h6>
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
                                <button type="submit" class="btn btn-sm btn-success mt-2 w-100">Save to Local</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Local Cars -->
    <?php if (!empty($cars)): ?>
        <h4 class="mt-5 mb-3">Cars in Our Database</h4>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
            <?php foreach ($cars as $car): ?>
                <div class="col">
                    <div class="card h-100 text-center p-2">
                        <?php if (!empty($car['poster'])): ?>
                            <img src="<?= esc($car['poster']); ?>" class="car-image" alt="Car Poster">
                        <?php else: ?>
                            <div class="car-image bg-light d-flex align-items-center justify-content-center text-muted">No Image</div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h6 class="fw-bold"><?= esc($car['name']); ?> (<?= esc($car['brand']); ?>)</h6>
                            <p class="average-rating"><?= number_format($car['average_rating'], 1); ?> / 5</p>
                            <a href="<?= base_url('/car/' . $car['id']); ?>" class="btn btn-info btn-sm mt-2 w-100">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- No Results Found -->
    <?php if (empty($apiCars) && empty($cars)): ?>
        <div class="alert alert-warning mt-4 text-center">
            No results found. Try a different keyword.
        </div>
    <?php endif; ?>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
