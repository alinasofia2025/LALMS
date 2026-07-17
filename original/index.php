<?php $this->assign('title', $title); ?>

<style>
/* ============================================================
   TEMA TEAL GREEN + GLASS EFFECT + DARK MODE SUPPORT
   (Same as Lecturer module for visual consistency)
   ============================================================ */

:root {
    --teal-primary: #00897b;
    --teal-light: #26a69a;
    --teal-lighter: #4dd0e1;
    --teal-dark: #00695c;
    --teal-gradient: linear-gradient(135deg, #00897b, #26a69a);
    --teal-gradient-hover: linear-gradient(135deg, #00695c, #00897b);
    
    /* Light mode defaults */
    --bg-body: #f0f7f6;
    --card-bg: rgba(255, 255, 255, 0.75);
    --card-border: rgba(0, 137, 123, 0.12);
    --card-shadow: 0 8px 32px rgba(0, 137, 123, 0.08);
    --text-primary: #1a2a3a;
    --text-muted: #4a6a6a;
    --table-header-bg: #e8f3f0;
    --table-header-color: #00695c;
    --table-row-hover: rgba(0, 137, 123, 0.05);
    --table-border: rgba(0, 137, 123, 0.06);
    --stat-bg: rgba(255, 255, 255, 0.7);
    --stat-shadow: 0 4px 15px rgba(0, 137, 123, 0.06);
    --search-bg: rgba(255, 255, 255, 0.8);
    --pagination-bg: rgba(255, 255, 255, 0.6);
    --glass-blur: blur(12px);
    --btn-text: #fff;
}

/* Dark mode */
[data-bs-theme="dark"] {
    --bg-body: #0a1a1e;
    --card-bg: rgba(10, 30, 34, 0.75);
    --card-border: rgba(77, 208, 225, 0.15);
    --card-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
    --text-primary: #e0f7fa;
    --text-muted: #a0c4c8;
    --table-header-bg: rgba(0, 60, 55, 0.7);
    --table-header-color: #b2dfdb;
    --table-row-hover: rgba(77, 208, 225, 0.06);
    --table-border: rgba(77, 208, 225, 0.08);
    --stat-bg: rgba(0, 0, 0, 0.4);
    --stat-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    --search-bg: rgba(0, 0, 0, 0.3);
    --pagination-bg: rgba(0, 0, 0, 0.3);
    --btn-text: #0a1a1e;
}

body {
    background-color: var(--bg-body);
    transition: background 0.4s ease;
}

/* ===== PAGE HEADER ===== */
.page-header h1 {
    color: var(--teal-primary);
    font-weight: 700;
    transition: color 0.3s;
}
[data-bs-theme="dark"] .page-header h1 {
    color: var(--teal-lighter);
}
.page-header .text-muted {
    color: var(--text-muted) !important;
}

/* ===== STAT CARDS (GLASS) ===== */
.stat-card-teal {
    background: var(--stat-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border-radius: 16px;
    padding: 20px 25px;
    box-shadow: var(--stat-shadow);
    border-left: 5px solid var(--teal-primary);
    border: 1px solid var(--card-border);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}
.stat-card-teal:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 137, 123, 0.15);
}
[data-bs-theme="dark"] .stat-card-teal:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
}
.stat-card-teal .stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--teal-primary);
    margin: 0;
}
[data-bs-theme="dark"] .stat-card-teal .stat-number {
    color: var(--teal-lighter);
}
.stat-card-teal .stat-label {
    color: var(--text-muted);
    font-weight: 500;
    margin: 5px 0 0;
    font-size: 0.9rem;
}
.stat-card-teal .stat-icon {
    position: absolute;
    right: 20px;
    top: 20px;
    font-size: 2.5rem;
    opacity: 0.12;
    color: var(--teal-primary);
}
[data-bs-theme="dark"] .stat-card-teal .stat-icon {
    opacity: 0.15;
}

/* ===== TABLE CARD (GLASS) ===== */
.table-card-wrapper {
    background: var(--card-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--card-shadow);
    border: 1px solid var(--card-border);
    transition: all 0.3s ease;
}
.table-card-wrapper:hover {
    box-shadow: 0 8px 35px rgba(0, 137, 123, 0.12);
}
[data-bs-theme="dark"] .table-card-wrapper:hover {
    box-shadow: 0 8px 35px rgba(0, 0, 0, 0.5);
}

/* Header table dengan gradient teal */
.table-card-wrapper .table-header {
    background: var(--teal-gradient);
    padding: 16px 20px;
    color: #fff;
    font-weight: 600;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.table-card-wrapper .table-header i {
    margin-right: 10px;
}
.table-card-wrapper .table-header .badge-teal-count {
    background: rgba(255,255,255,0.2);
    color: #fff;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
}

/* ===== TABLE STYLE ===== */
.table-teal {
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
    color: var(--text-primary);
}
.table-teal thead th {
    background: var(--table-header-bg);
    color: var(--table-header-color);
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 16px;
    border-bottom: 2px solid var(--teal-primary);
    backdrop-filter: blur(4px);
}
[data-bs-theme="dark"] .table-teal thead th {
    border-bottom-color: var(--teal-lighter);
}
.table-teal tbody tr {
    transition: all 0.2s ease;
    border-left: 3px solid transparent;
}
.table-teal tbody tr:hover {
    background: var(--table-row-hover);
    border-left-color: var(--teal-primary);
    transform: scale(1.003);
    box-shadow: 0 2px 10px rgba(0, 137, 123, 0.06);
}
[data-bs-theme="dark"] .table-teal tbody tr:hover {
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}
.table-teal tbody td {
    padding: 12px 16px;
    vertical-align: middle;
    border-bottom: 1px solid var(--table-border);
    color: var(--text-primary);
}
.table-teal tbody tr:last-child td {
    border-bottom: none;
}
.table-teal tbody td a {
    color: var(--teal-primary);
    text-decoration: none;
}
[data-bs-theme="dark"] .table-teal tbody td a {
    color: var(--teal-lighter);
}
.table-teal tbody td a:hover {
    text-decoration: underline;
}

/* ===== BUTANG CANTIK ===== */
.btn-action {
    border-radius: 8px;
    padding: 5px 12px;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.btn-action i {
    font-size: 0.9rem;
}
.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-view {
    background: rgba(0, 137, 123, 0.1);
    color: var(--teal-primary);
    border: 1px solid rgba(0, 137, 123, 0.2);
}
.btn-view:hover {
    background: var(--teal-primary);
    color: #fff;
    box-shadow: 0 4px 12px rgba(0, 137, 123, 0.3);
}
[data-bs-theme="dark"] .btn-view {
    background: rgba(77, 208, 225, 0.15);
    color: var(--teal-lighter);
    border-color: rgba(77, 208, 225, 0.2);
}
[data-bs-theme="dark"] .btn-view:hover {
    background: var(--teal-lighter);
    color: #0a1a1e;
}

.btn-edit {
    background: rgba(255, 179, 0, 0.1);
    color: #f9a825;
    border: 1px solid rgba(255, 179, 0, 0.2);
}
.btn-edit:hover {
    background: #f9a825;
    color: #fff;
    box-shadow: 0 4px 12px rgba(255, 179, 0, 0.3);
}
[data-bs-theme="dark"] .btn-edit {
    background: rgba(255, 179, 0, 0.15);
    color: #f9a825;
}
[data-bs-theme="dark"] .btn-edit:hover {
    color: #0a1a1e;
}

.btn-delete {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    border: 1px solid rgba(220, 53, 69, 0.2);
}
.btn-delete:hover {
    background: #dc3545;
    color: #fff;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
}
[data-bs-theme="dark"] .btn-delete {
    background: rgba(220, 53, 69, 0.15);
}
[data-bs-theme="dark"] .btn-delete:hover {
    color: #0a1a1e;
}

/* ===== BUTANG UTAMA ===== */
.btn-teal {
    background: var(--teal-gradient);
    border: none;
    color: var(--btn-text);
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-teal:hover {
    background: var(--teal-gradient-hover);
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 137, 123, 0.35);
    color: var(--btn-text);
}
[data-bs-theme="dark"] .btn-teal:hover {
    box-shadow: 0 8px 20px rgba(0, 200, 200, 0.2);
}

.btn-search {
    background: var(--teal-gradient);
    border: none;
    color: var(--btn-text);
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-search:hover {
    background: var(--teal-gradient-hover);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 137, 123, 0.3);
    color: var(--btn-text);
}
[data-bs-theme="dark"] .btn-search:hover {
    box-shadow: 0 4px 15px rgba(0, 200, 200, 0.2);
}
/* Reset button with outline teal */
.btn-search-reset {
    background: transparent;
    border: 1px solid var(--teal-primary);
    color: var(--teal-primary);
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-search-reset:hover {
    background: var(--teal-primary);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 137, 123, 0.2);
}
[data-bs-theme="dark"] .btn-search-reset {
    border-color: var(--teal-lighter);
    color: var(--teal-lighter);
}
[data-bs-theme="dark"] .btn-search-reset:hover {
    background: var(--teal-lighter);
    color: #0a1a1e;
}

/* ===== SEARCH BOX ===== */
.search-box-teal {
    border-radius: 12px;
    border: 1px solid var(--card-border);
    background: var(--search-bg);
    backdrop-filter: blur(4px);
    transition: 0.3s;
    padding: 10px 16px;
    color: var(--text-primary);
}
.search-box-teal:focus {
    border-color: var(--teal-primary);
    box-shadow: 0 0 0 3px rgba(0, 137, 123, 0.1);
    background: var(--search-bg);
}
[data-bs-theme="dark"] .search-box-teal:focus {
    box-shadow: 0 0 0 3px rgba(77, 208, 225, 0.15);
}

/* ===== PAGINATION ===== */
.pagination {
    background: var(--pagination-bg);
    backdrop-filter: blur(4px);
    padding: 4px 8px;
    border-radius: 30px;
}
.pagination .page-item.active .page-link {
    background: var(--teal-primary);
    border-color: var(--teal-primary);
    color: #fff;
}
[data-bs-theme="dark"] .pagination .page-item.active .page-link {
    background: var(--teal-lighter);
    border-color: var(--teal-lighter);
    color: #0a1a1e;
}
.pagination .page-link {
    color: var(--teal-primary);
    background: transparent;
    border: none;
    margin: 0 2px;
    border-radius: 20px;
}
.pagination .page-link:hover {
    background: rgba(0, 137, 123, 0.1);
    color: var(--teal-dark);
}
[data-bs-theme="dark"] .pagination .page-link {
    color: var(--teal-lighter);
}
[data-bs-theme="dark"] .pagination .page-link:hover {
    background: rgba(77, 208, 225, 0.1);
    color: #fff;
}
.pagination .page-item.disabled .page-link {
    color: var(--text-muted);
}

/* ===== RESPONSIF ===== */
@media (max-width: 768px) {
    .stat-card-teal .stat-number {
        font-size: 1.5rem;
    }
    .table-card-wrapper .table-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    .btn-action {
        font-size: 0.7rem;
        padding: 4px 8px;
    }
}
</style>

<!-- ===== HEADER ===== -->
<div class="d-flex justify-content-between align-items-center mb-3 page-header">
    <div>
        <h1 class="h3 mb-0"><?= h($title) ?></h1>
        <div class="text-muted">Manage appointment letter records</div>
    </div>
    <?= $this->Html->link(
        __('<i class="fa-solid fa-plus me-1"></i> Add Letter'),
        ['action' => 'add'],
        ['class' => 'btn btn-teal', 'escapeTitle' => false]
    ) ?>
</div>

<!-- ===== STAT CARDS ===== -->
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="stat-card-teal">
            <i class="fa-regular fa-file-lines stat-icon"></i>
            <div class="stat-number"><?= $total_appointments ?></div>
            <div class="stat-label">Total Appointments</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-teal" style="border-left-color:var(--teal-light);">
            <i class="fa-regular fa-circle-check stat-icon" style="color:var(--teal-light);"></i>
            <div class="stat-number"><?= $total_appointments_active ?></div>
            <div class="stat-label">Active</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-teal" style="border-left-color:#dc3545;">
            <i class="fa-regular fa-circle-xmark stat-icon" style="color:#dc3545;"></i>
            <div class="stat-number"><?= $total_appointments_disabled ?></div>
            <div class="stat-label">Disabled</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-teal" style="border-left-color:#78909c;">
            <i class="fa-regular fa-box-archive stat-icon" style="color:#78909c;"></i>
            <div class="stat-number"><?= $total_appointments_archived ?></div>
            <div class="stat-label">Archived</div>
        </div>
    </div>
</div>

<!-- ===== TABLE CARD ===== -->
<div class="table-card-wrapper">
    <div class="table-header">
        <span><i class="fa-regular fa-calendar-check"></i> Appointment Letters</span>
        <span class="badge-teal-count"><?= $total_appointments ?> records</span>
    </div>

    <div class="p-3">
        <!-- Search Form -->
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row g-2 mb-3']) ?>
        <div class="col-md-8">
            <?= $this->Form->control('search', [
                'label' => false,
                'placeholder' => 'Search by Reference No or Title...',
                'class' => 'form-control search-box-teal',
                'value' => $this->request->getQuery('search')
            ]) ?>
        </div>
        <div class="col-md-4 d-flex gap-2">
            <?= $this->Form->button(
                '<i class="fa-solid fa-magnifying-glass me-1"></i> Search',
                ['type' => 'submit', 'class' => 'btn btn-search w-100', 'escapeTitle' => false]
            ) ?>
            <?= $this->Html->link(
                '<i class="fa-solid fa-rotate-left me-1"></i> Reset',
                ['action' => 'index'],
                ['class' => 'btn btn-search-reset w-100', 'escapeTitle' => false]
            ) ?>
        </div>
        <?= $this->Form->end() ?>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-teal align-middle">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('letter_ref_no', 'Ref No') ?></th>
                        <th><?= $this->Paginator->sort('lecturer_id', 'Lecturer') ?></th>
                        <th><?= $this->Paginator->sort('faculty_id', 'Faculty') ?></th>
                        <th><?= $this->Paginator->sort('program_id', 'Program') ?></th>
                        <th><?= $this->Paginator->sort('subject_id', 'Subject') ?></th>
                        <th><?= $this->Paginator->sort('appointment_title', 'Title') ?></th>
                        <th><?= $this->Paginator->sort('appointment_type', 'Appointment Type') ?></th>
                        <th><?= $this->Paginator->sort('academic_session', 'Academic Session') ?></th>
                        <th><?= $this->Paginator->sort('semester', 'Semester') ?></th>
                        <th><?= $this->Paginator->sort('appointment_date', 'Date') ?></th>
                        <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $item): ?>
                    <tr>
                        <td><?= $this->Number->format($item->id) ?></td>
                        <td><span class="fw-semibold"><?= h($item->letter_ref_no) ?></span></td>
                        <td><?= $item->hasValue('lecturer') ? h($item->lecturer->name) : '-' ?></td>
                        <td><?= $item->hasValue('faculty') ? h($item->faculty->name) : '-' ?></td>
                        <td><?= $item->hasValue('program') ? h($item->program->name) : '-' ?></td>
                        <td><?= $item->hasValue('subject') ? h($item->subject->code) : '-' ?></td>
                        <td><?= h($item->appointment_title) ?></td>
                        <td><?= h($item->appointment_type) ?></td>
                        <td><?= h($item->academic_session) ?></td>
                        <td><?= h($item->semester) ?></td>
                        <td><?= $item->appointment_date?->format('d M Y') ?></td>
                        <td>
                            <?php if ($item->status == 1): ?>
                                <span style="color:var(--teal-primary); font-weight:500;">Active</span>
                            <?php elseif ($item->status == 2): ?>
                                <span style="color:#78909c; font-weight:500;">Archived</span>
                            <?php else: ?>
                                <span style="color:#dc3545; font-weight:500;">Disabled</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <?= $this->Html->link(
                                    __('<i class="fa-solid fa-eye"></i> View'),
                                    ['action' => 'view', $item->id],
                                    ['class' => 'btn-action btn-view', 'escapeTitle' => false, 'title' => 'View']
                                ) ?>
                                <?= $this->Html->link(
                                    __('<i class="fa-solid fa-pen"></i> Edit'),
                                    ['action' => 'edit', $item->id],
                                    ['class' => 'btn-action btn-edit', 'escapeTitle' => false, 'title' => 'Edit']
                                ) ?>
                                <?= $this->Form->postLink(
                                    __('<i class="fa-solid fa-trash"></i> Delete'),
                                    ['action' => 'delete', $item->id],
                                    [
                                        'confirm' => __('Are you sure you want to delete # {0}?', $item->id),
                                        'class' => 'btn-action btn-delete',
                                        'escapeTitle' => false,
                                        'title' => 'Delete'
                                    ]
                                ) ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex flex-wrap justify-content-between align-items-center pt-3" style="border-top:1px solid var(--table-border);">
            <div class="text-muted small">
                <?= $this->Paginator->counter(__('Page {page} of {pages}, showing {current} record(s) out of {count} total')) ?>
            </div>
            <ul class="pagination pagination-sm mb-0">
                <?= $this->Paginator->first('<<') ?>
                <?= $this->Paginator->prev('<') ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next('>') ?>
                <?= $this->Paginator->last('>>') ?>
            </ul>
        </div>
    </div>
</div>