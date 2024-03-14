<template>
    <div>
        <LoginForm></LoginForm>
    </div>
</template>

<script>
import LoginForm from "@/components/forms/LoginForm";

export default {
    name: 'LoginView',
    props: ['token'],
    metaInfo: {
        title: 'Login',
    },
    components: {LoginForm}
}
</script>

<style>

</style>