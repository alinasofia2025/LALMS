<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Appointment $appointment
 * @var \Cake\Collection\CollectionInterface|string[] $lecturers
 * @var \Cake\Collection\CollectionInterface|string[] $faculties
 * @var \Cake\Collection\CollectionInterface|string[] $projects
 * @var \Cake\Collection\CollectionInterface|string[] $subjects
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
            <?= $this->Html->link(__('List Appointments'), ['action' => 'index'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?>
                </div>
        </div>
    </div>
</div>
<div class="line mb-4"></div>
<!--/Header-->

<div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow">
    <div class="card-body text-body-secondary">
            <?= $this->Form->create($appointment) ?>
            <fieldset>
                <legend><?= __('Add Appointment') ?></legend>

                    <?php echo $this->Form->control('lecturer_id', ['options' => $lecturers, 'empty' => '-- Select Lecturer --']); ?>
                    <?php echo $this->Form->control('faculty_id', ['options' => $faculties, 'empty' => '-- Select Faculty --']); ?>
                    <?php echo $this->Form->control('program_id', ['options' => $projects, 'empty' => '-- Select Programme --']); ?>
                    <?php echo $this->Form->control('subject_id', ['options' => $subjects, 'empty' => '-- Select Subject --']); ?>
                    <?php echo $this->Form->control('letter_ref_no'); ?>
                    <?php echo $this->Form->control('appointment_type'); ?>
                    <?php echo $this->Form->control('appointment_title'); ?>
                    <?php echo $this->Form->control('academic_session'); ?>
                    <?php echo $this->Form->control('semester'); ?>
                    <?php echo $this->Form->control('appointment_date'); ?>
                    <?php echo $this->Form->control('appointment_start'); ?>
                    <?php echo $this->Form->control('appointment_end'); ?>
                    <?php echo $this->Form->control('remarks'); ?>
                    <?php echo $this->Form->control('status'); ?>

            </fieldset>
                <div class="text-end">
                  <?= $this->Form->button('Reset', ['type' => 'reset', 'class' => 'btn btn-outline-warning']); ?>
                  <?= $this->Form->button(__('Submit'),['type' => 'submit', 'class' => 'btn btn-outline-primary']) ?>
                </div>
        <?= $this->Form->end() ?>
    </div>
</div>