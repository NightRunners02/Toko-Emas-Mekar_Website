<?php
include 'db.php';

// MUAT DATA LAMA UNTUK EDIT
$product = [
    'name' => '',
    'weight' => '',
    'type' => '',
    'quantity' => '',
    'price' => '',
    'rating' => '',
    'image' => ''
];

if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
    $product = mysqli_fetch_assoc($result);
}

// UPDATE PRODUK YANG DIEDIT
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $weight = $_POST['weight'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $rating = $_POST['rating'];

    // Periksa apakah gambar diunggah ulang
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = 'uploads/' . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $query = "UPDATE products SET name='$name', weight='$weight', type='$type', quantity='$quantity', price='$price', rating='$rating', image='$image' WHERE id=$id";
    } else {
        // Jika gambar tidak diubah
        $query = "UPDATE products SET name='$name', weight='$weight', type='$type', quantity='$quantity', price='$price', rating='$rating' WHERE id=$id";
    }

    // Periksa hasil query
    if (mysqli_query($conn, $query)) {
        header('Location: admin.php?success=update');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
