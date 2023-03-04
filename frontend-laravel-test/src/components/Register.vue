<!-- eslint-disable vue/multi-word-component-names -->
<script setup>
import axios from "axios";
import { ref } from "vue";


const message = ref("");
const error = ref("");
const name = ref("");
const email = ref("");
const password = ref("");


const registerNow = async () => {
  await axios.post('https://frontendlaravel.suremarts.com/admin/api/register', {

    name: name.value,
    email: email.value,
    password: password.value,

  }).then((response) => {
    
    if(response){
      message.value = 'Registered Successfully!';
      
      name.value = "";
      email.value = "";
      password.value = "";
    }
    
  })
  .catch((errors) => {
    if (errors) {
      error.value = "Field can't be empty";
    }
  });

}




</script>

<template>
  <div>
    <header>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h3>Task Page</h3>
          </div>
        </div>
      </div>
    </header>

    <section class="task">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6 aa">
            
            <h3>Register Here</h3><hr>
            <form @submit.prevent="registerNow()">
                <div v-if="message != ''" class="alert alert-success">
                  {{ message }}
                </div>

                <div v-if="error != ''" class="alert alert-danger">
                  {{ error }}
                </div>

                <div class="mb-3">
                    <label for="">Full Name</label>
                    <input type="text" class="form-control" v-model="name">
                </div>

                <div class="mb-3">
                    <label for="">Email Address</label>
                    <input type="text" class="form-control" v-model="email">
                </div>

                <div class="mb-3">
                    <label for="">Password</label>
                    <input type="password" class="form-control" v-model="password">
                </div>

                <div class="mb-3">
                    <button class="btn btn-success mb-3">Register</button>
                    <p>Already have an account? <RouterLink to="/">Login here</RouterLink></p>
                </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
