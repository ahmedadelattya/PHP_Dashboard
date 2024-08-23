<?php
class image
{
    public function image_validation($image_name, $image_size, $image_temp, $image_type)
    {
        if (empty($image_name)) {
            return 'Please select a file';
        }

        // Validate MIME type using finfo
        $file_info = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $file_info->file($image_temp);

        $allowed_images_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];

        if (!in_array($mime_type, $allowed_images_types)) {
            return 'Only JPEG, JPG, PNG, and GIF image files are allowed';
        }

        // Validate file size
        $upload_max_size = 2 * 1024 * 1024; // 2MB
        if ($image_size > $upload_max_size) {
            return "Image must be less than 2MB";
        }

        // Generate a unique file name
        $str = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $length = 10;
        $new_name = substr(str_shuffle($str), 0, $length);

        $extension = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_name = $new_name . "." . $extension;

        // Ensure the 'uploads' directory exists
        $upload_dir = "../uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Check if the file already exists in the directory
        if (file_exists($upload_dir . $image_name)) {
            return "Image already exists in the folder";
        }

        // Move the uploaded file to the target directory
        $move_file = move_uploaded_file($image_temp, $upload_dir . $image_name);
        if (!$move_file) {
            return "File not saved. Please try again";
        }

        // Return the path to the saved image for further use
        return $upload_dir . $image_name;
    }
}
