<template>
    <form action="#" @submit.prevent="submitForm" method="post" class="form-wrapper">
        <div v-if="!token">
            <h4>Login</h4>
            <p>Please enter your credentials to continue</p>
            <div class="form-group">
                <label>Your Name</label>
                <input type="text" class="form-control" name="name" v-model="name" required>
            </div>
            <div class="form-group">
                <label>Your Email</label>
                <input type="email" class="form-control" name="email" v-model="email" required>
            </div>
            <div class="form-group">
                <label>Your Password</label>
                <input type="password" class="form-control" name="password" v-model="password" required>
            </div>
            <div class="form-group">
                <label>Repeat Password</label>
                <input type="password" class="form-control" name="repeatedPassword" v-model="repeatedPassword" required>
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
    name: 'RegisterForm',
    props: ['token'],
    data() {
        return {
            name: "",
            email: "",
            password: "",
            repeatedPassword: "",
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

            if(this.password !== this.repeatedPassword) {
                this.error = "Passwords do not match. Please try again.";
                return;
            }

            repository.post("/register", {
                name: this.name,
                email: this.email,
                password: this.password,
            })
                .then(response => {
                    console.log(response);
                    // this.$store.commit("updateUserToken", response.data.token);
                    this.$router.replace("/login");
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