<div class="container py-4">

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-hcmue alert-dismissible fade show mb-4">
            <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="section-title flex-grow-1"><i class="fas fa-users"></i> Quản lý Người dùng</h2>
        <a href="<?= site_url('admin') ?>" class="btn btn-light rounded-3 px-3" style="font-size:0.85rem;">
            <i class="fas fa-arrow-left me-1"></i> Về Dashboard
        </a>
    </div>

    <div class="card border-0 rounded-4 shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size:0.85rem;">
                <thead style="background:#F8FAFC;">
                    <tr class="text-muted" style="font-size:0.77rem;">
                        <th style="padding:12px 16px;">ID</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Trạng thái SĐT</th>
                        <th>Quyền</th>
                        <th>Ngày tạo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $u): ?>
                    <tr>
                        <td style="padding:10px 16px;color:#9CA3AF;">#<?= $u['id'] ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:32px;height:32px;background:var(--hcmue-blue);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#F5A623;font-weight:700;font-size:0.8rem;flex-shrink:0;">
                                    <?= strtoupper(substr($u['full_name'], 0, 1)) ?>
                                </div>
                                <span class="fw-semibold"><?= htmlspecialchars($u['full_name']) ?></span>
                            </div>
                        </td>
                        <td class="text-muted"><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= $u['phone'] ?: '<span class="text-muted">—</span>' ?></td>
                        <td>
                            <?php if ($u['phone_visible']): ?>
                                <span class="status-badge-avail"><i class="fas fa-eye" style="font-size:0.65rem;"></i> Hiển thị</span>
                            <?php else: ?>
                                <span class="status-badge-sold"><i class="fas fa-eye-slash" style="font-size:0.65rem;"></i> Ẩn</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($u['role'] === 'admin'): ?>
                                <span style="background:#FEF3C7;color:#D97706;font-size:0.75rem;font-weight:700;padding:2px 10px;border-radius:20px;">Admin</span>
                            <?php else: ?>
                                <span style="background:#E8F0FD;color:var(--hcmue-blue);font-size:0.75rem;font-weight:600;padding:2px 10px;border-radius:20px;">User</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-muted" style="font-size:0.77rem;"><?= date('d/m/Y', strtotime($u['created_at'])) ?></td>
                        <td>
                            <?php if ($u['id'] != $this->session->userdata('user_id')): ?>
                            <a href="<?= site_url('admin/toggle_role/'.$u['id']) ?>"
                               class="btn btn-sm btn-outline-hcmue rounded-2"
                               onclick="return confirm('Thay đổi quyền người dùng này?');"
                               style="font-size:0.75rem;padding:4px 10px;">
                                <i class="fas fa-exchange-alt me-1"></i>
                                <?= $u['role']==='admin' ? 'Hạ User' : 'Nâng Admin' ?>
                            </a>
                            <?php else: ?>
                                <span class="text-muted" style="font-size:0.77rem;">(Bạn)</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
