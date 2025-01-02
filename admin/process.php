<?php
include 'db.php';

// Tambah Produk
if (isset($_POST['add_product'])) {
    $title    = $_POST['title'];
    $type     = $_POST['type'];
    $weight   = $_POST['weight'];
    $quantity = $_POST['quantity'];

    // Upload Gambar
    $image_name = $_FILES['image']['name'];
    $image_tmp  = $_FILES['image']['tmp_name'];
    $image_path = "assets/images/" . $image_name;
    move_uploaded_file($image_tmp, $image_path);

    // Insert ke Database
    $query = "INSERT INTO products (title, type, weight, quantity, image) 
              VALUES ('$title', '$type', '$weight', '$quantity', '$image_name')";

    mysqli_query($conn, $query);
    header("Location: admin.php");
}

// Hapus Produk
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Hapus gambar
    $query = "SELECT image FROM products WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    unlink("assets/images/" . $row['image']);

    // Hapus produk dari database
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header("Location: admin.php");
}
?>
