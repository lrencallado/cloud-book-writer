<script setup>
import { ref, computed, onMounted, onUnmounted} from 'vue';

const props = defineProps({
    options: {
        type: Array,
        default: [],
    },
    modelValue: {
        type: Array,
        required: true,
    },
    placeholder: {
        type: String,
        default: 'Search...'
    }
});

const open = ref(false);
const selectedOptions = ref(props.modelValue);
const searchText = ref('');

// Filter options based on search text
const filteredOptions = computed(() => {
    return props.options.filter(option =>
    option.label.toLowerCase().includes(searchText.value.toLowerCase())
    );
});

// Toggle the dropdown
const toggleDropdown = () => {
    open.value = !open.value;
};

// Filter options based on search text
const filterOptions = () => {
    open.value = true;
};

const dropdown = ref(false);

const emit = defineEmits();

const emitSelectedOptions = () => {
    emit('update:modelValue', selectedOptions.value);
};

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

// const closeDropdownOnOutsideClick = (event) => {
//     if (open.value && !dropdown.value.contains(event.target)) {
//         open.value = false;
//     }
// };

onMounted(() => {
    document.addEventListener('keydown', closeOnEscape);
    // window.addEventListener('click', closeDropdownOnOutsideClick);
});
onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    // window.removeEventListener('click', closeDropdownOnOutsideClick);
});

</script>

<template>
    <div class="relative">
        <input
            v-model="searchText"
            @input="filterOptions"
            class="border rounded-md p-2 w-full"
            type="text"
            :placeholder="props.placeholder"
        />
        <!-- Up Arrow SVG Icon -->
        <svg
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
            class="absolute right-3 top-3 h-4 w-4 text-gray-600 cursor-pointer"
            @click="toggleDropdown"
        >
            <path
                clip-rule="evenodd"
                fill-rule="evenodd"
                d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z"
            ></path>
        </svg>
        <div
            class="absolute z-10 mt-2 py-2 w-full bg-white border border-gray-300 rounded-md shadow-lg"
            v-show="open"
        >
            <ul class="px-2">
                <li
                v-for="option in filteredOptions"
                :key="option.value"
                class="hover:bg-gray-50"
                >
                    <label class="flex items-center space-x-2">
                        <input
                            class="rounded"
                            type="checkbox"
                            :value="option.value"
                            v-model="selectedOptions"
                            @change="emitSelectedOptions"
                        />
                        <span>{{ option.label }}</span>
                    </label>
                </li>
            </ul>
        </div>
    </div>
</template>
