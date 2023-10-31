<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Forget Password</title>
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
                    <h2 class="h2 text-center mb-4">Forget Password</h2>
                    <form method="post" action="<?= base_url(); ?>send_mail_process">
                        <div class="mb-3">
                            <div class="mb-2">
                                <label class="form-label">
                                    Email
                                </label>
                                <div class="input-group input-group-flat">
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email" id="email" required placeholder="Enter your email " />
                                    </div>
                                    <span class="input-group-text">
                                        <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M11 19h-6a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v6"></path>
                                                <path d="M3 7l9 6l9 -6"></path>
                                                <path d="M15 19l2 2l4 -4"></path>
                                            </svg>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100" name="send_email">Send Mail</button>
                        </div>


                    </form>
                </div>
                </form>

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