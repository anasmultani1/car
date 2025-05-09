<!DOCTYPE html>
<html>
<head>
    <title>Edit Review</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <form action="<?= base_url('/update-review/' . $review['id']); ?>" method="post">
            <div class="mb-3">
                <textarea name="review" class="form-control" required><?= esc($review['review']); ?></textarea>
            </div>
            <div class="mb-3">
                <label>Rating:</label>
                <select name="rating" class="form-select" required>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?= $i ?>" <?= ($review['rating'] == $i ? 'selected' : '') ?>><?= $i ?>/5</option>
                    <?php endfor; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Review</button>
        </form>
    </div>
</body>
</html>
