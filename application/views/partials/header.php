<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HCMUE Pass Sách | Chợ Tài Liệu Sinh Viên Sư Phạm</title>
    <meta name="description" content="Trao đổi, mua bán tài liệu, sách giáo trình sinh viên HCMUE - Đại học Sư phạm TP.HCM">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo_hcmue.png') ?>">
    <style>
        :root {
            --hcmue-blue:       #003F8A;
            --hcmue-blue-mid:   #0052B4;
            --hcmue-blue-light: #1A6FCF;
            --hcmue-gold:       #F5A623;
            --hcmue-gold-dark:  #D4891B;
            --bg-page:          #EEF2F9;
            --bg-card:          #FFFFFF;
            --text-dark:        #1A1A2E;
            --text-muted:       #6B7280;
            --border-light:     #E5E9F2;
            --card-radius:      16px;
            --nav-height:       95px;
            --shadow-card:      0 4px 24px rgba(0,63,138,0.08);
            --shadow-hover:     0 12px 40px rgba(0,63,138,0.18);
            --transition:       all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ======================== FOOTER DESIGN (DARK MODE) ======================== */
        .footer-hcmue-dark {
            background-color: var(--hcmue-blue);
            color: rgba(255, 255, 255, 0.75);
            border-top: none;
            position: relative;
        }
        .footer-hcmue-dark .brand-title {
            color: #fff;
            font-size: 1.3rem;
            font-weight: 800;
            margin-top: 15px;
            margin-bottom: 8px;
        }
        .footer-hcmue-dark .brand-tagline {
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 12px;
            max-width: 320px;
        }
        .social-icons {
            display: flex; gap: 12px; margin-top: 15px;
        }
        .social-btn {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex; align-items: center; justify-content: center;
            color: #fff; text-decoration: none;
            transition: all 0.2s;
            font-size: 0.95rem;
        }
        .social-btn:hover {
            color: var(--hcmue-blue);
            background: var(--hcmue-gold);
            border-color: var(--hcmue-gold);
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(245, 166, 35, 0.4);
        }
        .newsletter-box {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        .newsletter-title {
            color: #fff;
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: 0.5px;
        }
        .newsletter-desc {
            font-size: 0.88rem; color: #fff; opacity: 0.8;
            margin-bottom: 20px; line-height: 1.6;
        }
        .newsletter-form {
            position: relative;
            margin-top: 15px;
        }
        .newsletter-input {
            width: 100%;
            padding: 13px 130px 13px 20px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(0, 0, 0, 0.2);
            color: #fff;
            font-size: 0.88rem;
            transition: all 0.2s;
        }
        .newsletter-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        .newsletter-input:focus {
            outline: none; 
            border-color: var(--hcmue-gold); 
            background: rgba(0, 0, 0, 0.3);
            box-shadow: 0 0 0 3px rgba(245, 166, 35, 0.2);
        }
        .newsletter-btn {
            position: absolute;
            top: 4px; right: 4px; bottom: 4px;
            background: var(--hcmue-gold);
            color: var(--hcmue-blue);
            border: none;
            border-radius: 50px;
            padding: 0 20px;
            font-weight: 800;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        .newsletter-btn:hover { 
            background: var(--hcmue-gold-dark); 
            transform: scale(1.02);
        }
        
        .footer-bottom {
            background: rgba(0, 0, 0, 0.15);
            padding: 16px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.6);
        }


        html, body {
            height: 100%;
        }

        body {
            background-color: var(--bg-page);
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            padding-top: var(--nav-height);
            display: flex;
            flex-direction: column;
        }

        /* ======================== NAVBAR ======================== */
        .navbar-hcmue {
            height: var(--nav-height);
            background: linear-gradient(135deg, var(--hcmue-blue) 0%, var(--hcmue-blue-mid) 60%, var(--hcmue-blue-light) 100%);
            box-shadow: 0 4px 20px rgba(0,63,138,0.3);
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
        }
        .navbar-hcmue .brand-logo {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none;
        }
        .brand-icon-img {
            width: 75px; height: 75px;
            object-fit: contain;
            flex-shrink: 0;
        }
        .brand-text .brand-main {
            font-size: 1rem; font-weight: 800;
            color: #fff; line-height: 1.1;
            letter-spacing: -0.2px;
        }
        .brand-text .brand-sub {
            font-size: 0.68rem; color: rgba(255,255,255,0.7);
            font-weight: 400; letter-spacing: 0.3px;
        }
        .nav-icon-btn {
            position: relative;
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 17px;
            text-decoration: none;
            transition: var(--transition);
        }
        .nav-icon-btn:hover {
            background: rgba(255,255,255,0.25);
            color: #fff; transform: translateY(-1px);
        }
        .nav-badge {
            position: absolute; top: -4px; right: -4px;
            background: var(--hcmue-gold);
            color: var(--hcmue-blue);
            font-size: 0.6rem; font-weight: 800;
            border-radius: 50%; width: 18px; height: 18px;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid var(--hcmue-blue);
        }
        .nav-user-chip {
            display: flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50px;
            padding: 5px 14px 5px 6px;
            text-decoration: none; color: #fff;
            transition: var(--transition);
        }
        .nav-user-chip:hover { background: rgba(255,255,255,0.22); color: #fff; }
        .nav-user-avatar {
            width: 28px; height: 28px;
            background: var(--hcmue-gold);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; color: var(--hcmue-blue);
            font-weight: 700;
        }
        .btn-dang-bai {
            background: var(--hcmue-gold);
            color: var(--hcmue-blue);
            border: none; border-radius: 50px;
            padding: 8px 20px;
            font-weight: 700; font-size: 0.88rem;
            display: flex; align-items: center; gap: 6px;
            transition: var(--transition);
            white-space: nowrap;
        }
        .btn-dang-bai:hover {
            background: var(--hcmue-gold-dark);
            color: var(--hcmue-blue);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(245,166,35,0.45);
        }

        /* ======================== ALERTS ======================== */
        .alert-hcmue {
            border: none; border-radius: 12px;
            font-weight: 500; font-size: 0.9rem;
            box-shadow: var(--shadow-card);
        }

        /* ======================== CARDS ======================== */
        .card-post {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: var(--shadow-card);
            transition: var(--transition);
            background: var(--bg-card);
            height: 100%;
            overflow: hidden;
        }
        .card-post:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-hover);
        }
        .card-post .post-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .card-sold .post-img { filter: grayscale(70%); }
        .badge-cat {
            display: inline-flex; align-items: center; gap: 5px;
            background: #E8F0FD;
            color: var(--hcmue-blue-mid);
            font-size: 0.78rem; font-weight: 600;
            padding: 4px 12px; border-radius: 20px;
        }
        .price-tag {
            font-size: 1.2rem;
            color: #D93025;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .status-badge-avail {
            display: inline-flex; align-items: center; gap: 4px;
            background: #D1FAE5; color: #065F46;
            font-size: 0.75rem; font-weight: 600;
            padding: 3px 10px; border-radius: 20px;
        }
        .status-badge-sold {
            display: inline-flex; align-items: center; gap: 4px;
            background: #F3F4F6; color: #6B7280;
            font-size: 0.75rem; font-weight: 600;
            padding: 3px 10px; border-radius: 20px;
        }
        .status-badge-pending {
            display: inline-flex; align-items: center; gap: 4px;
            background: #FEF3C7; color: #92400E;
            font-size: 0.75rem; font-weight: 600;
            padding: 3px 10px; border-radius: 20px;
        }
        .star-display { color: var(--hcmue-gold); font-size: 0.82rem; }
        .star-display .no-rating { color: var(--text-muted); font-size: 0.78rem; }

        /* ======================== BUTTONS ======================== */
        .btn-primary-hcmue {
            background: var(--hcmue-blue);
            color: #fff; border: none;
            border-radius: 10px; font-weight: 600;
            transition: var(--transition);
        }
        .btn-primary-hcmue:hover {
            background: var(--hcmue-blue-light);
            color: #fff; transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(0,63,138,0.3);
        }
        .btn-gold {
            background: var(--hcmue-gold);
            color: var(--hcmue-blue); border: none;
            border-radius: 10px; font-weight: 700;
            transition: var(--transition);
        }
        .btn-gold:hover {
            background: var(--hcmue-gold-dark);
            color: var(--hcmue-blue); transform: translateY(-1px);
        }
        .btn-outline-hcmue {
            border: 2px solid var(--hcmue-blue);
            color: var(--hcmue-blue); border-radius: 10px; font-weight: 600;
            transition: var(--transition); background: transparent;
        }
        .btn-outline-hcmue:hover {
            background: var(--hcmue-blue); color: #fff;
        }

        /* ======================== MODALS ======================== */
        .modal-hcmue .modal-content {
            border: none; border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }
        .modal-hcmue .modal-header {
            background: linear-gradient(135deg, var(--hcmue-blue), var(--hcmue-blue-light));
            border-radius: 20px 20px 0 0;
            border-bottom: none; padding: 20px 28px;
        }
        .modal-hcmue .modal-title { color: #fff; font-weight: 800; }
        .modal-hcmue .btn-close { filter: invert(1); }
        .modal-hcmue .modal-body { padding: 24px 28px; }
        .modal-hcmue .modal-footer { padding: 16px 28px; border-top: 1px solid var(--border-light); }

        /* ======================== FORM ======================== */
        .form-control-hcmue {
            border: 1.5px solid var(--border-light);
            border-radius: 10px; padding: 10px 14px;
            font-size: 0.9rem; transition: var(--transition);
        }
        .form-control-hcmue:focus {
            border-color: var(--hcmue-blue-light);
            box-shadow: 0 0 0 3px rgba(0,63,138,0.12);
        }
        .form-label-hcmue {
            font-weight: 600; font-size: 0.85rem;
            color: var(--text-muted); margin-bottom: 6px;
        }

        /* ======================== SEARCH BAR ======================== */
        .search-section {
            background: #fff;
            border-bottom: 1px solid var(--border-light);
            padding: 16px 0;
            position: sticky; top: var(--nav-height); z-index: 900;
        }
        .search-input-wrap {
            position: relative;
        }
        .search-input-wrap .search-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: var(--text-muted); font-size: 16px;
        }
        .search-input-wrap input {
            padding-left: 42px;
            border: 1.5px solid var(--border-light);
            border-radius: 50px; height: 44px;
            font-size: 0.88rem; width: 100%;
            transition: var(--transition);
        }
        .search-input-wrap input:focus {
            outline: none;
            border-color: var(--hcmue-blue-light);
            box-shadow: 0 0 0 3px rgba(0,63,138,0.1);
        }
        .cat-filter-btn {
            white-space: nowrap;
            border: 1.5px solid var(--border-light);
            border-radius: 50px; padding: 6px 16px;
            font-size: 0.82rem; font-weight: 600;
            background: #fff; color: var(--text-muted);
            transition: var(--transition); text-decoration: none;
            display: inline-block;
        }
        .cat-filter-btn:hover, .cat-filter-btn.active {
            background: var(--hcmue-blue);
            border-color: var(--hcmue-blue);
            color: #fff;
        }
        .filter-scroll {
            display: flex; gap: 8px; overflow-x: auto;
            padding-bottom: 4px; scrollbar-width: none;
        }
        .filter-scroll::-webkit-scrollbar { display: none; }

        /* ======================== SECTION TITLE ======================== */
        .section-title {
            font-size: 1.3rem; font-weight: 800;
            color: var(--hcmue-blue);
            display: flex; align-items: center; gap: 10px;
        }
        .section-title::after {
            content: ''; flex: 1;
            height: 2px;
            background: linear-gradient(to right, var(--hcmue-blue-light), transparent);
            border-radius: 2px;
        }
    </style>
</head>
<body>

<nav class="navbar-hcmue">
    <div class="container h-100 d-flex align-items-center justify-content-between gap-3">

        <!-- Brand -->
        <a href="<?= site_url('trade') ?>" class="brand-logo flex-shrink-0">
            <img src="<?= base_url('assets/images/logo_hcmue.png') ?>" class="brand-icon-img" alt="Logo HCMUE">
            <div class="brand-text">
                <div class="brand-main">HCMUE Pass Sách</div>
                <div class="brand-sub">Đại học Sư phạm TP.HCM</div>
            </div>
        </a>

        <!-- Right actions -->
        <div class="d-flex align-items-center gap-2">
            <?php if ($this->session->userdata('logged_in')): ?>
                <!-- Inbox -->
                <a href="<?= site_url('message/inbox') ?>" class="nav-icon-btn" title="Hộp thư">
                    <i class="fas fa-comment-dots"></i>
                    <?php if (isset($unread_count) && $unread_count > 0): ?>
                        <span class="nav-badge"><?= $unread_count ?></span>
                    <?php endif; ?>
                </a>
                <!-- Đăng bài -->
                <button class="btn-dang-bai" data-bs-toggle="modal" data-bs-target="#createPostModal">
                    <i class="fas fa-plus"></i> Đăng Sách
                </button>
                <!-- User Chip -->
                <div class="dropdown">
                    <a href="#" class="nav-user-chip" data-bs-toggle="dropdown">
                        <div class="nav-user-avatar">
                            <?= strtoupper(substr($this->session->userdata('full_name'), 0, 1)) ?>
                        </div>
                        <span style="font-size:0.82rem; font-weight:600;">
                            <?= $this->session->userdata('full_name') ?>
                        </span>
                        <i class="fas fa-chevron-down" style="font-size:0.65rem; opacity:0.7;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-2 shadow border-0 rounded-3">
                        <li>
                            <a class="dropdown-item py-2" href="<?= site_url('profile') ?>">
                                <i class="fas fa-user-circle me-2 text-primary"></i>Trang cá nhân
                            </a>
                        </li>
                        <?php if ($this->session->userdata('role') === 'admin'): ?>
                        <li>
                            <a class="dropdown-item py-2" href="<?= site_url('admin') ?>">
                                <i class="fas fa-cog me-2 text-warning"></i>Quản trị Admin
                            </a>
                        </li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <a class="dropdown-item py-2 text-danger" href="<?= site_url('auth/logout') ?>">
                                <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                            </a>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="<?= site_url('auth/register') ?>" class="btn-dang-bai text-decoration-none">
                    <i class="fas fa-user-plus"></i> Đăng ký
                </a>
                <a href="<?= site_url('auth') ?>" class="nav-icon-btn" title="Đăng nhập">
                    <i class="fas fa-sign-in-alt"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Modal Đăng Bài -->
<?php if ($this->session->userdata('logged_in')): ?>
<div class="modal fade modal-hcmue" id="createPostModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-book-medical me-2"></i>Đăng Sách / Tài Liệu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('trade/create') ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label-hcmue">Tên sách / Tài liệu *</label>
                        <input type="text" class="form-control form-control-hcmue" name="title" required
                               placeholder="VD: Giáo trình C++ - Lập trình Hướng đối tượng...">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label-hcmue">Danh mục môn học *</label>
                            <select class="form-select form-control-hcmue" name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>
                                <?php if (isset($categories)): foreach($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-hcmue">Giá Pass (VNĐ) *</label>
                            <div class="input-group">
                                <input type="number" class="form-control form-control-hcmue" name="price"
                                       required placeholder="VD: 50000" min="0">
                                <span class="input-group-text fw-bold text-muted" style="border-radius:0 10px 10px 0; font-size:0.85rem;">đ</span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-hcmue">Mô tả tình trạng sách</label>
                        <textarea class="form-control form-control-hcmue" name="description" rows="3"
                                  placeholder="Sách còn bao nhiêu %, có ghi chú không, tặng kèm gì..."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label-hcmue">Hình ảnh thực tế <small class="fw-normal text-muted">(tỉ lệ 4:3 đẹp nhất)</small></label>
                        <input type="file" class="form-control form-control-hcmue" name="image" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary-hcmue w-100 py-3 fs-6 fw-bold">
                        <i class="fas fa-paper-plane me-2"></i>Gửi Bài Đăng
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
