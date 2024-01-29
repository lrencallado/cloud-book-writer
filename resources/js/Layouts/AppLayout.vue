<script setup>
import SidebarNavigation from '@/Components/SidebarNavigation.vue';
import TopNavigation from '@/Components/TopNavigation.vue';

</script>

<template>
    <div>
        <div class="sticky top-0 z-10">
            <TopNavigation/>
        </div>
        <div class="flex">
            <div class="sticky top-0 w-[300px] pt-4 pb-4 px-4 py-4 min-h-screen border-r border-gray-100">
                <SidebarNavigation/>
            </div>
            <!-- Page Content -->
            <main class="w-full px-10 py-10">
                <slot />
            </main>
            <div class="sticky top-0 w-[500px]">

            </div>
        </div>
    </div>
</template>
