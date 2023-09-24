<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
    collaborators: {}
});

const form = useForm({
    status: '',
});

const updateRequest = (status, request) => {
    form.status = status;

    form.patch(route('collaborator-request.update', { collaborator_request: request.id }), {
        preserveScroll: true,
        onSuccess: () => {

        },
    });
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Collaborators</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Requestor</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="collaborator in props.collaborators.data">
                                <td class="px-6 py-4 whitespace-no-wrap">{{ collaborator.requestor_id }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap">{{ collaborator.book_id }}</td>
                                <td v-if="collaborator.status == 'Pending'" class="px-6 py-4 space-x-2 text-center whitespace-no-wrap">
                                    <SecondaryButton @click="updateRequest('Approved', collaborator)">Approve</SecondaryButton>
                                    <DangerButton @click="updateRequest('Disapproved', collaborator)">Disapprove</DangerButton>
                                </td>
                                <td v-if="collaborator.status == 'Approved'" class="px-6 py-4 space-x-2 text-center whitespace-no-wrap">
                                    <SecondaryButton @click="updateRequest('Revoked', collaborator)">Revoke</SecondaryButton>
                                </td>
                                <td v-if="collaborator.status == 'Disapproved'" class="px-6 py-4 space-x-2 text-center whitespace-no-wrap">
                                    <DangerButton>{{ collaborator.status }}</DangerButton>
                                </td>
                                <td v-if="collaborator.status == 'Revoked'" class="px-6 py-4 space-x-2 text-center whitespace-no-wrap">
                                    {{ collaborator.status }}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
