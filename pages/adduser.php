<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add User Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            margin-bottom: 20px;
        }

        .form-header h2 {
            font-size: 24px;
            color: #343a40;
        }

        .form-label {
            margin-top: 10px;
            color: #495057;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }

        .error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
        }

        .submit-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }

        .btn-submit {
            width: 48%;
            background-color: #198754;
            border-color: #198754;
        }

        .btn-submit:hover {
            background-color: #157347;
            border-color: #146c43;
        }

        .btn-reset {
            width: 48%;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-reset:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        /* Custom styling for the select dropdown */
        .form-select {
            height: calc(2.25rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border-radius: 0.375rem;
            background-color: #ffffff;
            border: 1px solid #ced4da;
            box-shadow: inset 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <div class="form-header text-center">
                <h2>Add User</h2>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="Name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="Name" name="name" value="<?= isset($data['name']) ? htmlspecialchars($data['name']) : "" ?>" />
                    <div class="error"><?= isset($errors['name']) ? htmlspecialchars($errors['name']) : "" ?></div>
                </div>

                <div class="mb-3">
                    <label for="Email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="Email" name="email" value="<?= isset($data['email']) ? htmlspecialchars($data['email']) : "" ?>" />
                    <div class="error"><?= isset($errors['email']) ? htmlspecialchars($errors['email']) : "" ?></div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?= isset($data['password']) ? htmlspecialchars($data['password']) : "" ?>" />
                    <div class="error"><?= isset($errors['password']) ? htmlspecialchars($errors['password']) : "" ?></div>
                </div>

                <div class="mb-3">
                    <label for="ConfirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="ConfirmPassword" name="confirmPassword" value="<?= isset($data['confirmPassword']) ? htmlspecialchars($data['confirmPassword']) : "" ?>" />
                    <div class="error"><?= isset($errors['confirmPassword']) ? htmlspecialchars($errors['confirmPassword']) : "" ?></div>
                </div>

                <div class="mb-3">
                    <label for="room" class="form-label">Room No</label>
                    <select id="room" name="room" class="form-select">
                        <option value="">Select Room</option>
                        <option value="Application1">Application1</option>
                        <option value="Application2">Application2</option>
                        <option value="Cloud">Cloud</option>
                    </select>
                    <div class="error"><?= isset($errors['room']) ? htmlspecialchars($errors['room']) : "" ?></div>
                </div>

                <div class="mb-3">
                    <label for="profile" class="form-label">Profile Picture</label>
                    <input type="file" id="profile" name="image" class="form-control" />
                    <?php if (strpos($response, "../uploads/") !== 0): ?>
                        <div class="error"><?= htmlspecialchars($response) ?></div>
                    <?php endif; ?>
                </div>

                <div class="submit-buttons">
                    <input type="submit" value="Submit" name="submit-btn" class="btn btn-submit" />
                    <input type="reset" value="Reset" class="btn btn-reset" />
                </div>
            </form>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>