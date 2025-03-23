<!DOCTYPE html>
<html>
<head>
    <title>Car List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>All Cars</h1>
    <a href="<?= base_url('/add-car'); ?>">Add New Car</a>
    <ul>
        <?php foreach ($cars as $car): ?>
            <li>
                <h3><?= $car['name']; ?> - <?= $car['brand']; ?> (<?= $car['release_year']; ?>)</h3>
                <p><?= $car['description']; ?></p>
                
                <!-- Display Reviews -->
                <h4>Reviews:</h4>
                <?php if (!empty($car['reviews'])): ?>
                    <ul>
                        <?php foreach ($car['reviews'] as $review): ?>
                            <li>
                                <strong><?= $review['username']; ?></strong>: <?= $review['review']; ?> 
                                (Rating: <?= $review['rating']; ?>/5)
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No reviews yet.</p>
                <?php endif; ?>

                <!-- Add Review Form -->
                <form class="review-form" data-car-id="<?= $car['id']; ?>">
                    <input type="text" name="username" placeholder="Your Name" required>
                    <textarea name="review" placeholder="Write your review" required></textarea>
                    <input type="number" name="rating" min="1" max="5" placeholder="Rating (1-5)" required>
                    <button type="submit">Submit Review</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

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
