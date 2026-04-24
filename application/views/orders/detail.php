<?php
$status_labels = [
    'pending'   => ['label' => 'Chờ xác nhận',   'color' => '#92400E', 'bg' => '#FEF3C7', 'icon' => 'fa-hourglass-half'],
    'confirmed' => ['label' => 'Đã xác nhận',     'color' => '#1E40AF', 'bg' => '#DBEAFE', 'icon' => 'fa-handshake'],
    'completed' => ['label' => 'Hoàn thành',       'color' => '#065F46', 'bg' => '#D1FAE5', 'icon' => 'fa-check-circle'],
    'disputed'  => ['label' => 'Tranh chấp',       'color' => '#991B1B', 'bg' => '#FEE2E2', 'icon' => 'fa-exclamation-triangle'],
    'rejected'  => ['label' => 'Đã từ chối',       'color' => '#6B7280', 'bg' => '#F3F4F6', 'icon' => 'fa-times-circle'],
    'cancelled' => ['label' => 'Đã hủy',           'color' => '#9CA3AF', 'bg' => '#F3F4F6', 'icon' => 'fa-ban'],
];
$sl       = $status_labels[$order['status']] ?? $status_labels['cancelled'];
$user_id  = $this->session->userdata('user_id');
$timeline = [
    'pending'   => 1,
    'confirmed' => 2,
    'completed' => 3,
    'disputed'  => 3,
    'rejected'  => 2,
    'cancelled' => 2,
];
$cur_step = $timeline[$order['status']] ?? 1;
?>
<div class="container py-4" style="max-width:760px;">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="font-size:0.82rem;">
            <li class="breadcrumb-item"><a href="<?= site_url('orders') ?>" class="text-decoration-none" style="color:var(--hcmue-blue);">Đơn hàng</a></li>
            <li class="breadcrumb-item active text-muted">Chi tiết #<?= $order['id'] ?></li>
        </ol>
    </nav>

    <!-- Status Banner -->
    <div class="card border-0 rounded-4 shadow-sm mb-4 overflow-hidden">
        <div style="background:linear-gradient(135deg,var(--hcmue-blue),var(--hcmue-blue-light));padding:20px 24px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white fw-bold" style="font-size:1.1rem;">Đơn hàng #<?= $order['id'] ?></div>
                    <div class="text-white opacity-75" style="font-size:0.8rem;"><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></div>
                </div>
                <span style="background:<?= $sl['bg'] ?>;color:<?= $sl['color'] ?>;padding:6px 16px;border-radius:20px;font-size:0.82rem;font-weight:700;">
                    <i class="fas <?= $sl['icon'] ?> me-1"></i><?= $sl['label'] ?>
                </span>
            </div>
        </div>

        <!-- Timeline -->
        <div class="px-4 py-3" style="background:#F8FAFC;">
            <div class="d-flex align-items-center justify-content-between position-relative">
                <div style="position:absolute;top:14px;left:8%;right:8%;height:2px;background:#E5E7EB;z-index:0;"></div>
                <?php
                $steps = [
                    ['icon' => 'fa-shopping-cart', 'label' => 'Yêu cầu'],
                    ['icon' => 'fa-handshake',      'label' => 'Xác nhận'],
                    ['icon' => 'fa-box-open',        'label' => $order['status'] === 'completed' ? 'Hoàn thành' : ($order['status'] === 'disputed' ? 'Tranh chấp' : 'Nhận hàng')],
                ];
                foreach ($steps as $i => $step):
                    $done    = ($i + 1) <= $cur_step;
                    $current = ($i + 1) === $cur_step;
                ?>
                <div class="text-center" style="z-index:1;flex:1;">
                    <div class="mx-auto d-flex align-items-center justify-content-center rounded-circle"
                         style="width:30px;height:30px;
                                background:<?= $done ? 'var(--hcmue-blue)' : '#E5E7EB' ?>;
                                color:<?= $done ? '#fff' : '#9CA3AF' ?>;
                                font-size:0.75rem;
                                <?= $current ? 'box-shadow:0 0 0 4px rgba(0,63,138,0.2);' : '' ?>">
                        <i class="fas <?= $step['icon'] ?>"></i>
                    </div>
                    <div style="font-size:0.7rem;color:<?= $done ? 'var(--hcmue-blue)' : '#9CA3AF' ?>;font-weight:<?= $done ? '700' : '400' ?>;margin-top:4px;">
                        <?= $step['label'] ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Thông tin sách -->
    <div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
        <h6 class="fw-bold mb-3" style="color:var(--hcmue-blue);"><i class="fas fa-book me-2"></i>Thông tin sách</h6>
        <div class="d-flex gap-3">
            <?php
                $img_src = (!empty($order['image_url']) && file_exists(FCPATH . $order['image_url']))
                           ? base_url($order['image_url'])
                           : base_url('assets/images/default_book.jpg');
            ?>
            <img src="<?= $img_src ?>" style="width:80px;height:100px;object-fit:cover;border-radius:10px;flex-shrink:0;"
                 onerror="this.src='<?= base_url('assets/images/default_book.jpg') ?>';">
            <div>
                <div class="fw-bold mb-1"><?= htmlspecialchars($order['post_title']) ?></div>
                <div class="text-muted" style="font-size:0.85rem;">
                    Đơn giá: <strong class="text-danger"><?= number_format($order['price'], 0, ',', '.') ?>đ</strong>
                    &nbsp;·&nbsp; Số lượng: <strong><?= $order['quantity'] ?> cuốn</strong>
                </div>
                <div class="fw-bold mt-1" style="color:var(--hcmue-blue);font-size:0.95rem;">
                    Tổng: <?= number_format($order['price'] * $order['quantity'], 0, ',', '.') ?>đ
                </div>
                <?php if ($order['note']): ?>
                    <div class="mt-2 p-2 rounded-3" style="background:#F8FAFC;font-size:0.82rem;color:#6B7280;">
                        <i class="fas fa-sticky-note me-1"></i>Ghi chú: <?= htmlspecialchars($order['note']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Thông tin 2 bên -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 rounded-4 shadow-sm p-3 h-100">
                <div class="fw-bold mb-2" style="font-size:0.82rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;">Người bán</div>
                <div class="d-flex align-items-center gap-2">
                    <div style="width:38px;height:38px;background:var(--hcmue-blue);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--hcmue-gold);font-weight:800;flex-shrink:0;">
                        <?= strtoupper(substr($order['seller_name'], 0, 1)) ?>
                    </div>
                    <div>
                        <div class="fw-bold" style="font-size:0.9rem;"><?= htmlspecialchars($order['seller_name']) ?></div>
                        <div class="text-muted" style="font-size:0.78rem;">@<?= $order['seller_username'] ?></div>
                    </div>
                </div>
                <?php if ($is_buyer && $order['seller_phone']): ?>
                    <div class="mt-2" style="font-size:0.82rem;">
                        <i class="fas fa-phone me-1" style="color:var(--hcmue-blue);"></i>
                        <a href="tel:<?= $order['seller_phone'] ?>" style="color:var(--hcmue-blue);font-weight:600;"><?= $order['seller_phone'] ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 rounded-4 shadow-sm p-3 h-100">
                <div class="fw-bold mb-2" style="font-size:0.82rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;">Người mua</div>
                <div class="d-flex align-items-center gap-2">
                    <div style="width:38px;height:38px;background:var(--hcmue-gold);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--hcmue-blue);font-weight:800;flex-shrink:0;">
                        <?= strtoupper(substr($order['buyer_name'], 0, 1)) ?>
                    </div>
                    <div>
                        <div class="fw-bold" style="font-size:0.9rem;"><?= htmlspecialchars($order['buyer_name']) ?></div>
                        <div class="text-muted" style="font-size:0.78rem;">@<?= $order['buyer_username'] ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lý do từ chối/tranh chấp -->
    <?php if ($order['reject_reason'] && in_array($order['status'], ['rejected','disputed','cancelled'])): ?>
    <div class="alert border-0 rounded-4 mb-4" style="background:#FEE2E2;color:#991B1B;">
        <i class="fas fa-info-circle me-2"></i>
        <strong><?= $order['status'] === 'disputed' ? 'Lý do tranh chấp' : 'Lý do từ chối' ?>:</strong>
        <?= htmlspecialchars($order['reject_reason']) ?>
    </div>
    <?php endif; ?>

    <!-- Actions -->
    <div class="d-flex gap-2 flex-wrap">
        <a href="<?= site_url('orders') ?>" class="btn btn-outline-secondary rounded-3">
            <i class="fas fa-arrow-left me-1"></i>Quay lại
        </a>
        <?php if ($is_buyer): ?>
            <a href="<?= site_url('message/conversation/' . $order['seller_id']) ?>"
               class="btn btn-primary-hcmue rounded-3">
                <i class="fas fa-comment-dots me-1"></i>Nhắn tin người bán
            </a>
        <?php else: ?>
            <a href="<?= site_url('message/conversation/' . $order['buyer_id']) ?>"
               class="btn btn-primary-hcmue rounded-3">
                <i class="fas fa-comment-dots me-1"></i>Nhắn tin người mua
            </a>
        <?php endif; ?>
        <?php if ($order['status'] === 'completed' && $is_buyer): ?>
            <a href="<?= site_url('orders/rate/' . $order['id']) ?>"
               class="btn rounded-3 fw-bold" style="background:var(--hcmue-gold);color:var(--hcmue-blue);">
                <i class="fas fa-star me-1"></i>Đánh giá người bán
            </a>
        <?php endif; ?>
    </div>
</div>
