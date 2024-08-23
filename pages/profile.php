<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
    <div class="profile-container">
        <div class="card">
            <h2 class="text-center">Edit Profile</h2>

            <!-- Display Success Message -->
            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <!-- Display Errors -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
        </div>
    <?php endif; ?>

    <form method="post" action="../handlers/update_profile.php" enctype="multipart/form-data">
        <div class="text-center">
            <img src="<?= htmlspecialchars($result['prof_pic'] ?? 'default.jpg') ?>" alt="Profile Picture" class="img-fluid">
        </div>
        <div class="form-group">
            <label for="email" class="form-label">Email:</label>
            <input type="email" readonly class="form-control" id="email" name="email" value="<?= htmlspecialchars($result['email']) ?>" required>
        </div>
        <div class="form-group">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($result['name']) ?>" required>
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
            <input type="text" class="form-control" id="room" name="room" value="<?= htmlspecialchars($result['room']) ?>" required>
        </div>
        <div class="form-group">
            <label for="prof_pic" class="form-label">Profile Picture:</label>
            <input type="file" class="form-control" id="prof_pic" name="image">
            <small class="form-text text-muted">Leave blank if you do not want to change your profile Picture</small>

        </div>
        <div class="d-grid">
            <input type="submit" class="btn btn-update" value="Update Profile" name="submit-btn">
        </div>
    </form>

    </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>