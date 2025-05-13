<script setup>
import Container from '../../Components/Container.vue';
import ErrorMessages from '../../Components/ErrorMessages.vue'
import InputField from '../../Components/InputField.vue';
import PrimaryBtn from '../../Components/PrimaryBtn.vue';
import SessionMessage from '../../Components/SessionMessage.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
})

defineProps({
    status: String
})

const submit = () => {
    form.post(route('password.email'))
}
</script>

<template>
    <Head title="- Forgot Password" />
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <p>
                Forgot your password? No problem. Just let us know your email address 
                and we will email you a password reset link that will allow you to choose a new one.
            </p>
        </div>

        <!-- Error messages -->
        <ErrorMessages :errors="form.errors" />
        <SessionMessage :status="status" />

        <form @submit.prevent="submit" class="space-y-8">
            <InputField label="email" v-model="form.email" type="email" icon="at" />
            <PrimaryBtn :disabled="form.processing">Send Password Reset Linnks</PrimaryBtn>
        </form>
    </Container>
</template>