<?= $this->extend('theme')?>

<?= $this->section('title')?>
<?= $page_title;?>
<?= $this->endSection();?>

<?= $this->section('content')?>

<h3 class="page-title"><?= $page_title;?></h3>

<?php if (session()->has('success')) : ?>
	<div class="alert alert-success"><?= session()->get('success'); ?></div>
<?php endif; ?>
<?php if (session()->has('error')) : ?>
	<div class="alert alert-danger"><?= session()->get('error'); ?></div>
<?php endif; ?>

<?= form_open('users/changePasswdProcess');?>

<div class="form-group">
	<label for="password">Password baru</label>
	<input type="password" id="password" name="password" class="form-control" />
</div>
<div class="form-group">
	<label for="password_confirmation">Ulangi password baru</label>
	<input type="password" id="password_confirmation" name="password_confirmation" class="form-control" />
</div>
<div class="form-group">
	<button type="submit" name="submit" class="btn btn-primary">Simpan</button>
</div>

</form>

<?= $this->endSection()?>