const $ = require('jquery');
global.$ = global.jQuery = $;
require('bootstrap');
import {createTimePicker} from '../../assets/js/vendors/timepicker/timepicker';
global.createTimePicker = createTimePicker;
require('../../node_modules/wickedpicker/dist/wickedpicker.min.js');
require('../../node_modules/popper.js/dist/umd/popper.min.js');
require('../../node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js');
require('../../node_modules/@coreui/coreui/dist/js/coreui.min.js');
require('../../node_modules/chart.js/dist/Chart.min');
require('../../node_modules/jquery-ui-dist/jquery-ui.min');
require('../../assets/js/vendors/bootstrap-year-calendar');
require( 'datatables.net' );
require('datatables.net-bs4');
require('jquery-confirm');