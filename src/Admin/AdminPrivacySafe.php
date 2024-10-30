<?php

namespace Data443\LGPD\Admin;

use Data443\LGPD\Admin\AdminNotice;

class AdminPrivacySafe extends AdminNotice
{
    public function render()
    {
        if (!$this->template) {
            return;
        }

        echo lgpd('view')->render('admin/notices/header-privacy-safe');
        echo lgpd('view')->render($this->template, $this->data);
        echo lgpd('view')->render('admin/notices/footer-step');
    }
}