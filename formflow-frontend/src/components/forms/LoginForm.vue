<template>
    <form action="#" @submit.prevent="submitForm" method="post" class="form-wrapper">
        <div v-if="!token">
            <h4>Login</h4>
            <p>Please enter your credentials to continue</p>
            <div class="form-group">
                <label>Your Email</label>
                <input type="email" class="form-control" name="email" v-model="email" required>
            </div>
            <div class="form-group">
                <label>Your Password</label>
                <input type="password" class="form-control" name="password" v-model="password" required>
            </div>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="remember" value="1" id="remember" class="custom-control-input">
                <label for="remember" class="custom-control-label">Remember me</label>
            </div>
            <button type="submit"
                    v-bind:class="{'btn': true, 'btn-primary btn-lg mt-3':true, 'disabled': this.checking}"
                    @click="$event.target.blur()">
                <span class="spinner-border" v-show="this.checking"></span>
                <span :class="{'opacity-0': this.checking}">Continue</span>
            </button>
            <div class="alert alert-danger mt-4" v-show="this.error">{{ this.error }}</div>
        </div>
    </form>
</template>

<script>
import repository from "@/repository/repository";

export default {
    name: 'LoginForm',
    props: ['token'],
    data() {
        return {
            email: "",
            password: "",
            checking: false,
            error: null,
        }
    },
    created() {
        // Pre-authenticate user if token is provided
        if(this.token) {
            repository.get("/me", {
                headers: {
                    'Authorization': 'Bearer ' + this.token,
                }
            })
                .then(() => {
                    this.$store.commit("updateUserToken", this.token);
                    this.$router.replace("/");
                })
                .catch(() => {
                    console.log("Couldn't find this account");
                    this.$store.commit("logoutUser");
                    this.$router.replace("/login");
                })
        }
    },
    methods: {
        submitForm() {
            this.startLoading();
            this.error = false;

            repository.post("/login", {
                email: this.email,
                password: this.password,
            })
                .then(response => {
                    console.log(response);
                    this.$store.commit("updateUserToken", response.data.token);
                    this.$router.replace("/");
                })
                .catch(error => {
                    let message = error.response.data.message;
                    this.error = message + " Please try again.";
                    this.endLoading();
                })
        },
        startLoading() {
            this.checking = true;
        },
        endLoading() {
            this.checking = false;
        },
    }
}
</script>

<style>

</style>