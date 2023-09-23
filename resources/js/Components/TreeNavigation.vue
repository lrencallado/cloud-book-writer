<script setup>
import { computed, ref } from 'vue';

defineProps({
    book: {},
    sections: {
        type: Array
    },
})

const showSections = ref(true);

const toggleChildNodes = () => {
    showSections.value = !showSections.value;
};

const buttonText = computed(() => (showChildNodes.value ? 'Hide Child Nodes' : 'Show Child Nodes'));

</script>

<template>
    <div class="p-4">
        <ul>
            <li>
                <a :href="route('book.show', { book:book.id })" class="flex items-center text-gray-800 hover:text-blue-500">
                    <svg fill="none" class="w-4" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"></path>
                    </svg>
                    {{ book.title}}
                </a>
            </li>
            <li>
                <ul class="space-y-2 ml-4">
                    <li>
                        <button
                            class="flex items-center text-gray-800 hover:text-blue-500"
                            @click="toggleChildNodes()"
                        >
                            <svg fill="none" class="w-4" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"></path>
                            </svg>
                            <span id="toggleText">Sections</span>
                        </button>
                        <ul v-show="showSections" v-for="section in sections" class="ml-4 space-y-2">
                            <li>
                                <a :href="route('book.section.edit', { book:book.id, section: section.id })" class="flex items-center text-gray-800 hover:text-blue-500">
                                    <svg fill="none" class="w-4" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path>
                                    </svg>
                                    {{ section.title}}
                                </a>
                                <ul v-for="subsection in section.sub_sections" class="space-y-2 ml-4">
                                    <li>
                                        <a :href="route('book.section.subsection.edit', { book:book.id, section: section.id, subsection: subsection.id })" class="flex items-center text-gray-800 hover:text-blue-500">
                                            <svg fill="none" class="w-4" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path>
                                            </svg>
                                            {{ subsection.title}}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</template>
