<script setup>
import Container from '../../Components/Container.vue';
import Title from '../../Components/Title.vue';
import ErrorMessages from '../../Components/ErrorMessages.vue'
import SessionMessage from '../../Components/SessionMessage.vue'
import InputField from '../../Components/InputField.vue';
import PrimaryBtn from '../../Components/PrimaryBtn.vue';
import TextLink from '../../Components/TextLink.vue';
import Checkbox from '../../Components/Checkbox.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    password: ''
})

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset()
    })
}
</script>

<template>
    <Head title="- Confirm Password" />
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <p>This is a secue area of the application, Please confirm your password before countinuing.ß</p>
        </div>

        <!-- Error messages -->
        <ErrorMessages :errors="form.errors" />

        <form @submit.prevent="submit" class="space-y-8">
            <InputField label="Password" v-model="form.password" type="password" icon="key" />
            <PrimaryBtn :disabled="form.processing">Comfirm</PrimaryBtn>
        </form>
    </Container>
</template>