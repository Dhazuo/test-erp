<template>

    <div class="p-2 grid grid-cols-1 gap-y-8">
        <div class="flex justify-start ">
            <inertia-link :href="route('management.sales.index')"
                          class="hover:bg-gray-100 bg-white transition duration-200 px-4 py-2 rounded-md shadow-sm border border-gray-200 text-gray-600">
                Regresar
            </inertia-link>

        </div>
        <div class="rounded-md shadow-md border border-gray-200 grid grid-cols-1 bg-white">
            <div class="p-2 bg-gray-100 text-gray-400 text-2xl border-b border-gray-500">Ficha técnica de la
                venta
            </div>
            <div class="p-2 grid grid-cols-1 gap-y-4 text-left text-gray-500 text-sm font-bold">
                <div class="text-lg">Token de la venta: {{ sale.token }}</div>
                <div>Nombre del vendedor:
                    <inertia-link :href="route('management.user.show', sale.seller_id)"
                                  class="text-blue-500 underline">{{ sale.seller_name }}
                    </inertia-link>
                </div>
                <div>
                    <div>Productos comprados:</div>
                    <ul class="font-bold list-disc list-inside">
                        <li v-for="product in products_related">
                            <inertia-link class="text-blue-500"
                                          :href="route('management.product.show', product)">{{ product.name }}
                            </inertia-link>
                            . Cantidad: {{ product.pivot.total_stock }}

                        </li>
                    </ul>
                </div>
                <div>Comprador: {{ sale.customer }}</div>
                <div>Stock total: {{ sale.total_stock }}</div>
                <div>Precio total: ${{ sale.total_price }}</div>
                <div class="font-bold">Fecha de creación: {{ sale.created_at }}</div>
            </div>
        </div>
    </div>

</template>

<script>
import MainLayout from "@/Layouts/MainLayout";

export default {
    layout: MainLayout,
    components: {MainLayout},
    props: ['sale', 'products_related'],
    computed: {},
    mounted() {
    }

}
</script>

<style scoped>

</style>
