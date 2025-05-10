<script setup>
import Container from '../../Components/Container.vue';
import Title from '../../Components/Title.vue';
import ErrorMessages from '../../Components/ErrorMessages.vue'
import InputField from '../../Components/InputField.vue';
import PrimaryBtn from '../../Components/PrimaryBtn.vue';
import TextLink from '../../Components/TextLink.vue';
import Checkbox from '../../Components/Checkbox.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: null
})

const submit = () => {
    form.post(route('loginUser'), {
        onFinish: () => form.reset()
    })
}
</script>

<template>
    <Head title="- Login" />
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <Title>Login your account</Title>
            <p>Want to create new accout? <TextLink routeName="register" label="register" /></p>

        </div>

        <!-- Error messages -->
        <ErrorMessages :errors="form.errors" />

        <form @submit.prevent="submit" class="space-y-8">
            <InputField label="Emairoutel" v-model="form.email" type="email" icon="at" />
            <InputField label="Password" v-model="form.password" type="password" icon="key" />

            <div class="flex items-center justify-between">
                <Checkbox name="remember" v-model="form.remember"> Remember me </Checkbox>
                <TextLink routeName="home" label="Forgot password?" />
            </div>
            <PrimaryBtn :disabled="form.processing">Login</PrimaryBtn>
        </form>
    </Container>
</template>