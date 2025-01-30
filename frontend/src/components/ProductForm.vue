<template>
  <v-container>
    <v-card>
      <v-card-title>{{ isEdit ? 'Editar Producto' : 'Agregar Producto' }}</v-card-title>
      <v-card-text>
        <v-form ref="formRef" @submit.prevent="saveProduct">
          <v-text-field :rules="[requiredRule, moreThanThreeLetter]" v-model="product.name" label="Nombre" required></v-text-field>
          <v-textarea :rules="[requiredRule]" v-model="product.description" label="Descripción" required></v-textarea>
          <v-text-field :rules="[greaterThanZero]" v-model="product.price" label="Precio" type="number" required></v-text-field>
          <v-btn type="submit" color="green">Guardar</v-btn>
        </v-form>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const isEdit = ref(false)
const product = ref({ name: '', description: '', price: 0 })
const formRef = ref(null) // Referencia al formulario

// Reglas de validación
const requiredRule = (value) => !!value || "Este campo es obligatorio"
const greaterThanZero = (value) => value > 0 || "El precio tiene que ser mayor a 0"
const moreThanThreeLetter = (value) => value.length > 3 || "El nombre debe tener más de 3 caracteres"

onMounted(async () => {
  if (route.params.id) {
    isEdit.value = true
    const response = await axios.get(`http://localhost:8000/api/products/${route.params.id}`)
    product.value = response.data
  }
})

// Función para guardar el producto con validación
const saveProduct = async () => {
  const form = formRef.value;
  if (!form) return;

  const { valid } = await form.validate(); // Validar el formulario antes de continuar
  if (!valid) {
    console.log('Formulario no válido');
    return;
  }

  if (isEdit.value) {
    await axios.patch(`http://localhost:8000/api/products/${route.params.id}`, product.value);
  } else {
    await axios.post('http://localhost:8000/api/products', product.value);
  }

  router.push('/');
};
</script>