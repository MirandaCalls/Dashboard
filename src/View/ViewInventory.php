<?php

namespace Dashboard\View;

class ViewInventory extends ViewBase {

    private $_items;

    private $_rooms;

    private $_units;

    public function __construct( array $items, array $rooms, array $units ) {
        $this->_page_title = 'Inventory';
        $this->_request_uri = '/inventory';

        $this->_stylesheets[] = 'datatables.css';
        $this->_stylesheets[] = 'inventory.css';

        $this->_scripts[] = 'inventory.js';
        $this->_scripts[] = 'datatables.min.js';

        $this->_items = $items;
        $this->_rooms = $rooms;
        $this->_units = $units;
    }

    protected function _build_page_content() : string {
        return '
            <h5>Inventory</h5>
            <div class="divider"></div>
            <div class="section">
                <div class="row">
                    <div class="col s12 m3">
                        <div class="card">
                            <div class="collection">
                                <p class="collection-item">Preferences</p>
                                <a id="btn_add_item" class="collection-item modal-trigger" href="#modal_add_item"><i class="material-icons left">add</i>Add Item</a>
                                <a href="#!" class="collection-item"><i class="material-icons left">room</i>Manage Rooms</a>
                                <a href="#!" class="collection-item"><i class="material-icons left">donut_small</i>Manage Units</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="collection">
                                <p class="collection-item">Shopping List</p>
                                <p class="collection-item list-item-empty"><i>List is Empty</i></p>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m9">
                        <div class="card">
                            ' . $this->_build_inventory_items_table() . '
                        </div>
                    </div>
                </div>
            </div>
            ' . $this->_build_item_modal() . '
        ';
    }

    private function _build_inventory_items_table() : string {
        return '
            <table id="table_items" class="data-table highlight">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Room</th>
                        <th>Amount</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    ' . $this->_build_item_rows() . '
                </tbody>
            </table>
        ';
    }

    private function _build_item_rows() : string {
        $item_rows = [];
        foreach ( $this->_items as $item ) {
            $id = $item->get_id();
            $name = $item->get_name();
            $amount = $item->get_amount() . ' (' . $item->get_unit()->get_abbreviation() . ')';
            $room_name = $item->get_room()->get_name();
            $item_rows[] = '
                <tr>
                    <td>' . $name . '</td>
                    <td>' . $room_name . '</td>
                    <td>' . $amount . '</td>
                    <td><a data-id="' . $id . '" class="btn-edit-item"><i class="material-icons blue-grey-text darken-3">edit</i></a></td>
                </tr>
            ';
        }

        return implode( PHP_EOL, $item_rows );
    }

    private function _build_item_modal() : string {
        return '
            <div id="modal_add_item" class="modal modal-fixed-footer">
                <div class="modal-content">
                    <div class="row">
                        <h5 id="modal_header" class="modal-header"></h5>
                        <span class="modal-close close-popup-btn right"><i class="material-icons">close</i></span>
                    </div>
                    <div class="divider"></div>
                    <div class="section">
                        ' . $this->_build_item_form() . '
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="btn_save_item" class="waves-effect waves-light btn left"><i class="material-icons left">save</i>Save</a>
                    <a id="btn_delete_item" class="waves-effect waves-light btn red lighten-2 right"><i class="material-icons left">delete</i>Delete</a>
                </div>
            </div>
        ';
    }

    private function _build_item_form() : string {
        return '
            <form id="item_form">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="item_name" name="name" type="text">
                        <label for="item_name">Name</label>
                    </div>
                    ' . $this->_build_room_selector() . '
                    <div class="input-field col s4">
                        <input id="item_amount" name="amount" type="text">
                        <label for="item_amount">Amount</label>
                    </div>
                    <div class="input-field col s4">
                        <input id="item_low_amount" name="low_stock_amount" type="text">
                        <label for="item_low_amount">Low Amount</label>
                    </div>
                    ' . $this->_build_unit_selector() . '
                    <div class="input-field col s12">
						<textarea id="item_description" name="description" class="materialize-textarea" data-length="500"></textarea>
						<label for="item_description">Description</label>
					</div>
                </div>
            </form>
        ';
    }

    private function _build_room_selector() : string {
        $room_options = array();
        foreach ( $this->_rooms as $room ) {
            $room_id = $room->get_id();
            $room_name = $room->get_name();
            $room_options[] = '<option value="' . $room_id . '">' . $room_name . '</option>';
        }

        return '
            <div class="input-field col s12">
                <select id="item_room" name="room_id">
                ' . implode( PHP_EOL, $room_options ) . '
                </select>
                <label for="item_room">Room</label>
            </div>
        ';
    }

    private function _build_unit_selector() : string {
        $unit_options = array();
        foreach ( $this->_units as $unit ) {
            $unit_id = $unit->get_id();
            $unit_name = $unit->get_full_name() . ' (' . $unit->get_abbreviation() . ')';
            $unit_options[] = '<option value="' . $unit_id . '">' . $unit_name . '</option>';
        }

        return '
            <div class="input-field col s4">
                <select id="unit_type" name="unit_id">
                    ' . implode( PHP_EOL, $unit_options ) . '
                </select>
                <label for="unit_type">Unit</label>
            </div>
        ';
    }
}