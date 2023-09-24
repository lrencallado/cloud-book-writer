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
    book: {},
    sections: {
        type: Array
    },
    current_section: {},
    current_subsection: {},
});

const titleInput = ref(null);
const showModal = ref(false);

const tinyMceApiKey = import.meta.env.VITE_TINY_MCE_API_KEY;

const subsectionForm = useForm({
    title: '',
    parent_subsection_id: props.current_subsection.id
});

const editorForm = useForm({
    content: props.current_subsection.content
});

const createSubsection = () => {
    subsectionForm.post(route('book.section.subsection.store', { book: props.book.id, section: props.current_section.id }), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
        },
        onError: () => titleInput.value.focus(),
        onFinish: () => subsectionForm.reset(),
    });
}

const updateSubsection = () => {
    editorForm.patch(route('book.section.subsection.update',
            {
                book: props.book.id,
                section: props.current_section.id,
                subsection: props.current_subsection.id
            }
        ), {
        preserveScroll: true,
        onSuccess: () => {

        },
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
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{props.book.title}}</h2>
                </div>
                <div>
                    <PrimaryButton @click="showModal = true">Create Subsection</PrimaryButton>
                </div>
            </div>
        </template>
        <div class="md:flex">
            <div class="md:w-[30%] p-4">
                <TreeNavigation :book="props.book" :sections="props.sections"/>
            </div>
            <div class="md:w-[70%] bg-white p-4 grid content-center">
                <!-- Content for the second column -->
                <Editor
                    :api-key="tinyMceApiKey"
                    :init="{
                        plugins: 'lists link image table code help wordcount'
                    }"
                    v-model="editorForm.content"
                />
                <div class="w-4 py-2">
                    <PrimaryButton @click="updateSubsection">Update</PrimaryButton>
                </div>
            </div>
        </div>
        <Modal :show="showModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Create a Subsection
                </h2>
                <div class="mt-6">
                    <InputLabel for="title" value="title" class="sr-only" />

                    <TextInput
                        id="title"
                        ref="titleInput"
                        v-model="subsectionForm.title"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Title"
                        @keyup.enter="createSubsection"
                    />

                    <InputError :message="subsectionForm.errors.title" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <PrimaryButton
                        class="ml-3"
                        :class="{ 'opacity-25': subsectionForm.processing }"
                        :disabled="subsectionForm.processing"
                        @click="createSubsection"
                    >
                        Create
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
