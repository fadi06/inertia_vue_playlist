<script setup>
import Container from '../../../Components/Container.vue';
import Title from '../../../Components/Title.vue';
import InputField from '../../../Components/InputField.vue';
import ErrorMessages from '../../../Components/ErrorMessages.vue';
import SessionMessage from '../../../Components/SessionMessage.vue';
import PrimaryBtn from '../../../Components/PrimaryBtn.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const showDeleteForm = ref(false)

const form = useForm({
    password: ''
})

const submit = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true
    });
}

</script>

<template>
    <Head title="- Profile" />
    <Container class="mb-8">
        <Title>Delete Account</Title>
        <p>Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.</p>

        <ErrorMessages :errors="form.errors" />
        <div v-if="showDeleteForm">
            <form class="flex items-end gap-2" @submit.prevent="submit">
                <InputField name="password" type="password" v-model="form.password" label="New Password" icon="key" class="w-1/2" />
                <PrimaryBtn :disabled="form.processing">Delete</PrimaryBtn>
                <button
                    @click="showDeleteForm = false"
                    class="text-indigo-500 font-medium underline dark:text-indigo-400">Cancel</button>
            </form>
        </div>
        <button
            v-if="!showDeleteForm"
            @click="showDeleteForm = true"
            class="bg-red-500 text-white px-6 py-2 rounded-lg mt-5">
            <i class="fa-solid fa-exclamation-triangle mr-2"></i>
            Delete Account</button>
    </Container>
</template>