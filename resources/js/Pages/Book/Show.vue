<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { computed, ref } from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TreeNavigation from '@/Components/TreeNavigation.vue';
import Editor from '@tinymce/tinymce-vue'

const props = defineProps({
    book: {
        type: Object
    },
    sections: {
        type: Array
    }
});

const titleInput = ref(null);
const showModal = ref(false);

const form = useForm({
    title: ''
});

const createSection = () => {
    form.post(route('book.section.store', { book: props.book.id }), {
        preserveScroll: true,
        onSuccess: (data) => {
            closeModal();
        },
        onError: () => titleInput.value.focus(),
        onFinish: () => form.reset(),
    });
}

const closeModal = () => {
    showModal.value = false;
}

</script>

<template>
    <Head :title="'Viewing ' + book.title "/>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{props.book.title}} Book</h2>
                </div>
                <div>
                    <PrimaryButton @click="showModal = true">Create Section</PrimaryButton>
                </div>
            </div>
        </template>
        <div class="md:flex">
            <div class="md:w-[30%] p-4">
                <TreeNavigation :book="props.book" :sections="props.sections"/>
            </div>
            <div class="md:w-[70%] bg-white p-4 grid content-center">
                <!-- Content for the second column -->
                <small class="text-center">No section/subsection selected.</small>
                <!-- <Editor
                    api-key="bzxbb2elsezrdwy7536kcb2rd609de6551hz2opwpxyzg0x7"
                    :init="{
                        plugins: 'lists link image table code help wordcount'
                    }"
                /> -->
            </div>
        </div>
        <Modal :show="showModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Create a section
                </h2>
                <div class="mt-6">
                    <InputLabel for="title" value="title" class="sr-only" />

                    <TextInput
                        id="title"
                        ref="titleInput"
                        v-model="form.title"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Title"
                        @keyup.enter="createSection"
                    />

                    <InputError :message="form.errors.title" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <PrimaryButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="createSection"
                    >
                        Create
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
