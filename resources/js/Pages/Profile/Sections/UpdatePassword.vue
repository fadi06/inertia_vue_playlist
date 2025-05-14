<script setup>
import Container from '../../../Components/Container.vue';
import Title from '../../../Components/Title.vue';
import InputField from '../../../Components/InputField.vue';
import ErrorMessages from '../../../Components/ErrorMessages.vue';
import SessionMessage from '../../../Components/SessionMessage.vue';
import PrimaryBtn from '../../../Components/PrimaryBtn.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: ''
})

const submit = () => {
    form.put(route('profile.password'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => form.reset()
    });
}

</script>

<template>
    <Head title="- Profile" />
    <Container class="mb-8">
        <Title>Update Password</Title>
        <p>Ensure your are using a long, random password to stay secure.</p>

        <ErrorMessages :errors="form.errors" />
        <form class="space-y-6" @submit.prevent="submit">
            <InputField name="current_password" type="password" v-model="form.current_password" label="Current Password" icon="key" class="w-1/2" />
            <InputField name="password" type="password" v-model="form.password" label="New Password" icon="key" class="w-1/2" />
            <InputField name="password_confirmation" type="password" v-model="form.password_confirmation" label="Confirm New Password" icon="key" class="w-1/2" />

            <p v-if="form.recentlySuccessful" class="text-green-500">Saved!</p>

            <PrimaryBtn :disabled="form.processing">Change Password</PrimaryBtn>
        </form>
    </Container>
</template>