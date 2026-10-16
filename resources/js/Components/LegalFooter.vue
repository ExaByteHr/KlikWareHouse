<script setup>
const year = new Date().getFullYear();
</script>

<template>
    <footer class="text-xs text-text-tertiary">
        <p class="flex flex-wrap items-center gap-x-2 gap-y-1">
            <span>&copy; {{ year }} KlikWareHouse</span>
        </p>
    </footer>
</template>
