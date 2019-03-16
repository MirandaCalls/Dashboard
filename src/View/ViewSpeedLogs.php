<?php

namespace Dashboard\View;

class ViewSpeedLogs extends ViewBase {

    private $_log_entries;

    private $_hosts;

    public function __construct( array $log_entries, array $hosts ) {
        $this->_page_title = 'Speed Logs';
        $this->_request_uri = '/speedlogs';

        $this->_stylesheets[] = 'datatables.css';

        $this->_scripts[] = 'speedlogs.js';
        $this->_scripts[] = 'datatables.min.js';

        $this->_log_entries = $log_entries;
        $this->_hosts = $hosts;
    }

    protected function _build_page_content() {
        return '
            <h5>Logs</h5>
            <div class="divider"></div>
            <div class="section">
                <div class="chip">Last 7 Days<i class="close material-icons">arrow_drop_down</i></div>
            </div>
            <div class="row">
                <div class="card">
                    ' . $this->_build_log_table() . '
            	</div>
            </div>
            <div class="fixed-action-btn click-to-toggle">
                <a class="btn-floating btn-large blue-grey">
                    <i class="large material-icons">build</i>
                </a>
                <ul>
                    <li><a class="modal-trigger btn-floating" href="#modal-run-test"><i class="material-icons">add</i></a></li>
                    <li><a class="btn-floating"><i class="material-icons">arrow_downward</i></a></li>
                </ul>
            </div>
            ' . $this->_build_run_test_modal() . '
        ';
    }

    private function _build_log_table() : string {
        return '
            <table id="table_logs" class="data-table striped centered">
                <thead>
                    <tr>
                        <th>Download</th>
                        <th>Upload</th>
                        <th>Log Time</th>
                        <th>Host</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    ' . $this->_build_log_rows() . '
                </tbody>
            </table>
        ';
    }

    private function _build_log_rows() : string {
        $html = '';

        foreach ( $this->_log_entries as $log ) {
            $html .= '
                <tr>
                    <td>' . $log->get_download_speed( true ) . '</td>
                    <td>' . $log->get_upload_speed( true ) . '</td>
                    <td>' . $log->get_time()->format( 'Y-m-d H:i' ) . '</td>
                    <td>' . $log->get_host()->get_name() . '</td>
                    <td>' . $log->get_host()->get_location() . '</td>
                </tr>
            ';
        }

        return $html;
    }

    private function _build_run_test_modal() : string {
        return '
            <div id="modal-run-test" class="modal">
                <div class="modal-content">
                    <div class="row">
                        <h5 class="modal-header">Run Speed Test</h5>
                        <span class="modal-close close-popup-btn right"><i class="material-icons">close</i></span>
                    </div>
                    <div class="divider"></div>
                    <p>Run a speedtest using speedtest-cli on the Dashboard server.  Currently, only ethernet tests are available.</p>
                    <div class="section">
                        ' . $this->_build_host_selector() . '
                        <a class="waves-effect waves-light btn" id="btn-run-test">Run</a>
                        <div id="progress-run-test" class="progress" style="display: none;">
                            <div class="indeterminate"></div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }

    private function _build_host_selector() : string {
        $host_options = array();
        foreach ( $this->_hosts as $host ) {
            $server_id = $host->get_server_id();
            $location = $host->get_location();
            $company = $host->get_name();
            $host_options[] = '<option value="' . $server_id . '">' . $location . ' - ' . $company . '</option>';
        }

        return '
            <div id="contain-select-server" class="input-field col s12">
                <select id="select-server-id">
                    <option value="0" selected>Default</option>
                    ' . implode( PHP_EOL, $host_options ) . '
                </select>
                <label for="select-server-id">Speedtest Server</label>
            </div>
        ';
    }
}