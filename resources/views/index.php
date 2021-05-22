<?php

use App\Utils\Auth;
use League\Plates\Template\Template;

/**
 * @var $this Template
 */
$this->layout('layouts/app', ['title' => 'Homepage']);

/**
 * @var Auth $auth
 */

$this->start('contents');
?>

    <div class="card">
        <div class="card-header">Main</div>
        <div class="card-body">
            <p>Hello, <?= $auth->user()['username'] ?></p>
        </div>
    </div>

<?php $this->end() ?>