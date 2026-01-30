<?php
$keyword = '';
$keywordSafe = '';
$message = '';

if (isset($_GET['keyword'])) {
    $keyword = trim($_GET['keyword']);
    $keywordSafe = htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8');
    $message = 'Bạn đang tìm kiếm từ khóa: ' . $keywordSafe;
}
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form GET</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="text-center mb-4">
                    <h1 class="fw-semibold">Tìm kiếm</h1>
                    <p class="text-muted mb-0">Nhập từ khóa bạn muốn tìm.</p>
                </div>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form method="get" action="">
                            <div class="input-group input-group-lg">
                                <input type="text" id="keyword" name="keyword" class="form-control" placeholder="Nhập từ khóa..." value="<?php echo $keywordSafe; ?>">
                                <button type="submit" class="btn btn-primary">Tìm</button>
                            </div>
                        </form>

                        <?php if ($message !== ''): ?>
                            <div class="alert alert-success mt-4 mb-0"><?php echo $message; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
