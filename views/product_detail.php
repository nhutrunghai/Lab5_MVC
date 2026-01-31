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
    <title>Chi tiet san pham</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Chi tiet san pham</h1>
                    <div class="text-muted">Thong tin chi tiet san pham.</div>
                </div>
                <a href="index.php?page=product-list" class="btn btn-outline-secondary">Quay lai danh sach</a>
            </div>
        </div>

        <?php if (empty($product)): ?>
            <div class="alert alert-warning">Khong tim thay san pham.</div>
        <?php else: ?>
            <?php
            $id = $product['id'] ?? '';
            $name = $product['name'] ?? '';
            $price = $product['price'] ?? '';
            $avatar = $product['avatar'] ?? '';
            $description = $product['description'] ?? '';
            ?>
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="row g-4 align-items-start">
                        <div class="col-md-4">
                            <?php if ($avatar !== ''): ?>
                                <img src="<?php echo htmlspecialchars((string)$avatar, ENT_QUOTES, 'UTF-8'); ?>" alt="San pham" class="img-fluid rounded shadow-sm">
                            <?php else: ?>
                                <div class="text-muted">Khong co hinh anh</div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <h2 class="h4 mb-3"><?php echo htmlspecialchars((string)$name, ENT_QUOTES, 'UTF-8'); ?></h2>
                            <div class="d-flex flex-wrap gap-3 mb-3">
                                <div class="badge text-bg-light border">ID: <?php echo htmlspecialchars((string)$id, ENT_QUOTES, 'UTF-8'); ?></div>
                                <div class="badge text-bg-primary">Gia: <?php echo htmlspecialchars(format_price($price), ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                            <div>
                                <div class="fw-semibold mb-2">Mo ta</div>
                                <p class="mb-0"><?php echo htmlspecialchars((string)$description, ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                            <div class="mt-4 d-flex gap-2">
                                <a href="index.php?page=product-edit&id=<?php echo htmlspecialchars((string)$id, ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline-primary">Sua san pham</a>
                                <button type="button" class="btn btn-outline-danger js-delete-btn" data-delete-url="index.php?page=product-delete&id=<?php echo htmlspecialchars((string)$id, ENT_QUOTES, 'UTF-8'); ?>">Xoa san pham</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
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
