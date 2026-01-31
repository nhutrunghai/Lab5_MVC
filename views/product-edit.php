<?php
$old = $old ?? [
    'id' => '',
    'name' => '',
    'price' => '',
    'description' => '',
    'avatar' => '',
];
$errors = $errors ?? [];
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cap nhat san pham</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Cap nhat san pham</h1>
                    <div class="text-muted">Chinh sua thong tin san pham.</div>
                </div>
                <a href="index.php?page=product-list" class="btn btn-outline-secondary">Quay lai danh sach</a>
            </div>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="post" action="index.php?page=product-update" class="row g-3">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars((string)$old['id'], ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="col-12">
                        <label for="name" class="form-label">Ten san pham</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($old['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="price" class="form-label">Gia</label>
                        <input type="number" id="price" name="price" class="form-control" value="<?php echo htmlspecialchars($old['price'], ENT_QUOTES, 'UTF-8'); ?>" step="0.01" min="0" required>
                    </div>
                    <div class="col-md-8">
                        <label for="avatar" class="form-label">Avatar (URL)</label>
                        <input type="text" id="avatar" name="avatar" class="form-control" value="<?php echo htmlspecialchars($old['avatar'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="https://..." required>
                    </div>
                    <div class="col-12">
                        <label for="description" class="form-label">Mo ta</label>
                        <textarea id="description" name="description" class="form-control" rows="4"><?php echo htmlspecialchars($old['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Cap nhat</button>
                        <a href="index.php?page=product-list" class="btn btn-outline-secondary">Huy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
