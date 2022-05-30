<template>
    <div class="p-2 grid grid-cols-1 gap-y-8 text-sm">
        <div class="flex justify-start ">
            <inertia-link :href="route('management.sales.index')"
                          class="bg-white hover:bg-gray-50 transition duration-200 px-4 py-2 rounded-md shadow-sm border border-gray-200 text-gray-600">
                Regresar
            </inertia-link>
        </div>
        <div class="w-full max-h-full bg-white rounded-md p-2 font-bold grid grid-cols-1 gap-y-4">
            <div class="grid grid-cols-1 gap-y-2">
                <label for="product">Selecciona tus productos:</label>
                <datalist id="product">
                    <option v-for="product in products" :value="product.name">
                    </option>
                </datalist>
                <input v-model="temporal_products" autoComplete="on" list="product"
                       class="p-2 rounded-md border border-gray-200 shadow-sm focus:outline-none focus:border-main transition duration-200"/>
            </div>
                <div class="grid grid-cols-1 gap-y-2">
                    <label for="customer">Selecciona tu cliente:</label>
                    <datalist id="customer">
                        <option v-for="customer in customers" :value="customer.name">
                        </option>
                    </datalist>
                    <input v-model="form.customer" autoComplete="on" list="customer"
                           class="p-2 rounded-md border border-gray-200 shadow-sm focus:outline-none focus:border-main transition duration-200"/>
            </div>
            <div class="grid grid-cols-1 gap-y-2">
                <div>Resumen de venta:</div>
                <div class="w-full">
                    <table class="table-auto w-full">
                        <thead class="text-main border-b border-gray-200">
                        <tr>
                            <td class="p-2">Producto</td>
                            <td class="p-2 text-center">Cantidad</td>
                            <td class="p-2 text-center">Punitario</td>
                            <td class="p-2 text-center">Total</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(product, index) in form.products" class="border-b border-gray-200">
                            <td class="p-2">{{ product.name }}</td>
                            <td class="p-2 flex justify-center">
                                <input v-model="product.stock" type="number"
                                       class="w-24 text-sm focus:ring-0 rounded-md outline-none border border-gray-200 shadow-sm focus:outline-none focus:border-main transition duration-200">
                            </td>
                            <td class="p-2">

                            </td>
                            <td class="p-2 text-center">
                                ${{ (product.stock * product.price).toFixed(2) }}
                            </td>
                        </tr>
                        <tr v-if="form.products.length > 0">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-center text-main">
                                {{ total_on_list ? `$${total_on_list}` : '$0' }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="w-full flex justify-center">
                <button :disabled="is_processing" @click="calculate"
                        class="px-4 py-2 bg-main rounded-md shadow-md text-white font-bold">
                    <p v-if="is_processing">Espere un momento...</p>
                    <p v-else>Guardar</p>
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
    props: ['products', 'customers'],
    data() {
        return {
            form: {
                customer: '',
                products: [],

            },
            temporal_products: '',
            total_on_list: null,
            id: null,
            products_modal: false,
            stock_modal: false,
            products_copy: this.products,
            prods_html: '',
            a: '',
            is_processing: false,
        }
    },
    methods: {
        calculate() {
            if (this.verification()) {
                if (this.form.products.length <= 0) {
                    alert('No tienes productos seleccionados.')
                } else {
                    this.save()
                }
            } else {
                this.is_processing = false
            }
        },
        save() {
            axios.post(this.route('management.sales.store'), this.form)
                .then(response => {
                    this.total = response.data.total
                    this.id = response.data.id
                })
                .then(() => {
                    window.location = this.route('management.sales.show', this.id)
                })
        },
        searchProduct(product) {
            let find = this.products.findIndex(element => {
                return element.name == product
            });
            if (find >= 0) {
                let find_product = this.products[find];
                let find_if_exists = this.form.products.findIndex(element => {
                    return element.name == product
                })
                if (find_if_exists == -1) {
                    this.temporal_products = ''
                    this.form.products.push({
                        name: product,
                        stock: '',
                        price: find_product.price,
                    })

                } else {
                    alert('Este producto ya está agregado.')
                    this.temporal_products = ''
                }
            }
        },
        verification() {
            this.is_processing = true
            let find_customer = this.customers.findIndex(element => {
                return element.name == this.form.customer
            })
            if (find_customer < 0) {
                alert('Por favor selecciona un cliente válido.')
            }

            if (find_customer >= 0) {
                return true
            } else {
                return false
            }
        }

    },
    watch: {
        'temporal_products': function (newVal, oldVal) {
            if (oldVal != newVal) {
                this.searchProduct(newVal)
            }
        },
        'form.products': {
            handler: function () {
                if (this.form.products.length > 0) {
                    let total = 0
                    this.form.products.forEach(element => {
                        let total_price = element.price * element.stock
                        total += total_price
                        this.total_on_list = total.toFixed(2)
                    })
                }
            },
            deep: true
        }
    }

}
</script>

<style scoped>

</style>
