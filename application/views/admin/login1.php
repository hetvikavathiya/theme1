<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>login</title>
    <!-- CSS files -->
    <link href="<?= base_url('assets/dist/') ?>css/tabler.min.css?1674944402" rel="stylesheet" />
    <link href="<?= base_url('assets/dist/') ?>css/tabler-flags.min.css?1674944402" rel="stylesheet" />
    <link href="<?= base_url('assets/dist/') ?>css/tabler-payments.min.css?1674944402" rel="stylesheet" />
    <link href="<?= base_url('assets/dist/') ?>css/tabler-vendors.min.css?1674944402" rel="stylesheet" />
    <link href="<?= base_url('assets/dist/') ?>css/demo.min.css?1674944402" rel="stylesheet" />
</head>


<body class=" d-flex flex-column">
    <script src="./dist/js/demo-theme.min.js?1692870487"></script>
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a href="." class="navbar-brand navbar-brand-autodark">
                    <img src="<?= base_url('assets\img\logo.jpg') ?>" width="110" height="32" alt="Tabler" class="navbar-brand-image">
                </a>
            </div>

            <?php $this->load->view('admin/flash_message'); ?>
            <div class="card card-md">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Login to your account</h2>
                    <?php echo form_open('Login1'); ?> <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="name" value="" placeholder="enter your name" />
                        <label class="form-label">Mobile No</label>
                        <?php echo form_input(['class' => 'form-control my-2', 'placeholder' => 'enter mobile no', 'id' => 'mobile_no', 'name' => 'mobile_no', 'value' => set_value("mobile_no")]); ?>
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-success w-100"">Send Otp</button>
                    </div>
                   <div class=" row my-3">
                            <label class=" form-label">OTP</label>
                            <?php echo form_input(['class' => 'form-control my-2', 'placeholder' => 'enter Otp Number', 'id' => 'otp', 'name' => 'otp', 'value' => set_value("otp")]); ?>
                    </div>


                    <div class="row">
                        <button type="submit" class="btn btn-primary w-100">Verify Otp</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src=" ./dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./dist/js/demo.min.js?1692870487" defer></script>
</body>
<script src="<?= base_url('assets/dist/') ?>js/tabler.min.js?1674944402" defer></script>
<script src="<?= base_url('assets/dist/') ?>js/demo.min.js?1674944402" defer></script>

</html>