<template>
    <div>
        <h4 class="text-center">All Payments</h4><br/>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="payment in payments" :key="payments.id">
                <td>{{ payment.id }}</td>
                <td>{{ payment.description }}</td>
                <td>{{ payment.amount }}</td>
                <td>{{ payment.created_at }}</td>
                <td>{{ payment.updated_at }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'editpayment', params: { id: payment.id }}" class="btn btn-primary">Edit
                        </router-link>
                        <button class="btn btn-danger" @click="deletePayment(payment.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            payments: []
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/users/${this.$route.params.id}/history`)
                .then(response => {
                    console.log(response.data);
                    this.payments = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        deletePayment(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete(`/api/payments/delete/${id}`)
                    .then(response => {
                        let i = this.payments.map(item => item.id).indexOf(id); // find index of your object
                        this.payments.splice(i, 1)
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
