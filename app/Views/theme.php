<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $this->renderSection('title'); ?> :: AGDC</title>
    <meta name="description" content="AGDC app">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="<?= site_url('favicon.ico'); ?>" />
    <link rel="stylesheet" href="<?= site_url('third-party/fontawesome/css/all.min.css'); ?>" />

    <link rel="stylesheet" href="<?= site_url('third-party/bootstrap/css/bootstrap.min.css'); ?>" />

    <link rel="stylesheet" type="text/css" href="<?= site_url('third-party/DataTables/datatables.min.css'); ?>" />
    <link rel="stylesheet" type="text/css"
        href="<?= site_url('third-party/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css');?>" />

    <link rel="stylesheet" type="text/css" href="<?= site_url('css/style.css'); ?>" />
</head>

<body>

    <div id="page">
        <header class="app-header">
            <nav class="navbar navbar-expand-lg navbar-light bg-dark">
                <a class="navbar-brand text-white" href="<?= site_url();?>">AGDC</a>
                <?php if(session()->get('is_admin')) : ?>
                <ul class="menus">
                    <li class="<?= (url_is('users')) ? 'active' : '';?>">
                        <a href="<?= site_url('users');?>">Users</a>
                    </li>
                    <li class="<?= (url_is('setting')) ? 'active' : '';?>">
                        <a href="<?= site_url('setting');?>">Setting</a>
                    </li>
                </ul>
                <?php endif;?>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="navbar-nav ml-auto">
                        
                        <div class="mm-right-nav dropdown">
                <button type="button" class="dropdown-toggle" data-toggle="dropdown">
                    <div class="icon">
                        <i class="far fa-user-circle"></i>
                    </div>
                    <div class="name">
                        <?php echo (current_user()) ? current_user()->name : 'UNAUTHENTICATED' ?>
                    </div>
                </button>
                <div class="dropdown-menu">
                    <a href="<?= site_url('users/change_passwd'); ?>" class="dropdown-item">Ubah password</a>
                    <a href="<?= site_url('logout'); ?>" onclick="return confirm('Anda yakin untuk Logout?')"
                        class="dropdown-item">Logout</a>
                </div>
            </div>

                    </div>
                </div>
            </nav>
        </header>

        <div class="content-wrapper">

            <div class="content">

                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <?= $this->renderSection('content') ?>
                        </div>
                    </div>
                </div>

            </div>

            <footer class="app-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="copyright">
                                &copy; <?= date("Y") ?> BagusDev.id reserved.
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    <!-- SCRIPTS -->

    <script src="<?= site_url('third-party/jquery/jquery.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= site_url('third-party/DataTables/datatables.min.js');?>"></script>
    <script type="text/javascript"
        src="<?= site_url('third-party/DataTables/DataTables-1.11.3/js/dataTables.bootstrap4.min.js');?>"></script>
    <script src="<?= site_url('third-party/bootstrap/js/popper.min.js'); ?>"></script>
    <script src="<?= site_url('third-party/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= site_url('third-party/moment/moment.min.js'); ?>"></script>
    <script src="<?= site_url('third-party/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'); ?>">
    </script>
    <script type="text/javascript">
        const HOST = "<?= base_url(); ?>"
    </script>
    <?php if(!url_is('users') && !url_is('users/*')) : ?>
    <script src="<?= site_url('js/custom.js'); ?>"></script>
    <?php endif;?>
    <?php if(url_is('users') || url_is('users/*')) : ?>
    <script src="<?= site_url('js/users.js'); ?>"></script>
    <?php endif;?>
    <!-- -->

</body>

</html>