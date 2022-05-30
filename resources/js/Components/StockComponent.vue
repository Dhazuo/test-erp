<template>
    <div @click.self="actions" class="fixed top-0 w-full h-full bg-black bg-opacity-25 flex justify-center items-center p-4">
        <div class="rounded-md bg-white w-2/4 height p-2 overflow-y-auto">
            <div v-if="products.length > 0" class="grid grid-cols-2 gap-8">
                <div v-for="(product, index) in product_list" class="text-center relative">
                    <button @click="deleteFromProducts(product, index)" class="absolute right-0  transform top-1/2 -translate-y-1/2 rounded-full h-8 w-8 bg-red-500 hover:bg-red-600 text-white flex items-center text-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x w-auto" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <desc>Download more icon variants from https://tabler-icons.io/i/x</desc>
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                    <label :for="product.product" class="text-center">{{ product.name }}</label>
                    <div class="flex justify-center">
                        <input :id="product.product" type="number" class="rounded-md shadow-sm border border-gray-200" v-model="product.stock">
                    </div>
                </div>
            </div>
            <div v-else class="text-2xl text-center">
                Aún no tienes productos
            </div>
            <div class="w-full mt-8 flex justify-end">
                <button v-if="product_list.length > 0" @click="actions" class="px-4 py-2 rounded-md shadow-md bg-blue-500 text-white hover:bg-blue-600">Guardar</button>
                <button @click="$emit('close-without-products')" v-else class="px-4 py-2 rounded-md shadow-md bg-red-500 text-white hover:bg-red-600">Cerrar</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['products'],
    data(){
        return{
            product_list: this.products,
            product_waiting: null
        }
    },
    methods: {
        actions(){
            this.$emit('save-stock', this.product_list)
        },
        deleteFromProducts(product, index){
            this.product_list.splice(index, 1)
            this.$emit('add-to-array', product)
        }
    },

}
</script>

<style scoped>
.height{
    height: 90%;
}
</style>
