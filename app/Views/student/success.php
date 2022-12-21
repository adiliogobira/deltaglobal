<?= $this->extend('student/layout') ?>
<?= $this->section('content') ?>

<p><b><?=$message?></b></p>


<p>
    <a href="<?=url_to('student.list')?>">Voltar para a lista de alunos</a>    
</p>
<?= $this->endSection() ?>