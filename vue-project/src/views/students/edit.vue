<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h4>Add Student Data</h4>
      </div>
      <div class="card-body">
        <ul class="alert alert-warning" v-if="Object.keys(this.errorList).length > 0">
          <li class="mb-0 ms-3" v-for="(error, index) in this.errorList" :key="index">
            {{ error[0] }}
          </li>
        </ul>
        <div class="mb-3">
          <label for="">Name</label>
          <input type="text" v-model="model.student.name" class="form-control" />
        </div>
        <div class="mb-3">
          <label for="">Email</label>
          <input type="email" v-model="model.student.email" class="form-control" />
        </div>
        <div class="mb-3">
          <label for="">Phone</label>
          <input type="phone" v-model="model.student.phone" class="form-control" />
        </div>
        <div class="mb-3">
          <label for="">Course</label>
          <input type="text" v-model="model.student.course" class="form-control" />
        </div>
        <div class="mb-3">
          <button type="button" @click="updateBtn" class="btn btn-primary">update</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "studentsEdit",
  data() {
    return {
      studentID: "",
      errorList: "",
      model: {
        student: {
          name: "",
          email: "",
          course: "",
          phone: "",
        },
      },
    };
  },
  mounted() {
    this.getstudentData(this.$route.params.id);
    this.studentID = this.$route.params.id;
  },
  methods: {
    getstudentData(studentID) {
      axios
        .get(`http://localhost:8000/api/students/${studentID}/edit`)
        .then((res) => {
          console.log(res.data.student);
          this.model.student = res.data.student;
        })
        .catch(function (error) {
          if (error.response) {
            if (error.response.status == 404) {
              alert(error.response.data.message);
            }
          }
        });
    },
    updateBtn() {
      var mydata = this;
      axios
        .put(
          `http://localhost:8000/api/students/${this.studentID}/update`,
          this.model.student
        )
        .then((res) => {
          console.log(res.data);
          alert(res.data.message);
          this.errorList = "";
        })
        .catch(function (error) {
          if (error.response) {
            if (error.response.status == 422) {
              mydata.errorList = alert(error.response.data.errors);
            }
            if (error.response.status == 404) {
              alert(error.response.data.message);
            }
            // console.log(error.response.data);
            // console.log(error.response.status);
            // console.log(error.response.headers);
          } else if (error.request) {
            console.log(error.request);
          } else {
            console.log("Error", error.message);
          }
        });
    },
  },
};
</script>
