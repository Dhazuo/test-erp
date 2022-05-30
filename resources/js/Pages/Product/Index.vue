<template>

    <div class="p-2 text-sm">
        <div class="flex justify-end mb-4">
            <inertia-link :href="route('management.product.create')"
                          class="px-4 py-2 rounded-md shadow-md bg-blue-500 text-white">Crear
            </inertia-link>
        </div>
        <div class="rounded-md shadow-md w-full border border-gray-200 bg-white">
            <table class="table-auto rounded-md w-full">
                <thead>
                <tr class="text-gray-400">
                    <th class="p-2 bg-gray-100 text-left">Nombre del producto</th>
                    <th class="p-2 bg-gray-100">Precio del producto</th>
                    <th class="p-2 bg-gray-100">Stock del producto</th>
                    <th class="p-2 bg-gray-100">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in products.data" class="text-gray-500">
                    <td class="p-2">
                        <inertia-link :href="route('management.product.show', product)" class="text-blue-500">
                            {{ product.name }}
                        </inertia-link>
                    </td>
                    <td class="p-2 text-center">
                        ${{ product.price }}
                    </td>
                    <td class="p-2 text-center font-bold">
                        {{ product.actual_stock }}
                    </td>
                    <td class="flex justify-center">
                        <div class="p-2 grid grid-cols-2 gap-x-1">
                            <div>
                                <inertia-link :href="route('management.product.edit', product)" class="text-green-500">
                                    Editar
                                </inertia-link>
                            </div>
                            <div>
                                <button @click="advice(product)" class="text-red-500">Eliminar</button>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-center">
            <pagination-component :links="products.links"></pagination-component>
        </div>
    </div>
    <div v-if="deleting" class="fixed z-50 w-full h-full top-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div v-if="!confirm_delete" class="rounded-md bg-white p-4 grid grid-cols-1 gap-y-4">
            <div class="text-2xl font-bold text-center">¿Deseas eliminar el producto {{ product.name }}?</div>
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
import MainLayout from "../../Layouts/MainLayout";
import PaginationComponent from "../../Components/PaginationComponent";

export default {
    layout: MainLayout,
    props: ['products'],
    data() {
        return {
            message: '',
            deleting: false,
            product: null,
            confirm_delete: false,
            password: '',
            errors: null
        }
    },
    components: {PaginationComponent, MainLayout},
    methods: {
        advice(product) {
            this.product = product
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
                    axios.delete(this.route('management.product.destroy', this.product))
                        .then(() => {
                            this.errors = null
                            window.location = this.route('management.product.index')
                        })
                })
                .catch(err => {
                    this.errors = err.response.data.error
                })
        }
    }
}
</script>

<style scoped>

</style>
