Vue.createApp({
    data() {
        return {
            user: {
                username: null,
                email: null,
                password: null
            },
            inputState: {
                username: '',
                email: '',
                password: ''
            }
        }
    },
    methods: {
        submitForm() {
            let _this = this;
            axios.post('/api/users/signup', this.user, {
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
}).mount('#contents');
