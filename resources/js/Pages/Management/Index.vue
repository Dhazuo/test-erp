<template>
    <div class="p-2 grid grid-cols-1 gap-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div v-for="n in 3" class="rounded bg-white h-32"></div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="bg-white rounded col-span-2 h-64"></div>
            <div class="bg-white rounded h-32"></div>
        </div>
    </div>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout";
export default {
    layout: MainLayout,
    components: {MainLayout},
}
</script>

<style scoped>

</style>
