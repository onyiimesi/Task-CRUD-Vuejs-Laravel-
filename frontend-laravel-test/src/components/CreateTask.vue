<script setup>
import axios from "axios";
import { ref } from "vue";

const TaskName = ref("");
const TaskDesc = ref("");
const message = ref("");
const error = ref("");

const createTask = async () => {
  await axios.post('https://frontendlaravel.suremarts.com/admin/api/task', {
    TaskName: TaskName.value,
    TaskDesc: TaskDesc.value,
  }, {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('userToken')
        }
    }).then((response) => {
    
    if(response){
      message.value = response.data.message;
      TaskName.value = "";
      TaskDesc.value = "";
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
          <div class="col-md-6">
            <div class="createTask">
                <h3>Create Task</h3><hr>
                <form @submit.prevent="createTask()">

                    <div v-if="message != ''" class="alert alert-success">
                      {{ message }}
                    </div>

                    <div v-if="error != ''" class="alert alert-danger">
                      {{ error }}
                    </div>
                    <div class="mb-3">
                        <label for="">Task Name</label>
                        <input type="text" class="form-control" v-model="TaskName">
                    </div>

                    <div class="mb-3">
                        <label for="">Task Description</label>
                        <textarea name="" class="form-control" v-model="TaskDesc" id="" cols="30" rows="10"></textarea>
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-success me-3">Submit</button>
                        <RouterLink to="/task"><button class="btn btn-primary">Go Back</button></RouterLink>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
