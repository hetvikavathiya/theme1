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
                    <?php echo form_open('login/verify'); ?> <div class="mb-3">
                        <label class="form-label">Mobile No</label>
                        <?php echo form_input(['class' => 'form-control my-2', 'placeholder' => 'enter mobile no', 'id' => 'mobile_no', 'name' => 'mobile_no', 'value' => set_value("mobile_no")]); ?>
                    </div>
                    <div>
                        <?php echo form_error('mobile_no'); ?>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            Password
                        </label>
                        <div class="input-group input-group-flat">
                            <?php echo form_password(['class' => 'form-control my-2', 'placeholder' => 'enter password', 'id' => 'password', 'name' => 'password', 'value' => set_value("password")]); ?>
                            <span class="input-group-text">
                                <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div>
                        <?php echo form_error('password'); ?>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100" onclick="phoneauth();">Sign in</button>
                    </div>
                    <div class="row my-3">
                        <a href="<?php echo base_url('login/forgot_password')  ?>">Forgot Password</a>

                    </div>
                    <div class="alert alert-warning" style="display:none;">
                        please enter otp
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./dist/js/demo.min.js?1692870487" defer></script>
</body>
<script src="<?= base_url('assets/dist/') ?>js/tabler.min.js?1674944402" defer></script>
<script src="<?= base_url('assets/dist/') ?>js/demo.min.js?1674944402" defer></script>

</html>