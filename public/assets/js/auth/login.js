const app = Vue.createApp({
    data() {
        return {
            user: {
                username: null,
                password: null
            },
            inputState: {
                username: '',
                password: ''
            }
        }
    },
    methods: {
        login(event) {
            let _this = this;
            axios.post('/api/users/login', this.user, {
                'Content-Type': 'application/json'
            })
                .then(function (response) {
                    response = response.data;
                    console.log(response)

                    if (response.success) {
                        swal('Account', response.data.message, 'success');
                    } else {
                        displayFormError(_this, response);
                    }
                })
                .catch(function (error) {
                    console.log(error)
                    displayFormError(_this, error);
                })
        }
    }
});
const vm = app.mount('#app');