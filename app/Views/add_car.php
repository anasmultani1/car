<!DOCTYPE html>
<html>
<head>
    <title>Add Car</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Add a New Car</h1>
        <form action="<?= base_url('/save-car'); ?>" method="post" class="mt-4">

            <div class="mb-3">
                <label class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Brand:</label>
                <input type="text" name="brand" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description:</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Release Year:</label>
                <input type="number" name="release_year" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Poster URL:</label>
                <input type="text" name="poster" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</body>
</html>
