<!DOCTYPE html>
<html>
<head>
    <title><?= esc($car['name']) ?> Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"/>
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
        #map {
            height: 400px;
            margin-top: 20px;
            border-radius: 10px;
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

    <!-- Nearby Showrooms -->
    <h4 class="mt-5">Nearby Car Showrooms</h4>
    <div id="map" class="mb-3">Loading map...</div>
    <div id="showroom-results" class="text-muted">Searching for nearby showrooms...</div>

</div>

<!-- Scripts -->
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
            const lat = pos.coords.latitude;
            const lon = pos.coords.longitude;

            const map = L.map('map').setView([lat, lon], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            L.marker([lat, lon]).addTo(map).bindPopup("You are here").openPopup();

            // ? This fixes the 404 issue
            fetch(`<?= base_url('nearby-showrooms') ?>?lat=${lat}&lon=${lon}`)
                .then(res => res.json())
                .then(data => {
                    console.log(data); // optional debug
                    const container = document.getElementById('showroom-results');

                    if (!data.elements.length) {
                        container.innerHTML = '<p>No nearby showrooms found.</p>';
                        return;
                    }

                    const maxVisible = 5;
                    let html = '<ul class="list-group">';
                    data.elements.forEach((el, index) => {
                        const name = el.tags?.name || 'Unnamed showroom';
                        const showLat = el.lat.toFixed(4);
                        const showLon = el.lon.toFixed(4);

                        html += `<li class="list-group-item showroom-item ${index >= maxVisible ? 'd-none' : ''}">
                                    ${name} (${showLat}, ${showLon})
                                </li>`;

                        L.marker([el.lat, el.lon]).addTo(map)
                          .bindPopup(`<b>${name}</b><br>${showLat}, ${showLon}`);
                    });

                    html += '</ul><button class="btn btn-sm btn-outline-secondary mt-2" id="toggle-showrooms">Show More</button>';
                    container.innerHTML = html;

                    document.getElementById('toggle-showrooms').addEventListener('click', () => {
                        const hidden = document.querySelectorAll('.showroom-item.d-none');
                        const isHidden = hidden.length > 0;
                        hidden.forEach(item => item.classList.toggle('d-none'));
                        toggleBtn.textContent = isHidden ? 'Show Less' : 'Show More';
                    });
                });
        }, () => {
            document.getElementById('showroom-results').innerText = "Location access denied.";
        });
    } else {
        document.getElementById('showroom-results').innerText = "Geolocation is not supported by your browser.";
    }
});
</script>
</body>
</html>
