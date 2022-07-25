<?= $this->extend('theme')?>

<?= $this->section('title')?>
<?= $page_title;?>
<?= $this->endSection();?>

<?= $this->section('content')?>

<h3 class="page-title"><?= $page_title;?></h3>

<?php if (session()->has('success')) : ?>
	<div class="alert alert-success"><?= session()->get('success'); ?></div>
<?php endif; ?>

<table id="dataList" class="table table-bordered table-striped" style="width: 100%;">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Email</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
</table>

<!-- Modal -->
<div class="modal fade" id="dataForm" tabindex="-1" aria-labelledby="dataFormLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form>
			<input type="hidden" name="id" value="" />
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="dataFormLabel"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="msg"></div>
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="nama">Nama <span class="text-danger">*</span></label>
								<input name="name" type="text" class="form-control" id="nama">
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input name="email" type="text" class="form-control" id="email">
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input name="password" type="password" class="form-control" id="password">
							</div>
							<div class="form-group">
								<label for="password_confirmation">Ulangi Password</label>
								<input name="password_confirmation" type="password" class="form-control" id="password_confirmation">
							</div>
							<div class="form-group">
								<label for="is_admin" class="d-block">Admin</label>
								<input type="checkbox" name="is_admin" value="1">
							</div>

						</div>
						
					</div>
				</div>
				<div class="modal-footer">
					<div class="loading-indicator"></div>
					<div class="form-navigation">
						<button name="submit" type="submit" class="btn btn-primary btn-save">Simpan</button>
						<button name="cancel" type="button" class="btn btn-link btn-cancel text-danger" data-dismiss="modal">Batal</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="changepasswdForm" tabindex="-1" aria-labelledby="dataFormLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form name="changepasswd">
			<input type="hidden" name="id" value="" />
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="dataFormLabel">Ubah password</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="msg"></div>
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="newpassword">Password baru</label>
								<input name="password" type="password" class="form-control" id="newpassword">
							</div>
							<div class="form-group">
								<label for="newpassword_confirmation">Ulangi Password baru</label>
								<input name="password_confirmation" type="password" class="form-control" id="newpassword_confirmation">
							</div>
						</div>
						
					</div>
				</div>
				<div class="modal-footer">
					<div class="loading-indicator"></div>
					<div class="form-navigation">
						<button name="submit" type="submit" class="btn btn-primary btn-save">Simpan</button>
						<button name="cancel" type="button" class="btn btn-link btn-cancel text-danger" data-dismiss="modal">Batal</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<?= $this->endSection()?>