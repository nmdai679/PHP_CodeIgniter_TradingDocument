<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Trade Hub | Chợ Pass Tài Liệu Sinh Viên</title>
    <!-- Bootstrap 5 & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #0072bc;
            --primary-hover: #005b9f;
            --bg-color: #f8f9fa;
            --card-radius: 12px;
        }
        body {
            background-color: var(--bg-color);
            font-family: 'Inter', sans-serif;
            color: #333;
        }
        /* Navbar Styling */
        .navbar-custom {
            background-color: var(--primary);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .navbar-custom .navbar-brand {
            color: #fff;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        /* Card Styling */
        .card-post {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        .card-post:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0, 114, 188, 0.15);
        }
        .card-img-top {
            height: 220px;
            object-fit: cover;
            border-top-left-radius: var(--card-radius);
            border-top-right-radius: var(--card-radius);
        }
        .badge-category {
            background-color: #e6f2f9;
            color: var(--primary);
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        .price-tag {
            font-size: 1.3rem;
            color: #d93025;
            font-weight: 700;
        }
        .status-sold {
            opacity: 0.7;
            filter: grayscale(100%);
            pointer-events: none;
        }
        .btn-primary-custom {
            background-color: var(--primary);
            border-color: var(--primary);
            font-weight: 600;
            border-radius: 8px;
        }
        .btn-primary-custom:hover {
            background-color: var(--primary-hover);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom sticky-top py-3">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url('trade') ?>"><i class="fas fa-graduation-cap me-2"></i>Campus Trade Hub</a>
        <button class="btn btn-light text-primary fw-bold rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#createPostModal">
            <i class="fas fa-plus me-1"></i> Đăng Tài Liệu
        </button>
    </div>
</nav>

<div class="container py-5">
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <h3 class="fw-bold mb-4" style="color: var(--primary);">Khám phá tài liệu <i class="fas fa-book-open ms-2"></i></h3>

    <div class="row g-4">
        <?php foreach($posts as $post): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card card-post <?= $post['status'] == 'sold' ? 'status-sold bg-light' : '' ?>">
                    <img src="<?= base_url($post['image_url']) ?>" class="card-img-top" alt="<?= $post['title'] ?>" onerror="this.src='https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=400&q=80';">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge-category"><?= $post['category_name'] ?></span>
                        </div>
                        <h5 class="card-title fw-bold text-dark mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <?= $post['title'] ?>
                        </h5>
                        <p class="card-text text-muted small mb-3 flex-grow-1"><?= htmlspecialchars($post['description']) ?></p>
                        <hr class="text-muted opacity-25">
                        <div class="d-flex justify-content-between align-items-center mb-0">
                            <span class="price-tag"><?= number_format($post['price'], 0, ',', '.') ?>đ</span>
                            <div style="pointer-events: auto;">
                                <?php if($post['status'] == 'available'): ?>
                                    <a href="<?= site_url('trade/update_status/'.$post['id']) ?>" class="btn btn-sm btn-outline-success fw-bold rounded-3" title="Chốt đơn/Đã Pass">
                                        <i class="fas fa-check"></i> Đã Pass
                                    </a>
                                <?php else: ?>
                                    <span class="badge bg-secondary fw-bold p-2"><i class="fas fa-lock"></i> Đã giao dịch</span>
                                <?php endif; ?>
                                <a href="<?= site_url('trade/delete/'.$post['id']) ?>" class="btn btn-sm btn-outline-danger ms-1 rounded-3" onclick="return confirm('Bạn có chắc chắn muốn xóa bài đăng này?');" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 px-4 pb-3 pt-0 text-muted small fw-medium">
                        <i class="fas fa-user-circle me-1 text-primary"></i> <?= $post['username'] ?> &bull; <i class="far fa-clock ms-1"></i> <?= date('d/m/Y', strtotime($post['created_at'])) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal Đăng Bài (Minimalism, Bo tròn tĩnh tế) -->
<div class="modal fade" id="createPostModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg" style="border-radius: var(--card-radius); border: none;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h4 class="modal-title fw-bold" style="color: var(--primary);">Đăng tài liệu lên Chợ Pass</h4>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="<?= site_url('trade/create') ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Tên tài liệu / Sách</label>
                        <input type="text" class="form-control form-control-lg rounded-3 fs-6" name="title" required placeholder="Nhập tên giáo trình, tài liệu...">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-secondary">Danh mục môn học</label>
                            <select class="form-select form-select-lg rounded-3 fs-6" name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>
                                <?php foreach($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-secondary">Giá Pass (VNĐ)</label>
                            <div class="input-group">
                                <input type="number" class="form-control form-control-lg rounded-start fs-6" name="price" required placeholder="Ví dụ: 50000">
                                <span class="input-group-text rounded-end fw-bold text-muted border-start-0 bg-light">VNĐ</span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Tình trạng & Mô tả chi tiết</label>
                        <textarea class="form-control rounded-3" name="description" rows="4" placeholder="Sách bao nhiêu %, có ghi chú/highlight gì bên trong không..."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Hình ảnh thực tế <small class="text-muted fw-normal">(Khuyên dùng tỉ lệ 16:9)</small></label>
                        <input type="file" class="form-control form-control-lg rounded-3 fs-6" name="image" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100 py-3 fs-5 rounded-3">Gửi Bài Đăng <i class="fas fa-paper-plane ms-2"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
