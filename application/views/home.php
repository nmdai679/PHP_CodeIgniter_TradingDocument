<!-- Search & Filter Bar -->
<div class="search-section">
    <div class="container">
        <form action="<?= site_url('trade') ?>" method="GET" class="d-flex gap-3 align-items-center flex-wrap">
            <div class="search-input-wrap flex-grow-1" style="min-width:200px;max-width:400px;">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="q" value="<?= htmlspecialchars($keyword ?? '') ?>"
                       placeholder="Tìm sách, giáo trình...">
            </div>
            <div class="filter-scroll flex-grow-1">
                <a href="<?= site_url('trade') ?>"
                   class="cat-filter-btn <?= (!$active_cat) ? 'active' : '' ?>">
                    <i class="fas fa-th-large me-1"></i> Tất cả
                </a>
                <?php foreach($categories as $cat): ?>
                    <a href="<?= site_url('trade?cat=' . $cat['id']) ?>"
                       class="cat-filter-btn <?= ($active_cat == $cat['id']) ? 'active' : '' ?>">
                        <i class="<?= $cat['icon'] ?> me-1"></i> <?= $cat['category_name'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <?php if($keyword || $active_cat): ?>
                <a href="<?= site_url('trade') ?>" class="text-muted text-decoration-none" style="font-size:0.82rem;white-space:nowrap;">
                    <i class="fas fa-times me-1"></i>Xóa lọc
                </a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Main Content -->
<div class="container py-4">

    <!-- Flash Messages -->
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-hcmue alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-hcmue alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Section Title -->
    <div class="d-flex align-items-center mb-4">
        <h2 class="section-title flex-grow-1">
            <i class="fas fa-book-open" style="font-size:1.1rem;"></i>
            <?php if($keyword): ?>
                Kết quả cho "<em><?= htmlspecialchars($keyword) ?></em>"
            <?php elseif($active_cat): ?>
                <?php $cur_cat = array_filter($categories, fn($c) => $c['id'] == $active_cat);
                      $cur_cat = reset($cur_cat); ?>
                <?= $cur_cat ? $cur_cat['category_name'] : 'Danh mục' ?>
            <?php else: ?>
                Sách đang được Pass
            <?php endif; ?>
        </h2>
        <span class="ms-3 text-muted" style="font-size:0.83rem;white-space:nowrap;">
            <?= count($posts) ?> bài đăng
        </span>
    </div>

    <!-- Cards Grid -->
    <?php if (empty($posts)): ?>
        <div class="text-center py-5">
            <i class="fas fa-box-open" style="font-size:3rem;color:#CBD5E1;"></i>
            <p class="mt-3 text-muted" style="font-size:0.95rem;">
                Không có bài đăng nào phù hợp.<br>
                <?php if($this->session->userdata('logged_in')): ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#createPostModal" class="link-hcmue">
                        Đăng sách của bạn ngay!
                    </a>
                <?php else: ?>
                    <a href="<?= site_url('auth') ?>" class="link-hcmue">Đăng nhập để đăng bài</a>
                <?php endif; ?>
            </p>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach($posts as $post): ?>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card-post d-flex flex-column <?= $post['status'] === 'sold' ? 'card-sold' : '' ?>">

                    <!-- Image -->
                    <a href="<?= site_url('trade/detail/' . $post['id']) ?>" class="d-block overflow-hidden" style="border-radius:16px 16px 0 0;">
                        <img src="<?= base_url($post['image_url']) ?>"
                             class="post-img"
                             alt="<?= htmlspecialchars($post['title']) ?>"
                             onerror="this.src='https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=400&q=80';">
                    </a>

                    <!-- Body -->
                    <div class="p-3 d-flex flex-column flex-grow-1">
                        <!-- Category + Status -->
                        <div class="d-flex align-items-center justify-content-between mb-2 gap-1 flex-wrap">
                            <span class="badge-cat">
                                <i class="<?= $post['cat_icon'] ?? 'fas fa-book' ?>"></i>
                                <?= $post['category_name'] ?>
                            </span>
                            <?php if ($post['status'] === 'available'): ?>
                                <span class="status-badge-avail"><i class="fas fa-circle" style="font-size:6px;"></i> Còn sách</span>
                            <?php else: ?>
                                <span class="status-badge-sold"><i class="fas fa-lock" style="font-size:10px;"></i> Đã Pass</span>
                            <?php endif; ?>
                        </div>

                        <!-- Title -->
                        <a href="<?= site_url('trade/detail/' . $post['id']) ?>"
                           class="text-decoration-none text-dark fw-bold mb-1"
                           style="font-size:0.92rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;line-height:1.4;">
                            <?= htmlspecialchars($post['title']) ?>
                        </a>

                        <!-- Seller + Rating -->
                        <div class="d-flex align-items-center gap-1 mb-2" style="font-size:0.78rem;color:#6B7280;">
                            <i class="fas fa-user-circle" style="color:#003F8A;"></i>
                            <span><?= htmlspecialchars($post['full_name'] ?: $post['username']) ?></span>
                            <span class="mx-1">·</span>
                            <?php if ($post['avg_rating'] > 0): ?>
                                <span class="star-display">
                                    <?php for($s=1;$s<=5;$s++): ?>
                                        <i class="<?= $s <= round($post['avg_rating']) ? 'fas' : 'far' ?> fa-star"></i>
                                    <?php endfor; ?>
                                    <span style="color:#6B7280;">(<?= $post['total_ratings'] ?>)</span>
                                </span>
                            <?php else: ?>
                                <span class="star-display"><span class="no-rating">Chưa có đánh giá</span></span>
                            <?php endif; ?>
                        </div>

                        <!-- Description snippet -->
                        <p class="text-muted mb-2 flex-grow-1"
                           style="font-size:0.8rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;line-height:1.5;">
                            <?= htmlspecialchars($post['description'] ?: 'Không có mô tả') ?>
                        </p>

                        <hr class="my-2" style="border-color:#F1F5F9;">

                        <!-- Price + Actions -->
                        <div class="d-flex align-items-center justify-content-between gap-1 flex-wrap">
                            <span class="price-tag"><?= number_format($post['price'], 0, ',', '.') ?>đ</span>
                            <div class="d-flex gap-1">
                                <!-- SĐT nếu được bật -->
                                <?php if ($post['phone_visible'] && $post['phone']): ?>
                                    <a href="tel:<?= $post['phone'] ?>"
                                       class="btn btn-sm btn-outline-success rounded-3 fw-bold"
                                       style="font-size:0.75rem;" title="Gọi điện">
                                        <i class="fas fa-phone"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if ($this->session->userdata('logged_in')): ?>
                                    <?php $cur_uid = $this->session->userdata('user_id'); ?>
                                    <?php if ($post['user_id'] != $cur_uid): ?>
                                        <!-- Nhắn tin -->
                                        <a href="<?= site_url('message/conversation/' . $post['user_id']) ?>"
                                           class="btn btn-sm btn-primary-hcmue rounded-3"
                                           style="font-size:0.75rem;" title="Nhắn tin">
                                            <i class="fas fa-comment"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($post['user_id'] == $cur_uid || $this->session->userdata('role') === 'admin'): ?>
                                        <?php if ($post['status'] === 'available'): ?>
                                            <a href="<?= site_url('trade/update_status/' . $post['id']) ?>"
                                               class="btn btn-sm btn-outline-success rounded-3 fw-bold"
                                               style="font-size:0.75rem;" title="Đánh dấu Đã Pass"
                                               onclick="return confirm('Đánh dấu sách này là Đã Pass?');">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= site_url('trade/delete/' . $post['id']) ?>"
                                           class="btn btn-sm btn-outline-danger rounded-3"
                                           style="font-size:0.75rem;" title="Xóa"
                                           onclick="return confirm('Bạn có chắc muốn xóa bài này?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Meta: time + comments -->
                        <div class="d-flex gap-3 mt-2" style="font-size:0.74rem;color:#9CA3AF;">
                            <span><i class="far fa-clock me-1"></i><?= date('d/m/Y', strtotime($post['created_at'])) ?></span>
                            <span><i class="far fa-comment me-1"></i><?= $post['comment_count'] ?> bình luận</span>
                        </div>
                    </div>

                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<style>
.link-hcmue { color:#0052B4;font-weight:600;text-decoration:none; }
.link-hcmue:hover { text-decoration:underline; }
</style>
