<?php

use App\App\UtilsUtils\Auth;
use League\Plates\Template\Template;

/**
 * @var Auth $auth
 * @var Template $this
 */

$this->layout('layouts/app', ['title' => 'Login']);

$this->start('contents');
?>
    <div class="row d-flex justify-content-center mt-3" id="contents">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header fw-bold">CREATE ACCOUNT</div>
                <div class="card-body p-4">
                    <form action="" method="post" @submit.prevent="submitForm">
                        <div class="form-group">
                            <input v-model="user.username" type="text" name="username" class="form-control"
                                   :class="[inputState.username]"
                                   placeholder="Username">
                            <div ref="username-error" class="text-danger"></div>
                        </div>
                        <div class="form-group mt-2">
                            <input v-model="user.email" type="email" name="email" class="form-control"
                                   :class="[inputState.username]"
                                   placeholder="Email Address">
                            <div ref="email-error" class="text-danger"></div>
                        </div>
                        <div class="form-group mt-2">
                            <input v-model="user.password" type="password" name="password" class="form-control"
                                   :class="[inputState.username]"
                                   placeholder="Password">
                            <div ref="password-error" class="text-danger"></div>
                        </div>
                        <div class="mt-3 row">
                            <div class="col-md">
                                <a href="<?= url('login') ?>">Login</a>
                            </div>
                            <div class="col-md text-end">
                                <button type="submit" class="btn btn-primary btn-sm">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $this->end() ?>
<?php $this->start('script') ?>
    <script src="<?= assets('js/auth/register.js') ?>"></script>
<?php $this->end() ?>