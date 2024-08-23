<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <!-- <h1 class="mb-4">Users List</h1> -->
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <form action="show_user.php" method="get">
                                <input type="hidden" name="email" value="<?php echo $user['email']; ?>">
                                <input type="submit" class="btn btn-primary btn-sm" value="Update" name="submit-btn"></input>
                            </form>
                        </td>
                        <td>
                            <form action="../handlers/delete_user.php" method="post" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                <input type="hidden" name="email" value="<?php echo $user['email']; ?>">
                                <input type="submit" class="btn btn-danger btn-sm" value="Delete" name="submit-btn"></input>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>