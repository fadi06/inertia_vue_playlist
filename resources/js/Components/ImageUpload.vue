<script setup>
import { ref } from 'vue';

const props = defineProps({
    listingImage: String
})
const currentImage = props.listingImage ? `/storage/${props.listingImage}` : null;

const preview = ref(currentImage)
const imageUploadSizeExceed = ref(false)
const showOriginalImage = ref(false)

const emit = defineEmits(['image'])

const uploadImage = (e) => {
    preview.value = URL.createObjectURL(e.target.files[0]);
    imageUploadSizeExceed.value = e.target.files[0].size > 3145728;
    showOriginalImage.value = true;
    emit('image', e.target.files[0]);
}

const revertImage = () => {
    preview.value = currentImage;
    showOriginalImage.value = false;
    imageUploadSizeExceed.value = false;
    emit('image', null);
}

</script>

<template>
    <div>
        <span
            class="block text-sm font-medium text-slate-700 dark:text-slate-300"
            :class="{
                '!text-red-500' : imageUploadSizeExceed
            }">
            {{ imageUploadSizeExceed ? 'Image size exceeds 3MB' : 'Image (Max size 3MB)' }} 
        </span>

        <label for="image" 
            class="relative block rounded-md mt-1 bg-red-300 h-36 overflow-hidden cursor-pointer border-slate-300 border"
        >
            <img :src="preview ?? '/storage/images/listings/default.png'" class="w-full h-full object-cover object-center" />
            <button
                type="button"
                v-if="showOriginalImage"
                @click.prevent="revertImage"
                class="absolute top-2 right-2 bg-white/75 w-8 h-8 rounded-full grid place-items-center text-slate-700">
                <i class="fa-solid fa-rotate-left"></i>
            </button>
        </label>

        <input @input="uploadImage" type="file" name="image" id="image" hidden />
    </div>
</template>