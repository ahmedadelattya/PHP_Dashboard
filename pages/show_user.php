<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
        }

        .profile-container {
            max-width: 800px;
            margin: 30px auto;
        }

        .card {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .profile-container img {
            max-width: 200px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn-update {
            background: #28a745;
            color: #fff;
        }

        .btn-update:hover {
            background: #218838;
        }

        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .error::before {
            content: "* ";
        }
    </style>
</head>

<body>
    <!-- Sticky Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php?page=profile">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php?page=addUser">Add User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php?page=listUsers">List Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="profile-container">
        <div class="card">
            <h2 class="text-center">Edit User</h2>

            <!-- Display Success Message -->
            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <!-- Display Errors -->
            <?php if (!empty($_SESSION['errors'])): ?>
                <div class="alert alert-danger">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                    <?php unset($_SESSION['errors']); ?>
                </div>
            <?php endif; ?>

            <?php if ($result): ?>
                <form method="post" action="show_user.php" enctype="multipart/form-data">
                    <div class="text-center">
                        <img src="<?= htmlspecialchars($imagePath ?? $result['prof_pic'] ?? 'default.jpg') ?>" alt="Profile Picture" class="img-fluid">
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" readonly class="form-control" id="email" name="email" value="<?= htmlspecialchars($email ?? $result['email']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($name ?? $result['name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">New Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <small class="form-text text-muted">Leave blank if you do not want to change your password.</small>
                    </div>
                    <div class="form-group">
                        <label for="confPassword" class="form-label">Confirm New Password:</label>
                        <input type="password" class="form-control" id="confPassword" name="confPassword">
                    </div>
                    <div class="form-group">
                        <label for="room" class="form-label">Room:</label>
                        <input type="text" class="form-control" id="room" name="room" value="<?= htmlspecialchars($selected_room ?? $result['room']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="prof_pic" class="form-label">Profile Picture:</label>
                        <input type="file" class="form-control" id="prof_pic" name="image">
                        <small class="form-text text-muted">Leave blank if you do not want to change your profile picture.</small>
                    </div>
                    <div class="d-grid">
                        <input type="submit" class="btn btn-update" value="Update Profile" name="submit-btn">
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>