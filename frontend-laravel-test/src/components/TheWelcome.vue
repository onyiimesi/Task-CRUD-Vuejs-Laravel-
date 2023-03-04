<script setup>
import axios from "axios";
import { ref } from "vue";
import router from "@/router";


const message = ref("");
const errors = ref("");

const email = ref("");
const password = ref("");


const loginNow = async () => {

    await axios.post('https://frontendlaravel.suremarts.com/admin/api/login', {

      email: email.value,
      password: password.value

    }).then((response) => {
      
      localStorage.setItem("userToken", response.data.data.token);
      localStorage.setItem("email", response.data.data.user.email);

      router.push("/task");

      email.value = "";
      password.value = "";
      
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
            
            <h3>Login Here</h3><hr>
            <form @submit.prevent="loginNow()">
                <div v-if="message != ''" class="alert alert-success">
                  {{ message }}
                </div>

                <div v-if="errors != ''" class="alert alert-danger">
                  {{ errors }}
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
                    <button class="btn btn-success mb-3">Login</button>
                    <p>Don't have an account? <RouterLink to="/register">Register here</RouterLink></p>
                </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
