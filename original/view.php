<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Appointment $appointment
 */
?>
<!--Header-->
<div class="row text-body-secondary">
	<div class="col-10">
		<h1 class="my-0 page_title"><?php echo $title; ?></h1>
		<h6 class="sub_title text-body-secondary"><?php echo $system_name; ?></h6>
	</div>
	<div class="col-2 text-end">
		<div class="dropdown mx-3 mt-2">
			<button class="btn p-0 border-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fa-solid fa-bars text-primary"></i>
			</button>
				<div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
							<li><?= $this->Html->link(__('Edit Appointment'), ['action' => 'edit', $appointment->appointments_id], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
				<li><?= $this->Form->postLink(__('Delete Appointment'), ['action' => 'delete', $appointment->appointments_id], ['confirm' => __('Are you sure you want to delete # {0}?', $appointment->appointments_id), 'class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
				<li><hr class="dropdown-divider"></li>
				<li><?= $this->Html->link(__('List Appointments'), ['action' => 'index'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
				<li><?= $this->Html->link(__('New Appointment'), ['action' => 'add'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
							</div>
		</div>
    </div>
</div>
<div class="line mb-4"></div>
<!--/Header-->

<div class="row">
	<div class="col-md-9">
		<div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow">
			<div class="card-body text-body-secondary">
            <h3><?= h($appointment->letter_ref_no) ?></h3>
    <div class="table-responsive">
        <table class="table">
                <tr>
                    <th><?= __('Lecturer') ?></th>
                    <td><?= $appointment->hasValue('lecturer') ? $this->Html->link($appointment->lecturer->name, ['controller' => 'Lecturers', 'action' => 'view', $appointment->lecturer->lecturer_id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Faculty') ?></th>
                    <td><?= $appointment->hasValue('faculty') ? $this->Html->link($appointment->faculty->name, ['controller' => 'Faculties', 'action' => 'view', $appointment->faculty->faculties_id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Subject') ?></th>
                    <td><?= $appointment->hasValue('subject') ? $this->Html->link($appointment->subject->name, ['controller' => 'Subjects', 'action' => 'view', $appointment->subject->subjects_id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Letter Ref No') ?></th>
                    <td><?= h($appointment->letter_ref_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Appointment Type') ?></th>
                    <td><?= h($appointment->appointment_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Academic Session') ?></th>
                    <td><?= h($appointment->academic_session) ?></td>
                </tr>
                <tr>
                    <th><?= __('Semester') ?></th>
                    <td><?= h($appointment->semester) ?></td>
                </tr>
                <tr>
                    <th><?= __('Appointment Title') ?></th>
                    <td><?= h($appointment->appointment_title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Appointments Id') ?></th>
                    <td><?= $appointment->id ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td>
                    <?php
                    switch ($appointment->status) {
                    case 1:
                            echo '<span class="badge bg-success">Active</span>';
                            break;

                    case 2:
                             echo '<span class="badge bg-secondary">Archived</span>';
                             break;

                    default:
                               echo '<span class="badge bg-danger">Disabled</span>';
                    }
                    ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Appointment Date') ?></th>
                    <td><?= $appointment->appointment_date?->format('d M Y') ?></td>
                </tr>
                <tr>
                    <th><?= __('Effective Start Date') ?></th>
                    <td><?= h($appointment->appointment_start) ?></td>
                </tr>
                <tr>
                    <th><?= __('Effective End Date') ?></th>
                    <td><?= h($appointment->appointment_end) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($appointment->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($appointment->modified) ?></td>
                </tr>
            </table>
            </div>
            <div class="text">
                <strong><?= __('Remarks') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($appointment->remarks)); ?>
                </blockquote>
            </div>

			</div>
		</div>
		
	<div class="card shadow border-0">

<div class="card-header">

Quick Actions

</div>

<div class="card-body d-grid gap-2">

Edit

Download PDF

Back

Delete

</div>

</div>




