<?php

namespace Dashboard\View;

class ViewLogin extends ViewBase {

    private $_login_error;

    public function __construct( bool $showLoginError = false ) {
        $this->_page_title = 'Login';
        $this->_login_error = $showLoginError;
    }

    protected function _build_page_content() {
        $errors_html = '';
        if ( $this->_login_error ) {
            $errors_html .= '
                <div class="card-panel red lighten-2">
                    <span class="white-text"><i class="material-icons" style="vertical-align: top;">error_outline</i>
                    The username or password was invalid.</span>
                </div>
            ';
        }

        return '
            <div class="section">
                <div class="row">
                    <div class="col s12 m6 offset-m3">
                        ' . $errors_html . '
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