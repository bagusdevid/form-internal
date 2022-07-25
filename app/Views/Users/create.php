<?= $this->extend('theme')?>

<?= $this->section('title')?>
<?= $page_title;?>
<?= $this->endSection();?>

<?= $this->section('content')?>

<h3 class="page-title"><?= $page_title;?></h3>

<?php if (session()->has('success')) : ?>
	<div class="alert alert-success"><?= session()->get('success'); ?></div>
<?php endif; ?>

<?= form_open('users/store');?>

<div class="form-group">
	<label for="name">Name</label>
	<input type="text" id="name" name="name" class="form-control" />
</div>
<div class="form-group">
	<label for="email">Email</label>
	<input type="text" id="email" name="email" class="form-control" />
</div>
<div class="form-group">
	<label for="password">Password</label>
	<input type="password" id="password" name="password" class="form-control" />
</div>
<div class="form-group">
	<label for="password_confirmation">Ulangi password</label>
	<input type="password" id="password_confirmation" name="password_confirmation" class="form-control" />
</div>
<div class="form-group">
	<label for="is_admin">Admin</label>
	<input type="checkbox" id="is_admin" name="is_admin" />
</div>
<div class="form-group">
	<button type="submit" name="submit" class="btn btn-primary">Simpan</button>
</div>

</form>

<?= $this->endSection()?>