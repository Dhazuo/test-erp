<template>
    <div @click.self="actions" class="fixed top-0 w-full h-full bg-black bg-opacity-25 flex justify-center items-center p-4">
        <div class="rounded-md bg-white w-2/4 height p-2 overflow-y-auto">
            <div class="grid grid-cols-4 gap-8">
                <div v-for="product in products" class="text-center flex items-center space-x-2">
                    <label :for="product.name">{{ product.name }}</label>
                    <input :id="product.name" type="checkbox" :value="product.name" v-model="product_list">
                </div>
            </div>
            <div class="w-full mt-8 flex justify-end">
                <button @click="actions" class="px-4 py-2 rounded-md shadow-md bg-blue-500 text-white hover:bg-blue-600">Agregar productos</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['products'],
    data(){
        return{
            product_list: []
        }
    },
    methods: {
        actions(){
            this.$emit('close-modal', this.product_list)
        }
    },

}
</script>

<style scoped>
.height{
    height: 90%;
}
</style>
