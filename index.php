<?php
require_once 'config.php';

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit();
}

$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Produk</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1 style="margin-bottom: 0;">Sistem Manajemen Produk</h1>
            <p>Kelola barang Anda dengan mudah dan efisien</p>
            <a href="add.php" class="btn btn-primary">Tambah Produk Baru</a>
        </header>

        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                   
                    
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <div class="price">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></div>
                        <p>Stok: <?php echo $product['stock']; ?></p>
                        
                        <div class="action-buttons">
                            <a href="edit.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">Edit</a>
                            <form action="" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger" 
                                        onclick="return confirm('Apakah Anda yakin untuk menghapus produk ini?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>