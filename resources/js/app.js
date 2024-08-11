require('./bootstrap')
import { createApp } from 'vue'
import router from './router/router'
import store from './store/store'

import menu from './components/menu'
import dashboard from './components/dashboard'
import navBar from './components/navBar'
const app = createApp({})
app.component('menu-restaurant', menu)
app.component('dashboard', dashboard)
app.component('nav-bar', navBar)
app.use(router)
app.use(store)
app.mount('#app')