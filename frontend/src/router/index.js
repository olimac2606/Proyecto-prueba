import { createRouter, createWebHistory } from 'vue-router'
import ProductTable from '@/components/ProductTable.vue'
import ProductForm from '@/components/ProductForm.vue'

const routes = [
  { path: '/', component: ProductTable },
  { path: '/add', component: ProductForm },
  { path: '/edit/:id', component: ProductForm, name: 'edit' }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router