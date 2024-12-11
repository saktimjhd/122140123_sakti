<?php
require_once 'config.php';

$message = '';
$product = null;

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch();

    if (!$product) {
        header("Location: index.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $stmt = $pdo->prepare("
            UPDATE products 
            SET product_name = ?, 
                description = ?, 
                price = ?, 
                stock = ?
            WHERE id = ?
        ");
        
        $stmt->execute([
            $_POST['product_name'],
            $_POST['description'],
            $_POST['price'],
            $_POST['stock'],
            $_GET['id']
        ]);
        
        $message = '<div class="alert alert-success">Produk berhasil diperbarui!</div>';
        
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $product = $stmt->fetch();
    } catch(PDOException $e) {
        $message = '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Edit Produk</h1>
            <a href="index.php" class="btn btn-primary">Kembali Ke Beranda</a>
        </header>

        <div class="form-container">
            <?php if ($message) echo $message; ?>
            
            <form action="" method="POST">
                <div class="form-group">
                    <label for="product_name">Nama Produk</label>
                    <input type="text" id="product_name" name="product_name" class="form-control" 
                           value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description" class="form-control" 
                              rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Harga (Rp)</label>
                    <input type="number" id="price" name="price" class="form-control" 
                           value="<?php echo $product['price']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="stock">Stok</label>
                    <input type="number" id="stock" name="stock" class="form-control" 
                           value="<?php echo $product['stock']; ?>" required>
                </div>

                

                <button type="submit" class="btn btn-success">Update Produk</button>
            </form>
        </div>
    </div>
</body>
</html>