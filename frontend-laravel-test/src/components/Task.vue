<!-- eslint-disable vue/multi-word-component-names -->
<script setup>
import axios from "axios";
import { onMounted, ref, watch } from "vue";
import router from "@/router";


const tasks = ref(null);
const Delmessage = ref("");
const user = ref("");
const email = ref("");


onMounted(async () => {
    const response = await axios.get("https://frontendlaravel.suremarts.com/api/task", {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('userToken')
        }
    })
    
    tasks.value = response.data.data;
    
    user.value = localStorage.getItem("userToken");

    email.value = localStorage.getItem("email");

    if(!user.value){
        router.push("/");
    }

});

watch(async () => {
    const res = await axios.get("https://frontendlaravel.suremarts.com/admin/api/task", {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('userToken')
        }
    });
    tasks.value = res.data.data;
});

const Logout = async () => {
    localStorage.removeItem("userToken");

    router.push("/");
}

const DeleteTask = async (id) => {
  await axios.delete('https://frontendlaravel.suremarts.com/admin/api/task/'+id, {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('userToken')
        }
    })
  .then(() => {
    const projectIndex = tasks.value.findIndex(p => p.id === id)
      tasks.value.splice(projectIndex, 1);
      
      Delmessage.value = "Deleted Successfully";
    
  })
}



</script>

<template>
  <div>
    <header>
      <div class="container">
        <div class="row">
          <div class="col-md-12 d-flex">
            <div class="me-auto">
                <h3>Task Page</h3>
            </div>
            <div class="">
                <button @click="Logout()" class="btn btn-danger brn-sm">Logout</button>
            </div>
          </div>
        </div>
      </div>
    </header>

    <section class="task">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h5>
               Welcome, {{ email }}
            </h5><hr>
            <div>
              <RouterLink to="/create-task"><button class="btn btn-primary mb-2 btn-sm">Create Task</button></RouterLink>
            </div>
            <div v-if="Delmessage != ''" class="alert alert-success">
              {{ Delmessage }}
            </div>

            
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Task Name</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="tsk in tasks" :key="tsk.id">
                  <th>{{ tsk.id }}</th>
                  <td>{{ tsk.TaskName }}</td>
                  <td>{{ tsk.TaskDesc }}</td>
                  <td>
                    <RouterLink :to="'/edit-task/'+tsk.id"><button class="btn btn-success btn-sm me-3">Edit</button></RouterLink>
                    <button @click="DeleteTask(tsk.id)" class="btn btn-danger btn-sm">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
