<template>

    <div class="p-2 grid grid-cols-1 gap-y-8">
        <div class="flex justify-start ">
            <inertia-link :href="route('management.sales.pending_to_delete.index')"
                          class="hover:bg-gray-100 bg-white transition duration-200 px-4 py-2 rounded-md shadow-sm border border-gray-200 text-gray-600">
                Regresar
            </inertia-link>

        </div>
        <div class="rounded-md shadow-md border border-gray-200 grid grid-cols-1">
            <div class="p-2 bg-gray-100 text-gray-400 text-2xl border-b border-gray-500">Ficha técnica de la petición.
            </div>
            <div class="p-2 bg-white grid grid-cols-1 gap-y-4 text-left text-gray-500 text-sm font-bold">
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
        <div class="w-full flex justify-center items-center space-x-2">
            <button @click="reject" class="px-4 py-2 bg-white border border-gray-200 shadow-sm rounded-md hover:bg-gray-50 transition duration-200">Rechazar petición</button>
            <button @click="advice()" class="px-4 py-2 bg-red-500 text-white shadow-sm rounded-md hover:bg-red-600 transition duration-200">Eliminar</button>
        </div>
    </div>
    <div v-if="deleting" class="fixed z-50  left-0 w-full h-full top-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div v-if="!confirm_delete" class="w-2/4  rounded-md bg-white p-4 grid grid-cols-1 gap-y-4">
            <div class="text-2xl font-bold text-center">¿Deseas eliminar la venta {{ sale.token }}?</div>
            <div class="font-bold text-center">Este proceso es irreversible</div>
            <div class="flex justify-center items-center space-x-2">
                <button @click="deleting = false, errors ? errors = null : errors"
                        class="rounded-md shadow-md bg-blue-500 hover:bg-blue-600 transition duration-200 text-white px-4 py-2">
                    Cancelar
                </button>
                <button @click="confirmDelete()"
                        class="rounded-md shadow-md bg-red-500 hover:bg-red-600 transition duration-200 text-white px-4 py-2">
                    Eliminar
                </button>
            </div>
        </div>
        <div v-else class="w-2/4 rounded-md bg-white p-4 grid grid-cols-1 gap-y-4">
            <div class="text-2xl font-bold text-center">Ingresa tu contraseña para confirmar:</div>
            <div class="grid grid-cols-1">
                <input v-model="password" type="password"
                       class="text-center rounded-md shadow-sm border border-gray-200 w-full">
                <div v-if="errors" class="text-red-500 text-center">{{ errors }}</div>

            </div>
            <div class="flex justify-center items-center space-x-2">
                <button @click="deleting = false, confirm_delete = false, errors = null"
                        class="rounded-md shadow-md bg-blue-500 hover:bg-blue-600 transition duration-200 text-white px-4 py-2">
                    Cancelar
                </button>
                <button @click="deleteSale"
                        class="rounded-md shadow-md bg-green-500 hover:bg-green-600 transition duration-200 text-white px-4 py-2">
                    Confirmar
                </button>
            </div>
        </div>
    </div>

</template>

<script>
import MainLayout from "@/Layouts/MainLayout";

export default {
    layout: MainLayout,
    components: {MainLayout},
    props: ['sale', 'find', 'products_related'],
    data(){
        return {
            deleting: false,
            confirm_delete: false,

        }
    },
    methods: {
        advice() {
            this.deleting = true
        },
        confirmDelete() {
            this.confirm_delete = true

        },
        deleteSale() {
            axios.post(this.route('management.confirm_password'), {
                password: this.password
            })
                .then(response => {
                    axios.post(this.route('management.sales.pending_to_delete.destroy'), {
                        sale_token: this.sale.token
                    })
                        .then(() => {
                            this.errors = null
                            window.location = this.route('management.sales.pending_to_delete.index')
                        })
                        .catch(() => {
                            window.location = this.route('management.sales.pending_to_delete.index')
                        })
                })
                .catch(err => {
                    this.errors = err.response.data.error
                })
        },
        reject(){
            axios.post(this.route('management.sales.pending_to_delete.reject'), {
                sale_token: this.sale.token
            })
                .then(() => {
                    window.location = this.route('management.sales.pending_to_delete.index')
                })
        }
    }


}
</script>

<style scoped>

</style>
