<?php
$name = '';
$nameSafe = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name'])) {
        $name = trim($_POST['name']);
    }

    $nameSafe = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $message = 'Đã nhận thông tin của ' . $nameSafe;
}
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form POST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="text-center mb-4">
                    <h1 class="fw-semibold">Đăng ký</h1>
                    <p class="text-muted mb-0">Nhập thông tin để gửi đăng ký.</p>
                </div>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form method="post" action="" class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label">Tên</label>
                                <input type="text" id="name" name="name" class="form-control" value="<?php echo $nameSafe; ?>">
                            </div>
                            <div class="col-12">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Đăng ký</button>
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
