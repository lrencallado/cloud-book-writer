<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';
import DropdownSelect from '@/Components/DropdownSelect.vue';

const props = defineProps({
    genres: {
        type: Array,
        default: [],
    }
});

const dropdownOptions = ref([]);

props.genres.forEach(genre => {
    dropdownOptions.value.push({ label: genre.name, value: genre.id });
});

const form = useForm({
    title: '',
    description: '',
    genres: [],
});

const create = () => {
    form.post(route('books.store'), {
        preserveScroll: true,
        onSuccess: () => closeCreateBookModal(),
        // onError: () => titleInput.value.focus(),
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Create a book" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create a book</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Book Information</h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </p>
                            <form class="mt-6 space-y-6">
                                <div>
                                    <InputLabel for="title" value="Title" />
                                    <TextInput
                                        id="title"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.title"
                                        autofocus
                                    />
                                    <InputError class="mt-2" :message="form.errors.title" />
                                </div>
                                <div>
                                    <InputLabel for="description" value="Description" />
                                    <TextInput
                                        id="description"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.description"
                                        autofocus
                                    />
                                    <InputError class="mt-2" :message="form.errors.description" />
                                </div>
                                <div>
                                    <InputLabel for="genres" value="Genres" />
                                    <DropdownSelect class="mt-1" :options="dropdownOptions" v-model="form.genres"/>
                                    <InputError class="mt-2" :message="form.errors.genres" />
                                </div>
                                <div class="flex items-center gap-4">
                                    <PrimaryButton @click="create" :disabled="form.processing">Save</PrimaryButton>
                                    <Transition
                                        enter-active-class="transition ease-in-out"
                                        enter-from-class="opacity-0"
                                        leave-active-class="transition ease-in-out"
                                        leave-to-class="opacity-0"
                                    >
                                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                                    </Transition>
                                </div>
                            </form>
                        </header>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
