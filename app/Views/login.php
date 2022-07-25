<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login :: AGDC</title>
    <meta name="description" content="AGDC app">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="<?= site_url('favicon.ico');?>" />
    <link rel="stylesheet" href="<?= site_url('third-party/fontawesome/css/all.min.css'); ?>" />

    <link rel="stylesheet" href="<?= site_url('third-party/bootstrap/css/bootstrap.min.css'); ?>" />

    <link rel="stylesheet" type="text/css" href="<?= site_url('css/style.css'); ?>" />
</head>

<body style="background-color: #f9f9f9;">

    <div id="page">

        <div class="page-container">

            <div class="login-wrapper">

                <div class="logo">
                    AGDC
                </div>

                <div class="login-box">
                    <?= form_open('login/verify');?>
                        <h2 class="title">Login</h2>
                        
                        <?php if(session()->has('error')) : ?>
                        <div class="alert alert-danger"><?= session()->get('error');?></div>
                        <?php endif;?>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" type="text" class="form-control<?= (session()->has('error')) ? ' border-danger' : '';?>" id="email" value="<?= old('email');?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input name="password" type="password" class="form-control<?= (session()->has('error')) ? ' border-danger' : '';?>" id="password">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="login" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>

                <div class="copyright">
                    &copy; <?= date("Y") ?> BagusDev.id reserved.
                </div>

            </div>

        </div>

    </div>

    <!-- SCRIPTS -->

    <script src="<?= site_url('third-party/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= site_url('third-party/bootstrap/js/popper.min.js'); ?>"></script>
    <script src="<?= site_url('third-party/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript">
        const HOST = "<?= base_url();?>"
    </script>

    <script src="<?= site_url('js/custom.js'); ?>"></script>
    <!-- -->

</body>

</html>