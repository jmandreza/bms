import './bootstrap';
import jquery from 'jquery';
import DataTable from 'datatables.net';
import Alpine from 'alpinejs';


// custom module
import Toast from './toast';
import Alert from './dialog';
import Methods from './methods';
import Push from './push';
import QrScanner from "./scanner";
import Chart from "./chart";
import 'jquery-mask-plugin';

window.$ = jquery;
window.DataTable  = DataTable;
window.Alpine = Alpine;
window.QrScanner = QrScanner;

// resolve custom module alias
window.Toast = Toast.toast;
window.Alert = Alert.dialog;
window.Method = Methods;
window.Push = Push;
window.QrScanner = QrScanner.scan;
window.Chart = Chart.Chart;

Alpine.start();