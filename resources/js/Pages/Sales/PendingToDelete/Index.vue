<template>
    <div class="p-2 text-sm">
        <div v-if="sales.length > 0" class="rounded-md shadow-md w-full border border-gray-200 bg-white">
            <table class="table-auto rounded-md w-full">
                <thead>
                <tr class="text-gray-400">
                    <th class="p-2 bg-gray-100 text-left">Petición</th>
                    <th class="p-2 bg-gray-100 text-center">Nombre del peticionador</th>
                    <th class="p-2 bg-gray-100 text-center">Token de la venta</th>
                    <th class="p-2 bg-gray-100">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="sale in sales" :key="sale.id" class="text-gray-500">
                    <td class="p-2 text-left">
                        <a target="_blank" :href="route('management.sales.pending_to_delete.show', sale.sale_token)" class="text-blue-500">
                            Ver detalles
                        </a>
                    </td>
                    <td class="p-2 text-center">
                        <a target="_blank" :href="route('management.user.show', sale.petitioner_id)" class="text-blue-500">
                            {{ sale.petitioner_name }}
                        </a>
                    </td>
                    <td class="p-2 text-center">
                        <a target="_blank" :href="route('management.sales.show', sale.sale_id)" class="text-blue-500">
                            {{ sale.sale_token }}
                        </a>
                    </td>
                    <td class="flex justify-center">
                        <div class="p-2 grid grid-cols-2 gap-x-4">
                            <div>
                                <button @click="reject(sale)" class="text-black underline">
                                    Rechazar
                                </button>
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
            Parece que aún no hay peticiones :(
        </div>

    </div>
    <div v-if="deleting" class="fixed z-50  left-0 w-full h-full top-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div v-if="!confirm_delete" class="w-2/4 rounded-md bg-white p-4 grid grid-cols-1 gap-y-4">
            <div class="text-2xl font-bold text-center">¿Deseas eliminar la venta {{ sale.sale_token }}?</div>
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
        deleteSale() {
            axios.post(this.route('management.confirm_password'), {
                password: this.password
            })
                .then(response => {
                    axios.post(this.route('management.sales.pending_to_delete.destroy'), {
                        sale_token: this.sale.sale_token
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
        reject(sale){
            axios.post(this.route('management.sales.pending_to_delete.reject'), {
                sale_token: sale.sale_token
            })
            .then(() => {
                window.location = this.route('management.sales.pending_to_delete.index')
            })
        }
    },
}
</script>

<style scoped>

</style>
