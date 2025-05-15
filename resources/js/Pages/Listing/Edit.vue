<script setup>
import Container from '../../Components/Container.vue';
import Title from '../../Components/Title.vue';
import InputField from '../../Components/InputField.vue';
import TextArea from '../../Components/TextArea.vue';
import ImageUpload from '../../Components/ImageUpload.vue';
import PrimaryBtn from '../../Components/PrimaryBtn.vue';
import ErrorMessages from '../../Components/ErrorMessages.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    listing: Object
});

const form = useForm({
    title: props.listing.title,
    email: props.listing.email,
    tags: props.listing.tags,
    link: props.listing.link,
    desc: props.listing.desc,
    image: null,
    _method: 'PUT'
})

const submit = () => {
    form.post(route('listing.update', props.listing.id))
}

</script>

<template>
    <Head title="- Create Listing" />
    <Container>
        <Title>Edit Listing</Title>

        <div class="mb-8">
            <ErrorMessages :errors="form.errors" />
            <form @submit.prevent="submit">
                <div class="grid grid-cols-2 gap-4 mb-5">
                    <InputField label="Title" placeholder="My new listing" v-model="form.title" icon="header" />
                    <InputField label="Email" placeholder="example@email.com" icon="at" v-model="form.email" />
                </div>
                <div class="grid grid-cols-2 gap-4 mb-5">
                    <InputField label="Tags (separate with comma)" placeholder="One, two, three" icon="tag" v-model="form.tags" />
                    <InputField label="Link" placeholder="https://example.com" icon="external-link" v-model="form.link" />
                </div>
                <div class="grid grid-cols-2 gap-4 mb-5">
                    <TextArea label="Description" placeholder="Description" icon="newspaper" v-model="form.desc" />
                    <ImageUpload @image="(e) => form.image = e" :listingImage="listing.image" />
                </div>

                <PrimaryBtn :disabled="form.processing">Update</PrimaryBtn>
            </form>
        </div>
    </Container>
</template>