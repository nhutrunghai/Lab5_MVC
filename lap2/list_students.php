<?php
require_once __DIR__ . '/db_connect.php';

$message = '';
$messageType = 'success';
$editMode = false;
$editId = 0;
$editFullName = '';
$editStudentCode = '';
$editEmail = '';

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id > 0) {
        $deleteSql = 'DELETE FROM students WHERE id = ?';
        $deleteStmt = $pdo->prepare($deleteSql);
        $deleteStmt->execute([$id]);

        $message = 'Đã xóa sinh viên.';
        $messageType = 'success';
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'edit') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id > 0) {
        $editSql = 'SELECT * FROM students WHERE id = ?';
        $editStmt = $pdo->prepare($editSql);
        $editStmt->execute([$id]);
        $row = $editStmt->fetch();

        if ($row) {
            $editMode = true;
            $editId = (int)$row['id'];
            $editFullName = $row['fullname'];
            $editStudentCode = $row['student_code'];
            $editEmail = $row['email'];
        } else {
            $message = 'Không tìm thấy sinh viên.';
            $messageType = 'danger';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $editId = (int)$_POST['update_id'];

    if (isset($_POST['full_name'])) {
        $editFullName = trim($_POST['full_name']);
    }
    if (isset($_POST['student_code'])) {
        $editStudentCode = trim($_POST['student_code']);
    }
    if (isset($_POST['email'])) {
        $editEmail = trim($_POST['email']);
    }

    if ($editFullName === '' || $editStudentCode === '' || $editEmail === '') {
        $message = 'Vui lòng nhập đầy đủ thông tin.';
        $messageType = 'danger';
        $editMode = true;
    } else {
        $checkSql = 'SELECT id FROM students WHERE (student_code = ? OR email = ?) AND id <> ? LIMIT 1';
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([$editStudentCode, $editEmail, $editId]);

        if ($checkStmt->fetch()) {
            $message = 'Mã SV hoặc Email đã tồn tại.';
            $messageType = 'danger';
            $editMode = true;
        } else {
            $updateSql = 'UPDATE students SET fullname = ?, student_code = ?, email = ? WHERE id = ?';
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([$editFullName, $editStudentCode, $editEmail, $editId]);

            $message = 'Cập nhật sinh viên thành công!';
            $messageType = 'success';
            $editMode = false;
        }
    }
}

$sql = 'SELECT * FROM students ORDER BY id DESC';
$stmt = $pdo->query($sql);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

$editFullNameSafe = htmlspecialchars($editFullName, ENT_QUOTES, 'UTF-8');
$editStudentCodeSafe = htmlspecialchars($editStudentCode, ENT_QUOTES, 'UTF-8');
$editEmailSafe = htmlspecialchars($editEmail, ENT_QUOTES, 'UTF-8');
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Danh sách sinh viên</h1>
            <a href="add_student.php" class="btn btn-outline-secondary">Thêm sinh viên</a>
        </div>

        <?php if ($message !== ''): ?>
            <div class="alert alert-<?php echo $messageType; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if ($editMode): ?>
            <div class="card mb-4">
                <div class="card-header">Chỉnh sửa sinh viên</div>
                <div class="card-body">
                    <form method="post" action="" class="row g-3">
                        <input type="hidden" name="update_id" value="<?php echo $editId; ?>">
                        <div class="col-12">
                            <label for="full_name" class="form-label">Họ tên</label>
                            <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo $editFullNameSafe; ?>">
                        </div>
                        <div class="col-12">
                            <label for="student_code" class="form-label">Mã SV</label>
                            <input type="text" id="student_code" name="student_code" class="form-control" value="<?php echo $editStudentCodeSafe; ?>">
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo $editEmailSafe; ?>">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="list_students.php" class="btn btn-outline-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <?php if (count($students) === 0): ?>
            <div class="alert alert-warning">Chưa có sinh viên nào.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Họ tên</th>
                            <th>Mã SV</th>
                            <th>Email</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($student['fullname'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($student['student_code'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <a href="list_students.php?action=edit&id=<?php echo $student['id']; ?>" class="btn btn-sm btn-outline-primary">Sửa</a>
                                    <a href="list_students.php?action=delete&id=<?php echo $student['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
