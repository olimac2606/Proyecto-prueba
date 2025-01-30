<template>
  <v-container>
    <v-card>
      <v-card-title>Lista de Productos</v-card-title>
      <v-data-table :headers="headers" :items="products" item-value="name">
        <template v-slot:[`item.actions`]="{ item }">
          <v-btn variant="tonal" class="product-btn" color="blue" @click="editProduct(item)">Editar</v-btn>
          <v-btn variant="tonal" color="red" @click="deleteProduct(item.id)">Eliminar</v-btn>
        </template>
      </v-data-table>
    </v-card>
    <!-- Botón flotante (opcional) -->
  <v-btn color="green" class="fab-btn" @click="addProduct" fab>
    <v-icon>mdi-plus</v-icon>
  </v-btn>
  </v-container>
</template>
  
<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const products = ref([])
const router = useRouter()

const headers = [
  { title: 'Nombre', key: 'name' },
  { title: 'Descripción', key: 'description' },
  { title: 'Precio', key: 'price' },
  { title: 'Acciones', key: 'actions', sortable: false }
]

onMounted(async () => {
  const response = await axios.get('http://localhost:8000/api/products')
  products.value = response.data
})

const editProduct = (product) => {
  router.push({ name: 'edit', params: { id: product.id } })
}

const deleteProduct = async (id) => {
  await axios.delete(`http://localhost:8000/api/products/${id}`)
  products.value = products.value.filter(p => p.id !== id)
}
const addProduct = () => {
  router.push('/add')
}
</script>

<style scoped>
.fab-btn {
  position: fixed;
  bottom: 20px;
  right: 20px;
}
.product-btn{
  margin-right: 1rem;
}
</style>