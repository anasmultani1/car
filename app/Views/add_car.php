<!DOCTYPE html>
<html>
<head>
    <title>Add Car</title>
</head>
<body>
    <h1>Add a New Car</h1>
    <form action="<?= base_url('/save-car'); ?>" method="post">
        <label>Name:</label><input type="text" name="name" required><br>
        <label>Brand:</label><input type="text" name="brand" required><br>
        <label>Description:</label><textarea name="description"></textarea><br>
        <label>Release Year:</label><input type="number" name="release_year"><br>
        <label>Poster URL:</label><input type="text" name="poster"><br>
        <button type="submit">Save</button>
    </form>
</body>
</html>
