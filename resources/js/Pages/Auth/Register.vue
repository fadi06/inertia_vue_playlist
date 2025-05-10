<script setup>
import Container from '../../Components/Container.vue';
import Title from '../../Components/Title.vue';
import TextLink from '../../Components/TextLink.vue';
import InputField from '../../Components/InputField.vue';
import PrimaryBtn from '../../Components/PrimaryBtn.vue';
import ErrorMessages from '../../Components/ErrorMessages.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
});

const submit = () => {
    form.post(route('registerUser'), {
        onFinish: () => form.reset('password', 'password_confirmation')
    });
}
</script>

<template>
    <Head title="- Register" />
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <Title>Register a new account</Title>
            <p>Already have an account? <TextLink routeName="login" label="Login" /></p>

        </div>

        <!-- Error messages -->
        <ErrorMessages :errors="form.errors" />
        <form @submit.prevent="submit" class="space-y-8">
            <InputField label="Name" v-model="form.name" icon="id-badge" />
            <InputField label="Email" v-model="form.email" type="email" icon="at" />
            <InputField label="Password" v-model="form.password" type="password" icon="key" />
            <InputField label="Confirm Password" v-model="form.password_confirmation" type="password" icon="key" />

            <PrimaryBtn :disabled="form.processing">Register</PrimaryBtn>
        </form>
    </Container>
</template>