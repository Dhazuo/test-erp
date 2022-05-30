<template>

    <div class="p-2">
        <div class="flex justify-end mb-4">
            <inertia-link :href="route('management.product.create')"
                          class="px-4 py-2 rounded-md shadow-md bg-blue-500 text-white">Crear
            </inertia-link>
        </div>
        <div class="rounded-md shadow-md w-full border border-gray-200">
            <table class="table-auto rounded-md w-full">
                <thead>
                <tr class="text-gray-400">
                    <th class="p-2 bg-gray-100 text-left">Nombre del producto</th>
                    <th class="p-2 bg-gray-100">Precio del producto</th>
                    <th class="p-2 bg-gray-100">Stock del producto</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in products.data" class="text-gray-500">
                    <td class="p-2">
                        {{ product.name }}
                    </td>
                    <td class="p-2 text-center">
                        ${{ product.price }}
                    </td>
                    <td class="p-2 text-center font-bold">
                        {{ product.actual_stock }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-center">
            <pagination-component :links="products.links"></pagination-component>
        </div>
    </div>

</template>

<script>
import MainLayout from "@/Layouts/MainLayout";
import PaginationComponent from "@/Components/PaginationComponent";

export default {
    layout: MainLayout,
    props: ['products'],
    data() {
        return {}
    },
    components: {PaginationComponent, MainLayout},
}
</script>

<style scoped>

</style>
