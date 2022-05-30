<template>
    <div class="p-2 grid grid-cols-1 gap-y-8">
        <div class="flex justify-start ">
            <inertia-link :href="route('management.user.index')"
                          class="hover:bg-gray-100 transition duration-200 px-4 py-2 rounded-md shadow-sm border border-gray-200 text-gray-600">
                Regresar
            </inertia-link>

        </div>
        <div class="rounded-md shadow-md border border-gray-200 grid grid-cols-1">
            <div class="p-2 bg-gray-100 text-gray-400 text-2xl border-b border-gray-500">Ficha técnica del usuario</div>
            <div class="p-2 grid grid-cols-1 gap-y-4 text-left text-gray-500 text-sm font-bold">
                <div class="text-lg">Nombre del usuario: {{ user.name }}</div>
                <div>Id del usuario: {{ user.id }}</div>
                <div>Email del usuario: {{ user.email }}</div>
                <div>Rol del usuario: {{ user.role }}</div>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout";

export default {
    layout: MainLayout,

    components: {MainLayout},
    props: ['user'],
    computed: {}

}
</script>

<style scoped>

</style>
