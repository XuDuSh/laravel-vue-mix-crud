<template>
    <div>
        <h4 class="text-center">Add Payment</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addPayment">
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" v-model="payment.description">
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="text" class="form-control" v-model="payment.amount">
                    </div>
                    <div class="form-group">
                        <label>User ID</label>
                        <select class="form-control" v-model="payment.user_id">
                            <option v-for="user in users" v-bind:value="user.id">{{user.name}}</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Payment</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            payment: {},
            users: []
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/users/get`)
                .then(response => {
                    this.users = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        addPayment() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/payments/add', this.payment)
                    .then(response => {
                        this.$router.push({name: 'payments'})
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
