<?php
function format_price($value): string
{
    if ($value === null || $value === '') {
        return '';
    }
    return number_format((float)$value, 0, ',', '.') . ' VND';
}

$status = $_GET['status'] ?? '';
$toastMessage = '';
$toastClass = 'text-bg-success';
if ($status === 'deleted') {
    $toastMessage = 'Da xoa san pham thanh cong.';
} elseif ($status === 'added') {
    $toastMessage = 'Da them san pham thanh cong.';
} elseif ($status === 'updated') {
    $toastMessage = 'Da cap nhat san pham thanh cong.';
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
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h1 class="h3 mb-1">Chao mung den voi MVC!</h1>
                <div class="text-muted">Thong tin: <?php echo htmlspecialchars($studentInfo, ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                    <h2 class="h5 mb-0">Danh sach san pham</h2>
                    <a href="index.php?page=product-add" class="btn btn-primary">Them san pham</a>
                </div>

                <?php if (empty($products)): ?>
                    <div class="alert alert-warning">Chua co san pham nao.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 70px;">ID</th>
                                    <th>Ten</th>
                                    <th style="width: 140px;">Avatar</th>
                                    <th style="width: 140px;">Gia</th>
                                    <th style="width: 220px;">Hanh dong</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <?php
                                    $id = $product['id'] ?? '';
                                    $name = $product['name'] ?? '';
                                    $price = $product['price'] ?? '';
                                    $avatar = $product['avatar'] ?? '';
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars((string)$id, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars((string)$name, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <?php if ($avatar !== ''): ?>
                                                <img src="<?php echo htmlspecialchars((string)$avatar, ENT_QUOTES, 'UTF-8'); ?>" alt="San pham" style="height: 48px;" class="img-thumbnail">
                                            <?php else: ?>
                                                <span class="text-muted">Khong co</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars(format_price($price), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <a href="index.php?page=product-detail&id=<?php echo htmlspecialchars((string)$id, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-sm btn-outline-secondary">Chi tiet</a>
                                            <a href="index.php?page=product-edit&id=<?php echo htmlspecialchars((string)$id, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-sm btn-outline-primary">Sua</a>
                                            <button type="button" class="btn btn-sm btn-outline-danger js-delete-btn" data-delete-url="index.php?page=product-delete&id=<?php echo htmlspecialchars((string)$id, ENT_QUOTES, 'UTF-8'); ?>">Xoa</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xac nhan xoa</h5>
                    <button type="button" class="btn-close" data-close="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Ban co chac muon xoa san pham nay khong?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-close="modal">Huy</button>
                    <a href="#" class="btn btn-danger" id="confirmDeleteBtn">Xoa</a>
                </div>
            </div>
        </div>
    </div>

    <?php if ($toastMessage !== ''): ?>
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="statusToast" class="toast align-items-center <?php echo $toastClass; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo htmlspecialchars($toastMessage, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const deleteModal = document.getElementById('deleteModal');
        const confirmDeleteBtn = deleteModal ? deleteModal.querySelector('#confirmDeleteBtn') : null;
        const closeButtons = deleteModal ? deleteModal.querySelectorAll('[data-close="modal"]') : [];
        let backdropEl = null;
        let bsModal = null;

        if (deleteModal && window.bootstrap && window.bootstrap.Modal) {
            bsModal = new bootstrap.Modal(deleteModal);
        }

        function openModal() {
            if (bsModal) {
                bsModal.show();
                return;
            }
            deleteModal.classList.add('show');
            deleteModal.style.display = 'block';
            deleteModal.setAttribute('aria-modal', 'true');
            backdropEl = document.createElement('div');
            backdropEl.className = 'modal-backdrop fade show';
            document.body.appendChild(backdropEl);
        }

        function closeModal() {
            if (bsModal) {
                bsModal.hide();
                return;
            }
            deleteModal.classList.remove('show');
            deleteModal.style.display = 'none';
            deleteModal.removeAttribute('aria-modal');
            if (backdropEl) {
                backdropEl.remove();
                backdropEl = null;
            }
        }

        document.querySelectorAll('.js-delete-btn').forEach((btn) => {
            btn.addEventListener('click', (event) => {
                event.preventDefault();
                if (!deleteModal || !confirmDeleteBtn) {
                    return;
                }
                const url = btn.getAttribute('data-delete-url') || '#';
                confirmDeleteBtn.setAttribute('href', url);
                openModal();
            });
        });

        closeButtons.forEach((btn) => {
            btn.addEventListener('click', (event) => {
                event.preventDefault();
                closeModal();
            });
        });
    </script>
    <?php if ($toastMessage !== ''): ?>
        <script>
            const toastEl = document.getElementById('statusToast');
            if (toastEl) {
                const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
                toast.show();
            }
        </script>
    <?php endif; ?>
</body>
</html>
