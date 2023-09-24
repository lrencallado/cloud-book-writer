<script setup>
import RecursiveSubsection from '@/Components/RecursiveSubsection.vue'

const props = defineProps({
    book: Object,
    section: Object,
    subsections: Array
})
</script>

<template>
    <ul v-for="subsection in props.subsections" class="ml-4">
        <li>
            <a :href="route('book.section.subsection.edit', { book:props.book.id, section: props.section.id, subsection: subsection.id })" :class="route().current('book.section.subsection.edit', { book: book.id, section: section.id, subsection: subsection.id }) ? 'text-blue-600' : '' " class="flex items-center text-gray-800 hover:text-blue-500">
                <svg fill="none" class="w-4" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path>
                </svg>
                {{ subsection.title}}
            </a>
        </li>

        <RecursiveSubsection :book="book" :section="section" :subsections="subsection.child_subsections"/>
    </ul>
</template>
