<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Appointment Letter - <?= h($appointment->letter_ref_no) ?></title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; color: #222; margin: 40px; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 12px; margin-bottom: 30px; }
        .ref { display: flex; justify-content: space-between; margin-bottom: 25px; }
        .letter-box { max-width: 850px; margin: auto; }
        .subject { font-weight: bold; text-transform: uppercase; margin: 22px 0; }
        .signature { margin-top: 70px; }
        .btn-print { position: fixed; top: 10px; right: 10px; padding: 8px 16px; }
        @media print { .btn-print { display: none; } body { margin: 20mm; } }
    </style>
</head>
<body>
<button class="btn-print" onclick="window.print()">Print</button>
<div class="letter-box">
    <div class="header">
        <h2>LETTER MANAGEMENT SYSTEM</h2>
        <div>Official Appointment Letter</div>
    </div>

    <div class="ref">
        <div>Ref No: <strong><?= h($appointment->letter_ref_no) ?></strong></div>
        <div>Date: <strong><?= h($appointment->appointment_date) ?></strong></div>
    </div>

    <p>To,</p>
    <p><strong><?= h($appointment->lecturer->name ?? '-') ?></strong><br>
    <?= h($appointment->lecturer->email ?? '-') ?><br>
    <?= h($appointment->faculty->name ?? '-') ?></p>

    <p class="subject">Subject: <?= h($appointment->appointment_title) ?></p>

    <p>Dear Sir/Madam,</p>

    <p>
        We are pleased to appoint you for the following academic/project-related responsibility under the Letter Management System:
    </p>

    <table style="width:100%; border-collapse: collapse; margin: 20px 0;" border="1" cellpadding="8">
        <tr><th align="left">Faculty</th><td><?= h($appointment->faculty->name ?? '-') ?></td></tr>
        <tr><th align="left">Project</th><td><?= h($appointment->project->name ?? '-') ?></td></tr>
        <tr><th align="left">Subject</th><td><?= h($appointment->subject->code ?? '-') ?> - <?= h($appointment->subject->name ?? '-') ?></td></tr>
        <tr><th align="left">Effective Date</th><td><?= h($appointment->effective_date ?? '-') ?></td></tr>
        <tr><th align="left">Remarks</th><td><?= nl2br(h($appointment->remarks ?? '-')) ?></td></tr>
    </table>

    <p>
        Kindly carry out the appointment according to the relevant academic procedure, project requirement and faculty instruction.
    </p>

    <p>Thank you.</p>

    <div class="signature">
        <p>Yours faithfully,</p>
        <br><br>
        <p><strong>Administrator</strong><br>
        Letter Management System</p>
    </div>
</div>
</body>
</html>
