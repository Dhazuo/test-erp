<template>
    <div class="p-2 text-sm">
        <div class="flex justify-end mb-4">
            <inertia-link :href="route('management.sales.create')"
                          class="px-4 py-2 rounded-md shadow-md bg-blue-500 text-white">Crear
            </inertia-link>
        </div>
        <div v-if="sales.data.length > 0" class="rounded-md shadow-md w-full border border-gray-200 bg-white">
            <table class="table-auto rounded-md w-full">
                <thead>
                <tr class="text-gray-400">
                    <th class="p-2 bg-gray-100 text-left">Token</th>
                    <th class="p-2 bg-gray-100">Nombre del vendedor</th>
                    <th class="p-2 bg-gray-100">Comprador</th>
                    <th class="p-2 bg-gray-100">Producto</th>
                    <th class="p-2 bg-gray-100">Stock total</th>
                    <th class="p-2 bg-gray-100">Precio final</th>
                    <th class="p-2 bg-gray-100">Creación</th>
                    <th class="p-2 bg-gray-100">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="sale in sales.data" :key="sale.id" class="text-gray-500">
                    <td class="p-2">
                        <inertia-link :href="route('management.sales.show', sale.id)" class="text-blue-500">
                            {{ sale.token }}
                        </inertia-link>
                    </td>
                    <td class="p-2 text-center">
                        <inertia-link :href="route('management.user.show', sale.seller_id)" class="text-blue-500">
                            {{ sale.seller_name }}
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
                                <inertia-link :href="route('management.sales.edit', sale)" class="text-green-500">
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
        <div v-if="sales" class="mt-6 flex justify-center">
            <pagination-component :links="sales.links"></pagination-component>
        </div>
    </div>
    <div v-if="deleting" class="fixed z-50  left-0 w-full h-full top-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div v-if="!confirm_delete" class="rounded-md bg-white p-4 grid grid-cols-1 gap-y-4">
            <div class="text-2xl font-bold text-center">¿Deseas eliminar el usuario {{ sale.name }}?</div>
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
        <div v-else class="rounded-md bg-white p-4 grid grid-cols-1 gap-y-4">
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
                <button @click="deleteProduct"
                        class="rounded-md shadow-md bg-green-500 hover:bg-green-600 transition duration-200 text-white px-4 py-2">
                    Confirmar
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
    props: ['sales'],
    data() {
        return {
            message: '',
            deleting: false,
            sale: null,
            confirm_delete: false,
            password: '',
            errors: null
        }
    },
    components: {PaginationComponent, MainLayout},
    methods: {
        advice(sale) {
            this.sale = sale
            this.deleting = true
        },
        confirmDelete() {
            this.confirm_delete = true

        },
        deleteProduct() {
            axios.post(this.route('management.confirm_password'), {
                password: this.password
            })
                .then(response => {
                    axios.delete(this.route('management.sales.destroy', this.sale.id))
                        .then(() => {
                            this.errors = null
                            window.location = this.route('management.sales.index')
                        })
                        .catch(() => {
                            window.location = this.route('management.sales.index')
                        })
                })
                .catch(err => {
                    this.errors = err.response.data.error
                })
        }
    },
    mounted() {
    }
}
</script>

<style scoped>

</style>
