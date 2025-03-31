<!DOCTYPE html>
<html>
<head>
    <title>Car List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f9f9f9;
        }
        .car-image {
            height: 250px;
            width: 100%;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.02);
        }
        .average-rating {
            color: #f39c12;
        }
    </style>
</head>
<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>🚘 Car Explorer</h1>

        <form method="get" action="<?= base_url('/carlist'); ?>" class="d-flex">
            <input type="text" name="search" class="form-control" placeholder="Search car make (e.g. Honda, Audi)" value="<?= isset($search) ? esc($search) : ''; ?>">
            <button type="submit" class="btn btn-primary ms-2">Search</button>
        </form>
    </div>

    <!-- API Results -->
    <?php if (!empty($apiCars)): ?>
        <h3>🌐 External Results</h3>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
            <?php foreach ($apiCars as $car): ?>
                <div class="col">
                    <div class="card p-2">
                        <img src="<?= esc($car['image']); ?>" alt="Car Image" class="car-image">
                        <div class="card-body text-center">
                            <h6><?= esc($car['model_name']); ?> (<?= esc($car['model_year']); ?>)</h6>
                            <small>Make: <?= esc($car['make_display']); ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Local DB Cars -->
    <?php if (!empty($cars)): ?>
        <h3 class="mt-5">📦 Cars from Our Database</h3>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
            <?php foreach ($cars as $car): ?>
                <div class="col">
                    <div class="card p-2">
                        <?php if (!empty($car['poster'])): ?>
                            <img src="<?= esc($car['poster']); ?>" class="car-image" alt="Car Poster">
                        <?php endif; ?>
                        <div class="card-body text-center">
                            <h6><?= esc($car['name']); ?> (<?= esc($car['brand']); ?>)</h6>
                            <p class="average-rating">⭐ <?= number_format($car['average_rating'], 1); ?> / 5</p>
                            <a href="<?= base_url('/car/' . $car['id']); ?>" class="btn btn-info btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (empty($apiCars) && empty($cars)): ?>
        <div class="alert alert-warning mt-4 text-center">
            😕 No results found. Try another search!
        </div>
    <?php endif; ?>
</div>

</body>
</html>
