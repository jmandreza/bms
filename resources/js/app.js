import './bootstrap';
import jquery from 'jquery';
import DataTable from 'datatables.net';
import Alpine from 'alpinejs';

// custom module
import Alert from './dialog';

window.$ = jquery;
window.DataTable  = DataTable;
window.Alpine = Alpine;

// resolve custom module
window.Alert = Alert.dialog;

Alpine.start();
