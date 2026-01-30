<?php
$headers = [];
if (!empty($products)) {
    $headers = array_keys($products[0]);
}
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <h1 class="mb-3">Chao mung den voi MVC!</h1>
        <p class="mb-4">Thong tin: <?php echo htmlspecialchars($studentInfo, ENT_QUOTES, 'UTF-8'); ?></p>

        <h2 class="h4 mb-3">Danh sach san pham</h2>

        <?php if (empty($products)): ?>
            <div class="alert alert-warning">Chua co san pham nao.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <?php foreach ($headers as $header): ?>
                                <th><?php echo htmlspecialchars($header, ENT_QUOTES, 'UTF-8'); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <?php foreach ($headers as $header): ?>
                                    <td><?php echo htmlspecialchars((string)($product[$header] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
