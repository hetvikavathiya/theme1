<div class="page-wrapper">
    <!-- Page header -->

    <div class="my-4">
        <?php $this->load->view('admin/flash_message'); ?>
    </div>
    <div class="page-header d-print-none">
        <div class="mx-4">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z"></path>
                            <path d="M15 9h.01"></path>
                        </svg>
                        Change Password
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="mx-4">
            <div class="row row-cards">
                <div class="col-md-12">
                    <form action="<?= base_url(); ?>/admin/change_password/change" method="post">
                        <div class="card">
                            <div class="card-status-top bg-primary"></div>
                            <div class="card-header">
                                <h3 class="card-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z"></path>
                                        <path d="M15 9h.01"></path>
                                    </svg>
                                    Change Password
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row row-cards">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label required">Current Password</label>
                                            <input id="old_password" name="old_password" type="password" placeholder="Enter Current Password" class="form-control" autocomplete="off" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label required">New Password</label>
                                            <input id="new_password" name="new_password" type="password" placeholder="Enter New Password" class="form-control" autocomplete="off" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label required">Confirm Password</label>
                                            <input id="confirm_password" name="confirm_password" type="password" placeholder="Enter Confirm Password" class="form-control" autocomplete="off" required="">
                                        </div>
                                    </div>
                                    <div class="row my-4">
                                        <div class="col-md-3">
                                            <label class="form-check">
                                                <input class="form-check-input pass-show" type="checkbox">
                                                <span class="form-check-label">Show password</span>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="me-3 btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z"></path>
                                        <path d="M15 9h.01"></path>
                                    </svg>
                                    Change
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.pass-show').change(function() {
            var op = $('#old_password');
            var np = $('#new_password');
            var cp = $('#confirm_password');
            (op.attr('type') == 'password') ? op.attr('type', 'text'): op.attr('type', 'password');
            (np.attr('type') == 'password') ? np.attr('type', 'text'): np.attr('type', 'password');
            (cp.attr('type') == 'password') ? cp.attr('type', 'text'): cp.attr('type', 'password');
        })
    })
</script>
<?php if ($alert = $this->session->flashdata('flash')) { ?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: false,
        })
        Toast.fire({
            icon: '<?= $alert['class'] ?>',
            title: '<?= $alert['message'] ?>'
        })
    </script>
<?php } ?>