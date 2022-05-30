<template>
    <div class="p-2 grid grid-cols-1 gap-y-8">
        <div class="flex justify-start ">
            <inertia-link :href="route('management.product.index')"
                          class="hover:bg-gray-100 transition duration-200 px-4 py-2 rounded-md shadow-sm border border-gray-200 text-gray-600">
                Regresar
            </inertia-link>

        </div>
        <div class="rounded-md shadow-md border border-gray-200 grid grid-cols-1">
            <div class="p-2 bg-gray-100 text-gray-400 text-2xl border-b border-gray-500">Ficha técnica del producto
            </div>
            <div class="p-2 grid grid-cols-1 gap-y-4 text-left text-gray-500 text-sm font-bold">
                <div class="text-lg">Nombre del product: {{ product.name }}</div>
                <div>Id del producto: {{ product.id }}</div>
                <div>Precio del producto: ${{ product.price }}</div>
                <div>Stock original del producto: {{ product.original_stock }}</div>
                <div>Stock actual del producto: {{ product.actual_stock }}</div>
                <div class="font-bold text-green-500">Ventas totales del producto: {{ total_sales }}</div>
                <div class="font-bold text-green-500">Ganancias totales (IVA 16%): ${{ total_gains }}</div>

            </div>
        </div>
    </div>

</template>

<script>
import MainLayout from "../../Layouts/MainLayout";

export default {
    layout: MainLayout,
    components: {MainLayout},
    props: ['product', 'total_sales', 'total_gains'],
    computed: {}

}
</script>

<style scoped>

</style>
