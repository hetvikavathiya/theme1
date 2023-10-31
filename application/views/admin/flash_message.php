<?php if ($alert = $this->session->flashdata('flash')) { ?>
    <div class="mx-4">
        <div class="alert alert-<?= $alert['class'] ?> alert-dismissible fade show " role="alert">
            <strong>
                <?= $alert['message'] ?>
            </strong>
            <a class="btn-close btn-close-red" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    </div>
<?php } ?>