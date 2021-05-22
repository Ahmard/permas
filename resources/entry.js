window.Vue = require('vue');
window.$ = window.jQuery = require("jquery");
window.axios = require('axios');
window.swal = require('sweetalert');

import 'notyf/notyf.min.css';
import "/public/assets/mdb/css/mdb.min.css"

window.bsCustomFileInput = require('/public/assets/mdb/js/modules/bs-custom-file-input');

require("bootstrap/dist/js/bootstrap.bundle.min")
require("/public/assets/mdb/js/mdb.min")


//CSS
require("bootstrap/dist/css/bootstrap.min.css");
require("@fortawesome/fontawesome-free/css/all.min.css");

window.displayFormError = function (_this, response, showError = true) {
    let data = response.data;
    if ('string' === typeof data) {
        swal('Account', data, 'error');

        return;
    }

    if (data) {
        for (const inputName in _this.user) {
            if (!data.hasOwnProperty(inputName)) {
                _this.$refs[`${inputName}-error`].innerHTML = null;
                _this.inputState[inputName] = null;
            }
        }

        for (const responseKey in data) {
            if (
                data.hasOwnProperty(responseKey)
                && _this.inputState.hasOwnProperty(responseKey)
            ) {
                if (showError) {
                    _this.$refs[`${responseKey}-error`].innerHTML = data[responseKey][0];
                    _this.inputState[responseKey] = 'is-invalid';
                }
            }
        }
    }
}
