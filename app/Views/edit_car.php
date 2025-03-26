<!DOCTYPE html>
<html>
<head>
    <title>Edit Car</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <form action="<?= base_url('/update-car/' . $car['id']); ?>" method="post">
            <div class="mb-3">
                <label>Car Name:</label>
                <input type="text" name="name" value="<?= $car['name']; ?>" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update Car</button>
        </form>
    </div>
</body>
</html>
