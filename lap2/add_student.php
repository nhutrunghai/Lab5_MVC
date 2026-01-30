<?php
$message = '';
$messageType = 'success';
$fullName = '';
$studentCode = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/db_connect.php';

    if (isset($_POST['full_name'])) {
        $fullName = trim($_POST['full_name']);
    }
    if (isset($_POST['student_code'])) {
        $studentCode = trim($_POST['student_code']);
    }
    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
    }

    if ($fullName === '' || $studentCode === '' || $email === '') {
        $message = 'Vui lòng nhập đầy đủ thông tin.';
        $messageType = 'danger';
    } else {
        $checkSql = 'SELECT id FROM students WHERE student_code = ? OR email = ? LIMIT 1';
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([$studentCode, $email]);

        if ($checkStmt->fetch()) {
            $message = 'Mã SV hoặc Email đã tồn tại.';
            $messageType = 'danger';
        } else {
            $sql = 'INSERT INTO students (fullname, student_code, email) VALUES (?, ?, ?)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$fullName, $studentCode, $email]);

            $message = 'Thêm sinh viên thành công!';
            $messageType = 'success';
        }
    }
}

$fullNameSafe = htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8');
$studentCodeSafe = htmlspecialchars($studentCode, ENT_QUOTES, 'UTF-8');
$emailSafe = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Thêm sinh viên</h1>
            <a href="list_students.php" class="btn btn-outline-secondary">Xem danh sách</a>
        </div>

        <form method="post" action="" class="row g-3">
            <div class="col-12">
                <label for="full_name" class="form-label">Họ tên</label>
                <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo $fullNameSafe; ?>">
            </div>
            <div class="col-12">
                <label for="student_code" class="form-label">Mã SV</label>
                <input type="text" id="student_code" name="student_code" class="form-control" value="<?php echo $studentCodeSafe; ?>">
            </div>
            <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $emailSafe; ?>">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </div>
        </form>

        <?php if ($message !== ''): ?>
            <div class="alert alert-<?php echo $messageType; ?> mt-3"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
