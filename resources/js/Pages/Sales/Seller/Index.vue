<template>
    <div class="p-2">
        <div class="flex justify-end mb-4">
            <inertia-link :href="route('management.sales.create')"
                          class="px-4 py-2 rounded-md shadow-md bg-blue-500 text-white">Crear
            </inertia-link>
        </div>
        <div v-if="seller_sales" class="rounded-md shadow-md w-full border border-gray-200 bg-white">
            <table class="table-auto rounded-md w-full">
                <thead>
                <tr class="text-gray-400">
                    <th class="p-2 bg-gray-100 text-left">Token</th>
                    <th class="p-2 bg-gray-100">Comprador</th>
                    <th class="p-2 bg-gray-100">Producto</th>
                    <th class="p-2 bg-gray-100">Stock total</th>
                    <th class="p-2 bg-gray-100">Precio final</th>
                    <th class="p-2 bg-gray-100">Creación</th>
                    <th class="p-2 bg-gray-100">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="sale in seller_sales.data" class="text-gray-500">
                    <td class="p-2">
                        <inertia-link :href="route('management.sales.show', sale.id)" class="text-blue-500">
                            {{ sale.token }}
                        </inertia-link>
                    </td>
                    <td class="p-2 text-center">
                        {{ sale.customer }}
                    </td>
                    <td class="p-2 text-center">
                        {{ sale.product_name }}
                    </td>
                    <td class="p-2 text-center">
                        {{ sale.total_stock }}
                    </td>
                    <td class="p-2 text-center">
                        ${{ sale.total_price }}
                    </td>
                    <td class="p-2 text-center">
                        {{ sale.created_at }}
                    </td>
                    <td class="flex justify-center">
                        <div class="p-2 grid grid-cols-2 gap-x-1">
                            <div>
                                <inertia-link :href="route('management.sales.edit', sale.id)" class="text-green-500">
                                    Editar
                                </inertia-link>
                            </div>
                            <div>
                                <button @click="advice(sale)" class="text-red-500">Eliminar</button>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div v-else class="text-4xl text-center">
            Parece que aún no hay ventas :(
        </div>
        <div v-if="seller_sales" class="mt-6 flex justify-center">
            <pagination-component :links="seller_sales.links"></pagination-component>
        </div>
    </div>
    <div v-if="deleting == 'to_delete'" class="fixed z-50 w-full h-full left-0 top-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div v-if="!confirm_delete" class="w-2/4 rounded-md bg-white p-4 grid grid-cols-1 gap-y-4">
            <div class="text-2xl font-bold text-center">¿Deseas eliminar la venta {{ sale.name }}?</div>
            <div class="font-bold text-center">Este proceso es irreversible</div>
            <div class="flex justify-center items-center space-x-2">
                <button @click="deleting = null, errors ? errors = null : errors"
                        class="rounded-md shadow-md bg-blue-500 hover:bg-blue-600 transition duration-200 text-white px-4 py-2">
                    Cancelar
                </button>
                <button @click="confirmDelete()"
                        class="rounded-md shadow-md bg-red-500 hover:bg-red-600 transition duration-200 text-white px-4 py-2">
                    Eliminar
                </button>
            </div>
        </div>
        <div v-else class="w-2/4 rounded-md bg-white p-4 text-center">
            <div v-if="!response_message" class="grid grid-cols-1 gap-y-4">
                <div class="text-2xl font-bold text-center">Ingresa tu contraseña para confirmar:</div>
                <div class="grid grid-cols-1">
                    <input v-model="password" type="password"
                           class="text-center rounded-md shadow-sm border border-gray-200 w-full">
                    <div v-if="errors" class="text-red-500 text-center">{{ errors }}</div>

                </div>
                <div class="flex justify-center items-center space-x-2">
                    <button @click="deleting = null, confirm_delete = false, errors = null"
                            class="rounded-md shadow-md bg-blue-500 hover:bg-blue-600 transition duration-200 text-white px-4 py-2">
                        Cancelar
                    </button>
                    <button @click="deleteProduct"
                            class="rounded-md shadow-md bg-green-500 hover:bg-green-600 transition duration-200 text-white px-4 py-2">
                        Confirmar
                    </button>
                </div>
            </div>
            <div v-else>
                <div class="text-2xl font-bold text-center">
                    {{ response_message }}
                </div>
                <div class="flex justify-center">
                    <button @click="confirm"
                            class="rounded-md shadow-md bg-blue-500 hover:bg-blue-600 transition duration-200 text-white px-4 py-2">
                        Ok
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div v-else-if="deleting == 'already_request'" class="fixed z-50 w-full h-full left-0 top-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="rounded-md w-2/4 bg-white p-4 grid grid-cols-1 gap-y-4">
            <div class="text-2xl font-bold text-center">
                La petición de eliminación ha sido enviada. En cuanto sea eliminada o rechazada, recibirás una notificación de confirmación.
            </div>
            <div class="flex justify-center">
                <button @click="deleting = null, errors ? errors = null : errors"
                        class="rounded-md shadow-md bg-blue-500 hover:bg-blue-600 transition duration-200 text-white px-4 py-2">
                    Ok
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout";
import PaginationComponent from "@/Components/PaginationComponent";

export default {
    layout: MainLayout,

    props: ['seller_sales'],
    data() {
        return {
            message: '',
            deleting: null,
            sale: null,
            confirm_delete: false,
            password: '',
            errors: null,
            response_message: null
        }
    },
    components: {PaginationComponent, MainLayout},
    methods: {
        advice(sale) {
            this.sale = sale
            this.sale.status == 'pending_to_delete' ? this.deleting = 'already_request' : this.deleting = 'to_delete'
        },
        confirmDelete() {
            this.confirm_delete = true

        },
        deleteProduct() {
            axios.post(this.route('management.confirm_password'), {
                password: this.password
            })
                .then(response => {
                    axios.post(this.route('management.sales.send_delete_request'), {
                        id: this.sale.id
                    })
                        .then(response => {
                            this.errors = null
                            this.response_message = response.data.success
                            this.sale.status = response.data.status
                        })
                        .catch(() => {
                        })
                })
                .catch(err => {
                    this.errors = err.response.data.error
                })
        },
        confirm(){
            window.location = route('management.sales.index')
        }
    },
}
</script>

<style scoped>

</style>
