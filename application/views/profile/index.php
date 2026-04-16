<?php $cur_uid = $this->session->userdata('user_id'); ?>

<div class="container py-4" style="max-width:900px;">

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-hcmue alert-dismissible fade show mb-3">
            <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- === Profile Header === -->
    <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-4">
        <div style="height:90px;background:linear-gradient(135deg,var(--hcmue-blue),var(--hcmue-blue-light));"></div>
        <div class="px-4 pb-4">
            <div class="d-flex align-items-end gap-4" style="margin-top:-40px;">
                <div style="width:78px;height:78px;background:var(--hcmue-gold);border-radius:50%;border:4px solid #fff;display:flex;align-items:center;justify-content:center;font-size:2rem;color:var(--hcmue-blue);font-weight:800;flex-shrink:0;">
                    <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                </div>
                <div class="pb-1 flex-grow-1">
                    <h2 style="font-size:1.2rem;font-weight:800;color:#1A1A2E;margin:0;">
                        <?= htmlspecialchars($user['full_name']) ?>
                    </h2>
                    <span class="text-muted" style="font-size:0.82rem;">@<?= $user['username'] ?></span>
                    <?php if ($user['role'] === 'admin'): ?>
                        <span class="ms-2" style="background:var(--hcmue-gold);color:var(--hcmue-blue);font-size:0.72rem;font-weight:700;padding:2px 10px;border-radius:20px;">ADMIN</span>
                    <?php endif; ?>
                </div>
                <div class="text-center pb-1">
                    <div class="fw-bold" style="font-size:1.2rem;color:var(--hcmue-blue);"><?= $avg_rating['avg'] ?: '—' ?></div>
                    <div class="star-display" style="font-size:0.85rem;">
                        <?php if ($avg_rating['avg'] > 0): ?>
                            <?php for($s=1;$s<=5;$s++): ?>
                                <i class="<?= $s<=round($avg_rating['avg'])?'fas':'far' ?> fa-star"></i>
                            <?php endfor; ?>
                        <?php else: ?>
                            <span class="text-muted" style="font-size:0.78rem;">Chưa có đánh giá</span>
                        <?php endif; ?>
                    </div>
                    <div class="text-muted" style="font-size:0.72rem;"><?= $avg_rating['total'] ?> đánh giá</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- === Cài đặt SĐT === -->
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm p-4 h-100">
                <h6 class="fw-bold mb-3" style="color:var(--hcmue-blue);">
                    <i class="fas fa-phone me-2"></i>Số điện thoại
                </h6>
                <p class="text-muted mb-3" style="font-size:0.82rem;">
                    Cho phép người mua xem số SĐT của bạn trực tiếp trên bài đăng.
                </p>

                <!-- Cập nhật SĐT -->
                <form action="<?= site_url('profile/update_phone') ?>" method="POST" class="mb-3">
                    <div class="input-group input-group-sm">
                        <input type="tel" class="form-control" name="phone"
                               value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
                               placeholder="0912345678"
                               style="border-radius:8px 0 0 8px;border:1.5px solid #E5E9F2;">
                        <button type="submit" class="btn btn-primary-hcmue px-3" style="border-radius:0 8px 8px 0;font-size:0.8rem;">
                            Lưu
                        </button>
                    </div>
                </form>

                <!-- Toggle ẩn/hiện -->
                <a href="<?= site_url('profile/toggle_phone') ?>"
                   class="btn w-100 py-2 fw-bold"
                   style="font-size:0.85rem;border-radius:10px;
                          background:<?= $user['phone_visible'] ? '#D1FAE5' : '#F3F4F6' ?>;
                          color:<?= $user['phone_visible'] ? '#065F46' : '#6B7280' ?>;border:none;">
                    <i class="fas fa-<?= $user['phone_visible'] ? 'eye' : 'eye-slash' ?> me-2"></i>
                    <?= $user['phone_visible'] ? 'Đang hiển thị — Click để Ẩn' : 'Đang ẩn — Click để Hiện' ?>
                </a>
            </div>
        </div>

        <!-- === Đánh giá nhận được === -->
        <div class="col-md-8">
            <div class="card border-0 rounded-4 shadow-sm p-4 h-100">
                <h6 class="fw-bold mb-3" style="color:var(--hcmue-blue);">
                    <i class="fas fa-star me-2" style="color:var(--hcmue-gold);"></i>Đánh giá từ người mua
                </h6>
                <?php if (empty($my_ratings)): ?>
                    <p class="text-muted mb-0" style="font-size:0.85rem;">Bạn chưa nhận được đánh giá nào.</p>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3" style="max-height:220px;overflow-y:auto;">
                        <?php foreach($my_ratings as $r): ?>
                            <div class="d-flex gap-3">
                                <div style="width:34px;height:34px;background:#E8F0FD;border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--hcmue-blue);font-weight:700;font-size:0.8rem;flex-shrink:0;">
                                    <?= strtoupper(substr($r['full_name'] ?: $r['username'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span style="font-size:0.82rem;font-weight:600;"><?= htmlspecialchars($r['full_name'] ?: $r['username']) ?></span>
                                        <span class="star-display" style="font-size:0.78rem;">
                                            <?php for($s=1;$s<=5;$s++): ?>
                                                <i class="<?= $s<=$r['stars']?'fas':'far' ?> fa-star"></i>
                                            <?php endfor; ?>
                                        </span>
                                    </div>
                                    <?php if ($r['comment']): ?>
                                        <p style="font-size:0.82rem;color:#4B5563;margin:0;"><?= htmlspecialchars($r['comment']) ?></p>
                                    <?php endif; ?>
                                    <div class="text-muted" style="font-size:0.72rem;">
                                        Về: <?= htmlspecialchars($r['post_title']) ?> · <?= date('d/m/Y', strtotime($r['created_at'])) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- === Bài đăng của tôi === -->
        <div class="col-12">
            <div class="card border-0 rounded-4 shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0" style="color:var(--hcmue-blue);">
                        <i class="fas fa-clipboard-list me-2"></i>Bài đăng của tôi (<?= count($my_posts) ?>)
                    </h6>
                    <button class="btn-dang-bai" data-bs-toggle="modal" data-bs-target="#createPostModal" style="font-size:0.8rem;padding:6px 14px;">
                        <i class="fas fa-plus"></i> Đăng mới
                    </button>
                </div>
                <?php if (empty($my_posts)): ?>
                    <p class="text-muted mb-0" style="font-size:0.85rem;">Bạn chưa đăng bài nào.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size:0.85rem;">
                            <thead style="background:#F8FAFC;">
                                <tr class="text-muted" style="font-size:0.78rem;">
                                    <th>Tên sách</th>
                                    <th>Danh mục</th>
                                    <th>Giá</th>
                                    <th>Trạng thái</th>
                                    <th>Bình luận</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($my_posts as $p): ?>
                                <tr>
                                    <td>
                                        <a href="<?= site_url('trade/detail/'.$p['id']) ?>"
                                           class="text-decoration-none fw-bold text-dark"
                                           style="font-size:0.85rem;">
                                            <?= htmlspecialchars(mb_strimwidth($p['title'], 0, 50, '...')) ?>
                                        </a>
                                    </td>
                                    <td class="text-muted"><?= $p['category_name'] ?></td>
                                    <td class="text-danger fw-bold"><?= number_format($p['price'],0,',','.') ?>đ</td>
                                    <td>
                                        <?php if ($p['status']==='available'): ?>
                                            <span class="status-badge-avail">Còn sách</span>
                                        <?php elseif ($p['status']==='sold'): ?>
                                            <span class="status-badge-sold">Đã Pass</span>
                                        <?php else: ?>
                                            <span class="status-badge-pending">
                                                <i class="fas fa-hourglass-half" style="font-size:0.65rem;"></i>
                                                Chờ duyệt
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-muted"><i class="far fa-comment me-1"></i><?= $p['comment_count'] ?></td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <?php if ($p['status']==='available'): ?>
                                                <a href="<?= site_url('trade/update_status/'.$p['id']) ?>"
                                                   class="btn btn-sm btn-outline-success rounded-2"
                                                   onclick="return confirm('Đánh dấu Đã Pass?');"
                                                   title="Đã Pass" style="font-size:0.75rem;padding:3px 8px;">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            <?php endif; ?>
                                            <a href="<?= site_url('trade/delete/'.$p['id']) ?>"
                                               class="btn btn-sm btn-outline-danger rounded-2"
                                               onclick="return confirm('Xóa bài này?');"
                                               title="Xóa" style="font-size:0.75rem;padding:3px 8px;">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
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

</div>

<style>
.btn-dang-bai { background:var(--hcmue-gold);color:var(--hcmue-blue);border:none;border-radius:50px;padding:8px 18px;font-weight:700;font-size:0.88rem;display:inline-flex;align-items:center;gap:6px;transition:all 0.25s;cursor:pointer; }
.btn-dang-bai:hover { background:var(--hcmue-gold-dark); }
</style>
