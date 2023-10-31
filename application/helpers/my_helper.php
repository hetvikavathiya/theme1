<?php

function pre($data)
{
    echo "<pre>";
    print_r($data);
    exit;
}

function chech_login()
{
    $ci = &get_instance();
    if (!$ci->session->userdata('admin_login')) {
        redirect(site_url('login/verify'), 'refresh');
    }
}
