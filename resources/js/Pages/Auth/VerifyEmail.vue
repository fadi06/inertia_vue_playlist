<script setup>
import { useForm } from '@inertiajs/vue3';
import Container from '../../Components/Container.vue'
import PrimaryBtn from '../../Components/PrimaryBtn.vue'
import SessionMessage from '../../Components/SessionMessage.vue'

const form = useForm({});

defineProps({
    status: String
})
const submit = () => {
    form.post(route('verification.send'));
}
</script>

<template>
    <Head title="- Verify Verification" />
    <Container class="w-1/2">
            <div class="mb-8">
                <p>
                    Thanks for signing up! Before getting started, could you verify
                    your email address by clicking on the link we just emailed to you?
                    If you don't received the email, we will gladely send you another.
                </p>
            </div>
            <SessionMessage :status="status" />
            <form @submit.prevent="submit">
                <PrimaryBtn :disabled="form.processing">Resend Verification</PrimaryBtn>
            </form>
        </Container>
</template>