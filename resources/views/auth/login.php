<?php

use App\Utils\Auth;

$this->layout('layouts/app', ['title' => 'Login']);

/**
 * @var Auth $auth
 */

$this->start('contents');
?>

    <div class="row d-flex justify-content-center mt-3" id="app">
        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-header fw-bold">LOGIN</div>
                <div class="card-body p-4">
                    <form @submit.prevent="login" method="post">
                        <div class="form-group">
                            <input v-model="user.username" type="text" name="username" class="form-control"
                                   :class="[inputState.username]"
                                   placeholder="Username">
                            <div ref="username-error" class="text-danger"></div>
                        </div>
                        <div class="form-group mt-2">
                            <input v-model="user.password" type="password" name="password" class="form-control"
                                   :class="[inputState.username]"
                                   placeholder="Password">
                            <div ref="password-error" class="text-danger"></div>
                        </div>
                        <div class="mt-3 row">
                            <div class="col-md">
                                <a href="<?= uri('register.get') ?>">Register</a>
                            </div>
                            <div class="col-md text-end">
                                <button type="submit" class="btn btn-primary btn-sm">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $this->end() ?>
<?php $this->start('script') ?>
    <script src="<?= assets('js/auth/login.js') ?>"></script>
<?php $this->end() ?>