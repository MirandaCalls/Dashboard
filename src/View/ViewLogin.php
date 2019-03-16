<?php

namespace Dashboard\View;

class ViewLogin extends ViewBase {

    public function __construct() {
        $this->_page_title = 'Login';
    }

    protected function _build_page_content() {
        return '
            <div class="section">
                <div class="row">
                    <div class="col s12 m6 offset-m3">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Log In</span>
                                <form action="/login" method="POST">
                                    <div class="input-field">
                                        <input id="username" name="username" type="text">
                                        <label for="username">Username</label>
                                    </div>
                                    <div class="input-field">
                                        <input id="password" name="password" type="password">
                                        <label for="password">Password</label>
                                    </div>
                                    <button class="btn waves-effect waves-light" type="submit">Login
                                        <i class="material-icons right">lock</i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }
}