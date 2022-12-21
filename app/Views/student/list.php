<?= $this->extend('student/layout') ?>
<?= $this->section('content') ?>
<h1>Student List</h1>

<?php if (session()->has('error')) : ?>
    <div class="trigger trigger-error" role="alert">
        <?= session()->getFlashdata('error') ?>
    </div> 
<?php endif; ?>
<?php if (session()->has('success')) : ?>
    <div class="trigger trigger-success" role="alert">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Foto</th>
            <th>Aluno</th>
            <th> - </th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($students) && !empty($students)) :
        ?>
            <?php foreach ($students as $student) : ?>
                <tr>
                    <td><?= $student['student_id'] ?></td>
                    <td><img width="60" src="<?=base_url('alunos/'.$student['student_picture']) ?>" alt=""></td>
                    <td><?= $student['student_name'] ?></td>
                    <td>
                        <a href="<?= url_to('student.edit',$student['student_id']) ?>">Edit</a>
                        <a href="<?= url_to('student.destroy',$student['student_id']) ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="6">
                    <div class="trigger trigger-success">Não há alunos cadasatrados!</div>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?= $this->endSection() ?>