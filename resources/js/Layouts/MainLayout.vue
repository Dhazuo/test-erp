<template>
    <div class="fixed top-0 z-10 w-full h-14 bg-white shadow-md flex">
        <div :class="status ? 'justify-end' : 'justify-between '" class="menu transition-all duration-500 custom-width border-r border-gray-100 h-full flex items-center">
            <div v-if="!status" class=" pl-8">
                <div class="w-1/2">
                    <inertia-link :href="route('management.index')" class="flex">
                        <img src="/svg/logo.svg" alt="" class="w-full">
                    </inertia-link>
                </div>
            </div>
            <button @click="hide" class="p-2 text-main">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="24"
                     height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                     stroke-linecap="round" stroke-linejoin="round">
                    <desc>Download more icon variants from https://tabler-icons.io/i/menu-2</desc>
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="4" y1="6" x2="20" y2="6"></line>
                    <line x1="4" y1="12" x2="20" y2="12"></line>
                    <line x1="4" y1="18" x2="20" y2="18"></line>
                </svg>
            </button>
        </div>
        <div class="w-auto px-4">
            <div
                    class="absolute right-4 transform top-1/2 -translate-y-1/2 flex items-center">
                <button @click="notification_menu = !notification_menu, user_menu ? user_menu = !user_menu : user_menu"  class="relative text-main mr-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bell" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <desc>Download more icon variants from https://tabler-icons.io/i/bell</desc>
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path>
                        <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
                    </svg>
                    <div v-if="countUnread > 0 && !read" class="absolute -top-2 -right-2 h-4 w-4 bg-red-500 rounded-full text-white font-bold text-xs">
                        {{ countUnread }}
                    </div>
                </button>
                <button @click="user_menu = !user_menu, notification_menu ? notification_menu = !notification_menu : notification_menu" class="flex space-x-2 items-center">
                    <div class="rounded-full w-12 h-12 bg-gray-200"></div>
                    <div class="grid grid-cols-1 text-left">
                        <div>
                            {{ user.name.substr(0, user.name.indexOf(' ')) }}
                        </div>
                        <div v-if="user.role == 'admin'" class="text-main">Administrador</div>
                        <div v-if="user.role == 'manager'" class="text-main">Gerente</div>
                        <div v-if="user.role == 'seller'" class="text-main">Vendedor</div>
                    </div>
                    <div class="text-main">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-caret-down fill-main"
                             width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                             stroke-linecap="round" stroke-linejoin="round">
                            <desc>Download more icon variants from https://tabler-icons.io/i/caret-down</desc>
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M18 15l-6 -6l-6 6h12" transform="rotate(180 12 12)"></path>
                        </svg>
                    </div>
                </button>
            </div>
        </div>
    </div>
    <div class="mt-2 relative h-full w-full flex justify-end">
        <div
            class="menu2 text-xl h-full fixed left-0 top-0 pt-12 custom-width bg-white border-r border-gray-200 flex justify-center transition-all duration-500">
            <div class="pt-12 w-full">
                <div class="w-full flex justify-center">
                    <inertia-link :href="route('management.product.index')"
                                  :class="route().current('management.product*') ? 'text-main border-r-4 border-main' : '', status ? 'py-6 pl-0 justify-center' : 'py-6 pl-8 '"
                                  class="text-gray-500 font-bold flex space-x-2 w-full items-center hover:bg-main-50 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-basket" width="30" height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <desc>Download more icon variants from https://tabler-icons.io/i/basket</desc>
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <polyline points="7 10 12 4 17 10"></polyline>
                            <path d="M21 10l-2 8a2 2.5 0 0 1 -2 2h-10a2 2.5 0 0 1 -2 -2l-2 -8z"></path>
                            <circle cx="12" cy="15" r="2"></circle>
                        </svg>
                        <div v-if="!status">
                            Productos
                        </div>
                    </inertia-link>
                </div>
                <div v-if="user.role == 'admin' || user.role == 'manager'" class="w-full flex justify-center ">
                    <inertia-link :href="route('management.user.index')"
                                  :class="route().current('management.user*') ? 'text-main border-r-4 border-main' : '', status ? 'py-6 pl-0 justify-center' : 'py-6 pl-8 '"
                                  class="text-gray-500 font-bold flex space-x-2 w-full items-center hover:bg-main-50 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="30"
                             height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <desc>Download more icon variants from https://tabler-icons.io/i/users</desc>
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                        </svg>
                        <div v-if="!status">
                            Usuarios
                        </div>
                    </inertia-link>
                </div>
                <div class="w-full flex justify-center">
                    <inertia-link :href="route('management.sales.index')"
                                  :class="route().current('management.sales*') ? 'text-main border-r-4 border-main' : '', status ? 'py-6 pl-0 justify-center' : 'py-6 pl-8 '"
                                  class="text-gray-500 font-bold flex space-x-2 w-full items-center hover:bg-main-50 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-list" width="30" height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <desc>Download more icon variants from https://tabler-icons.io/i/clipboard-list</desc>
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                            <rect x="9" y="3" width="6" height="4" rx="2"></rect>
                            <line x1="9" y1="12" x2="9.01" y2="12"></line>
                            <line x1="13" y1="12" x2="15" y2="12"></line>
                            <line x1="9" y1="16" x2="9.01" y2="16"></line>
                            <line x1="13" y1="16" x2="15" y2="16"></line>
                        </svg>
                        <div v-if="!status">
                            Ventas
                        </div>
                    </inertia-link>
                </div>
            </div>
        </div>
        <div class="content custom-width-2 p-2 transition-all duration-500">
            <div class="pt-12">
                <slot ></slot>
            </div>
        </div>
    </div>
    <div v-if="notification_menu" class="overflow-y-auto absolute bg-white height text-sm top-14 right-custom rounded-md shadow-md border border-gray-200 w-1/4 p-2">
        <div class="w-full flex justify-end mb-6 text-green-800">
            <button @click="markAllAsRead" class="text-blue-500 font-bold">Marcar todas como leídas</button>
        </div>
        <div v-if="notifications.length > 0" v-for="notification in notifications" class="text-left w-full rounded-md hover:bg-main-100 transition duration-200 p-2 flex items-center justify-between">
            <inertia-link v-if="notification.data.type == 'user'" as="button" @click="markAsRead(notification.id, notification.read_at)" :href="route('management.notification.index', {id: notification.id})"  class="text-left">
                El usuario <b>{{ notification.data.auth_name }}</b> creó al usuario <b>{{ notification.data.name }}</b> con el email <b>{{ notification.data.email }}</b> y con el rol <b>{{ notification.data.role }}</b>.
            </inertia-link>
            <inertia-link v-else-if="notification.data.type == 'sale' " as="button" @click="markAsRead(notification.id, notification.read_at)" :href="route('management.notification.index', {id: notification.id})"  class="text-left">
                El usuario <b>{{ notification.data.auth_name }}</b> creó la venta con el token: <b>{{ notification.data.token }}</b> para el cliente <b>{{ notification.data.customer }}</b> con el stock de <b>{{ notification.data.total_stock }}</b> por un precio de <b>${{ notification.data.total_price.toFixed(2) }}</b>.
            </inertia-link>
            <inertia-link v-else-if="notification.data.type == 'sale_delete_request' " as="button" @click="markAsRead(notification.id, notification.read_at)" :href="route('management.notification.index', {id: notification.id})"  class="text-left">
                El usuario <b>{{ notification.data.auth_name }}</b> desea eliminar la venta con el token: <b>{{ notification.data.token }}</b>. Haz click para ver detalles.
            </inertia-link>
            <inertia-link v-else-if="notification.data.type == 'sale_deleted' " as="button" @click="markAsRead(notification.id, notification.read_at)" :href="route('management.notification.index', {id: notification.id})"  class="text-left">
                Se ha eliminado tu venta con el token: <b>{{ notification.data.token }}</b>.
            </inertia-link>
            <inertia-link v-else-if="notification.data.type == 'sale_conserved' " as="button" @click="markAsRead(notification.id, notification.read_at)" :href="route('management.notification.index', {id: notification.id})"  class="text-left">
                Se ha decidido conservar tu venta con el token: <b>{{ notification.data.token }}</b>.
            </inertia-link>
            <div>
                <div v-if="!notification.read_at" class="rounded-full h-3 w-3 bg-blue-500">

                </div>
            </div>
        </div>
        <div v-else class="text-center font-bold text-lg">
            No hay nada por aquí...
        </div>
    </div>
    <div v-if="user_menu"
         class="bg-white absolute top-14 right-4 rounded-md shadow-md border border-gray-200 py-2 grid grid-cols-1 gap-y-4">
        <div class="px-4 py-2 border-b">Hola, {{ user.name.substr(0, user.name.indexOf(' ') + 1) }}</div>
        <button @click="logout" class="hover:bg-gray-100 transition duration-200 px-4 py-2">Logout</button>
    </div>
    <div v-if="logout_processing"
         class="fixed text-4xl z-50 bg-black top-0 w-full h-full bg-opacity-25 flex justify-center items-center text-white">
        Saliendo...
    </div>
</template>

<script>
import Button from "../Jetstream/Button";

export default {
    name: "MainLayout",
    components: {Button},
    data() {
        return {
            user_menu: false,
            logout_processing: false,
            status: false,
            notification_menu: false,
            read: false
        }
    },

    computed: {
        user() {
            return this.$page.props.auth.user
        },
        notifications(){
            return this.$page.props.auth.notifications
        },
        countUnread(){
            return this.$page.props.auth.unread_notifications
        }
    },
    methods: {
        logout() {
            this.logout_processing = true
            axios.post(this.route('management_logout'), {
                user_id: this.user.id
            })
                .then(response => {
                    window.location = this.route('index')
                })
        },
        hide() {
            if (!this.status) {
                this.status = !this.status
                let a = document.querySelector('.menu');
                let b = document.querySelector('.menu2');
                let d = document.querySelector('.content');
                let e = document.querySelector('.text1');

                setTimeout(() => {
                    a.classList.add('add-width')
                    b.classList.add('add-width')
                    d.classList.add('add-width-2')
                    e.classList.add('add-width-3')
                }, 1)
            } else {
                let a = document.querySelector('.menu');
                let b = document.querySelector('.menu2');
                let d = document.querySelector('.content');
                let e = document.querySelector('.text1');

                setTimeout(() => {
                    a.classList.remove('add-width')
                    b.classList.remove('add-width')
                    d.classList.remove('add-width-2')
                    e.classList.remove('add-width-3')

                }, 1)
                this.status = !this.status
            }
        },
        markAsRead(id, read_at) {
            if (!read_at) {
                axios.post(this.route('management.notification.mark_as_read'), {
                    id: id
                })
            }
        },
        markAllAsRead(){

            let not_read = this.notifications.filter(notification => {
                return !notification.read_at
            });
            if (not_read.length > 0) {
                axios.post(this.route('management.notification.mark_all_as_read'), {
                    not_read: not_read
                })
                .then(response => {
                    this.read = true
                    let newest = response.data.notifications_read
                    newest.forEach(element => {
                        let find = this.notifications.findIndex(find => {
                            return find.id == element.id
                        })
                        this.notifications[find].read_at = element.read_at
                    })
                })
            }
        }
    },
}
</script>

<style scoped>
.right-custom {
    right: 13.5rem;
}
.custom-width {
    width: 20%;
}

.custom-width-2 {
    width: 80%;
}
.height {
    max-height: 80%;
}
.add-width {
    width: 3%;
}

.add-width-2 {
    width: 97%;
}

.add-width-3 {
    width: 0%;
}
</style>
