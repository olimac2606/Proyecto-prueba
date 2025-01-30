<template>
    <v-container>
      <v-card>
        <v-card-title>{{ isEdit ? 'Editar Producto' : 'Agregar Producto' }}</v-card-title>
        <v-card-text>
          <v-form ref="form" @submit.prevent="saveProduct">
            <v-text-field :rules="[requiredRule]" v-model="product.name" label="Nombre" required></v-text-field>
            <v-textarea :rules="[requiredRule]" v-model="product.description" label="Descripción" required></v-textarea>
            <v-text-field :rules="[greaterThanZero, requiredRule]" v-model="product.price" label="Precio" type="number" required></v-text-field>
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
  const isValid = ref(false); // Variable para controlar si el formulario es válido
  
  //Reglas
  const requiredRule = (value) => !!value || "Este campo es obligatorio"
  const greaterThanZero = (value) => !!value < 0 || "El precio tiene que ser mayor a 0"

  // Referencia al formulario usando ref()
  const formRef = ref(null);

  onMounted(async () => {
    if (route.params.id) {
      isEdit.value = true
      const response = await axios.patch(`http://localhost:8000/api/products/${route.params.id}`)
      product.value = response.data
    }
  })
  
// Función para guardar el producto
const saveProduct = async () => {
  // Acceder al formulario con formRef
  const form = formRef.value;

  // Validar el formulario antes de proceder
  const valid = await form.validate();

  if (valid) {
    // Si la validación pasa, proceder con el guardado
    if (isEdit.value) {
      // Si es una edición, hacemos una solicitud PUT
      await axios.put(`http://localhost:8000/api/products/${route.params.id}`, product.value);
    } else {
      // Si es una creación, hacemos una solicitud POST
      await axios.post('http://localhost:8000/api/products', product.value);
    }

    // Redirigir a la página principal
    router.push('/');
  } else {
    // Si la validación falla, puedes mostrar un mensaje o manejar el error
    console.log('Formulario no válido');
  }
};
  </script>
  