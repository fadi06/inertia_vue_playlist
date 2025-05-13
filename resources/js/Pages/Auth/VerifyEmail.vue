<script setup>
import { useForm } from '@inertiajs/vue3';
import Container from '../../Components/Container.vue'
import PrimaryBtn from '../../Components/PrimaryBtn.vue'

const form = useForm({});

const submit = () => {
    
}
</script>

<template>
    <div class="w-1/2">
        <Container>
            <div class="mb-8">
                <p>
                    Thanks for signing up! Before getting started, could you verify
                    your email address by clicking on the link we just emailed to you?
                    If you don't received the email, we will gladely send you another.
                </p>
            </div>

            <form>
                <PrimaryBtn>Resend Verification</PrimaryBtn>
            </form>
        </Container>
    </div>
</template>