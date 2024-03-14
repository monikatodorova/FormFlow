<template>
    <div>
        <RegisterForm></RegisterForm>
    </div>
</template>

<script>
import RegisterForm from "@/components/forms/RegisterForm";

export default {
    name: 'RegisterView',
    props: ['token'],
    metaInfo: {
        title: 'Register',
    },
    components: {RegisterForm}
}
</script>

<style>

</style>