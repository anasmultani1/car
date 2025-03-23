<!DOCTYPE html>
<html>
<head>
    <title>Car List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">All Cars</h1>
        <a href="<?= base_url('/add-car'); ?>" class="btn btn-success mb-3">Add New Car</a>

        <?php foreach ($cars as $car): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title"><?= $car['name']; ?> - <?= $car['brand']; ?> (<?= $car['release_year']; ?>)</h3>
                    <p class="card-text"><?= $car['description']; ?></p>
                    
                    <?php if (isset($car['poster']) && !empty($car['poster'])): ?>
                        <img src="<?= $car['poster']; ?>" alt="Poster" class="img-fluid mb-3">
                    <?php endif; ?>

                    <!-- Display Reviews -->
                    <h4>Reviews:</h4>
                    <?php if (!empty($car['reviews'])): ?>
                        <ul class="list-group mb-3">
                            <?php foreach ($car['reviews'] as $review): ?>
                                <li class="list-group-item">
                                    <strong><?= $review['username']; ?>:</strong> 
                                    <?= $review['review']; ?> (Rating: <?= $review['rating']; ?>/5)
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No reviews yet.</p>
                    <?php endif; ?>

                    <!-- Add Review Form -->
                    <form class="review-form mt-3" data-car-id="<?= $car['id']; ?>">
                        <div class="mb-3">
                            <input type="text" name="username" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="mb-3">
                            <textarea name="review" class="form-control" placeholder="Write your review" required></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="number" name="rating" class="form-control" min="1" max="5" placeholder="Rating (1-5)" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- AJAX Script for Submitting Reviews -->
    <script>
        $(document).ready(function() {
            $('.review-form').submit(function(e) {
                e.preventDefault();

                var form = $(this);
                var carId = form.data('car-id');
                var formData = form.serialize() + '&car_id=' + carId;

                $.ajax({
                    url: '<?= base_url('/save-review'); ?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert('Review submitted successfully!');
                            location.reload();
                        } else {
                            alert('Failed to submit review.');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
 