<template>
    <main-layout>
        <template v-slot:content>
            <div class="p-2 grid grid-cols-1 gap-y-8">
                <div class="flex justify-start ">
                    <inertia-link :href="route('management.product.index')" class="hover:bg-gray-100 transition duration-200 px-4 py-2 rounded-md shadow-sm border border-gray-200 text-gray-600">Regresar</inertia-link>

                </div>
                <div class="w-full flex justify-center ">
                    <div class="w-2/4 rounded-md shadow-md border border-gray-200 grid grid-cols-1">
                        <div class="p-2 bg-gray-100 text-gray-400 text-2xl border-b border-gray-500 text-center">Editando: {{ product.name }}</div>
                        <div class="grid grid-cols-1 gap-y-6 p-2">
                            <div class="text-center grid grid-cols-1 gap-y-2">
                                <label for="name">Nombre</label>
                                <input v-model="form.name" id="name" type="text" class="text-center rounded-md shadow-sm border border-gray-200">
                            </div>
                            <div class="grid grid-cols-2 gap-x-6">

                                <div class="text-center grid grid-cols-1 gap-y-2">
                                    <label for="price">Precio</label>
                                    <div class="flex justify-center">
                                        <div class="h-auto flex items-center justify-center content-center bg-gray-100 px-2 rounded-l-md">$</div>
                                        <input  v-model="form.price" id="price" type="number" step="any" class="text-center rounded-r-md shadow-sm border border-gray-200">
                                    </div>
                                </div>
                                <div class="text-center grid grid-cols-1 gap-y-2">
                                    <label for="stock">Stock</label>
                                    <input  v-model="form.new_stock" id="stock" type="number" class="text-center rounded-md shadow-sm border border-gray-200">
                                </div>
                            </div>
                            <div class="w-full flex justify-center">
                                <button @click="save" class="px-4 py-2 bg-blue-500 text-white shadow-md rounded-md">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </main-layout>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout";
export default {
    components: {MainLayout},
    props: ['product'],
    data(){
        return {
            form: {
                name: this.product.name,
                price: this.product.price,
                new_stock: this.product.actual_stock
            }
        }
    },
    methods: {
        save(){
            this.convert()
            console.log(this.form)

            axios.put(this.route('management.product.update', this.product), this.form)
                .then(() => {
                    window.location = this.route('management.product.show', this.product)
                })
        },
        convert(){
            let number = this.form.price
            let digits = number.toString().split('');

            let decimal_point = digits.indexOf('.')
            let length = digits.length

            if (length - (decimal_point + 1) >= 3) {
                let final_convert = digits.splice(0, (decimal_point + 3) )
                let joining = final_convert.join('')
                parseFloat(joining)
                this.form.price = joining

            } else if (length - (decimal_point + 1) == 1) {
                digits.push('0')
                let joining = digits.join('')
                parseFloat(joining)
                this.form.price = joining
            } else {
                this.form.price = this.form.price
            }
        }
    }


}
</script>

<style scoped>

</style>
