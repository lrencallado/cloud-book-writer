<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref } from 'vue';

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    books: {
        type: Object
    }
});

const checkRequest = (userId, bookId, bookIndex, requests) => {
    let isExisting = false;
    let userRequest = {};

    requests.forEach(request => {
        if (request.requestor_id == userId && request.book_id == bookId) {
            isExisting =  true;
            userRequest.value = request;
            //userRequests.value.splice(bookIndex, 0, request);
            return;
        }
    });

    return { has_request: isExisting, request: userRequest };
}

const getAuthor = (collaborators) => {
    let author = {};

    collaborators.forEach(collaborator => {
        if (collaborator.pivot.role == 'Author') {
            author = collaborator;

            return
        }
    });

    return author;
}
</script>

<template>
    <Head title="Home"/>
    <AppLayout>
        <div v-for="(book, index) in props.books.data">
            <div v-if="$page.props.auth.user">
                <div v-if="currentRequest = checkRequest($page.props.auth.user.id, book.id, index, book.all_collaborator_requests)">
                    <div
                        class="scale-100 p-6 mb-4 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] hover:border-2 hover:border-red-500 transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
                    >
                        <a :href="route('books.show', { book: book.id })">
                            <div
                                class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    class="w-7 h-7 stroke-red-500"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"
                                    />
                                </svg>
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{ book.title }}</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi. Proin ac purus eu justo viverra scelerisque. Sed nec arcu eu odio condimentum posuere. Vivamus nec eleifend nulla. In cursus, turpis nec condimentum pellentesque, lectus ex dignissim odio, a semper sapien felis in justo. Vestibulum volutpat euismod justo, ac tincidunt justo tempus nec. Phasellus sagittis nisi vel velit rhoncus, id fringilla urna luctus.
                            </p>
                        </a>
                        <div v-if="!currentRequest.has_request">
                            <PrimaryButton v-if="$page.props.auth.user && $page.props.auth.user.id != getAuthor(book.collaborators).id " class="w-36 mx-auto mt-2" @click="openCollaboratorRequestModal(book.id)">Ask to collab</PrimaryButton>
                            <SecondaryButton v-else class="w-auto mx-auto mt-2">Author</SecondaryButton>
                        </div>
                        <div v-else>
                            <span class="mt-2 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ currentRequest.request.value.status == 'Approved' ? 'Collaborator' : currentRequest.request.value.status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <div>
                    <div
                        class="scale-100 p-6 mb-4 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] hover:border-2 hover:border-red-500 transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
                    >
                        <a>
                            <div
                                class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    class="w-7 h-7 stroke-red-500"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"
                                    />
                                </svg>
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{ book.title }}</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi. Proin ac purus eu justo viverra scelerisque. Sed nec arcu eu odio condimentum posuere. Vivamus nec eleifend nulla. In cursus, turpis nec condimentum pellentesque, lectus ex dignissim odio, a semper sapien felis in justo. Vestibulum volutpat euismod justo, ac tincidunt justo tempus nec. Phasellus sagittis nisi vel velit rhoncus, id fringilla urna luctus.
                            </p>
                            <div class="mt-2 py-2 px-1 flex align-middle gap-x-3">
                                <div class="bg-gray-100 py-2 px-2 flex align-middle rounded-full">
                                    <button class="text-center flex">
                                        <svg class="h-4 w-4" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m15 11.25-3-3m0 0-3 3m3-3v7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                                        </svg>
                                        <span class="text-xs mx-1">11k</span>
                                    </button>
                                    <button class="text-center">
                                        <svg class="h-4 w-4" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="bg-gray-100 py-2 px-2 flex align-middle rounded-full">
                                    <button class="text-center flex">
                                        <svg class="w-4" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443 48.282 48.282 0 0 0 5.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"></path>
                                        </svg>
                                        <span class="text-xs mx-1">2.5k</span>
                                    </button>
                                </div>
                                <div class="bg-gray-100 py-2 px-2 flex align-middle rounded-full">
                                    <button class="text-center flex">
                                        <svg class="w-4" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z"></path>
                                        </svg>
                                        <span class="text-xs mx-1">3k Shares</span>
                                    </button>
                                </div>
                            </div>
                        </a>
                        <div>
                            <PrimaryButton class="w-36 mx-auto mt-2" @click="openCollaboratorRequestModal(book.id)">Ask to collab</PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
