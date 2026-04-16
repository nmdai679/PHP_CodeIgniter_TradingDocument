<div class="container py-4" style="max-width:780px;">
    <h2 class="section-title mb-4"><i class="fas fa-inbox"></i> Hộp thư</h2>

    <?php if (empty($conversations)): ?>
        <div class="card border-0 rounded-4 shadow-sm p-5 text-center">
            <i class="fas fa-comment-slash" style="font-size:2.5rem;color:#CBD5E1;"></i>
            <p class="mt-3 text-muted mb-0">Bạn chưa có hội thoại nào.</p>
            <a href="<?= site_url('trade') ?>" class="btn btn-primary-hcmue mt-3 px-4 d-inline-block" style="font-size:0.88rem;">
                <i class="fas fa-search me-1"></i> Tìm sách để nhắn tin
            </a>
        </div>
    <?php else: ?>
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden">
            <?php foreach($conversations as $i => $conv): ?>
                <a href="<?= site_url('message/conversation/' . $conv['id']) ?>"
                   class="d-flex align-items-center gap-3 p-3 text-decoration-none text-dark conv-item
                          <?= $conv['unread_count'] > 0 ? 'unread' : '' ?>"
                   style="<?= $i > 0 ? 'border-top:1px solid #F1F5F9;' : '' ?>">

                    <!-- Avatar -->
                    <div style="width:48px;height:48px;background:var(--hcmue-blue);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#F5A623;font-weight:800;font-size:1.1rem;flex-shrink:0;">
                        <?= strtoupper(substr($conv['full_name'] ?: $conv['username'], 0, 1)) ?>
                    </div>

                    <!-- Content -->
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold" style="font-size:0.9rem;">
                                <?= htmlspecialchars($conv['full_name'] ?: $conv['username']) ?>
                            </span>
                            <span class="text-muted" style="font-size:0.72rem;white-space:nowrap;">
                                <?= date('d/m H:i', strtotime($conv['created_at'])) ?>
                            </span>
                        </div>
                        <?php if ($conv['post_title']): ?>
                            <div style="font-size:0.73rem;color:var(--hcmue-blue);margin-bottom:2px;">
                                <i class="fas fa-book me-1"></i><?= htmlspecialchars($conv['post_title']) ?>
                            </div>
                        <?php endif; ?>
                        <div class="text-muted text-truncate" style="font-size:0.8rem;">
                            <?= ($conv['sender_id'] == $this->session->userdata('user_id') ? 'Bạn: ' : '') . htmlspecialchars($conv['content']) ?>
                        </div>
                    </div>

                    <!-- Unread badge -->
                    <?php if ($conv['unread_count'] > 0): ?>
                        <span class="ms-2 flex-shrink-0" style="background:var(--hcmue-blue);color:#fff;border-radius:50%;width:22px;height:22px;display:flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:700;">
                            <?= $conv['unread_count'] ?>
                        </span>
                    <?php else: ?>
                        <i class="fas fa-chevron-right text-muted ms-2 flex-shrink-0" style="font-size:0.7rem;"></i>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.conv-item { transition: background 0.15s; }
.conv-item:hover { background: #F8FAFC; }
.conv-item.unread { background: #EEF5FF; }
.conv-item.unread:hover { background: #E3EEFF; }
</style>
