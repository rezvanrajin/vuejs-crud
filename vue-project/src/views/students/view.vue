<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h4>
          Student
          <RouterLink to="/students/create" class="btn btn-primary float-end"
            >Add Student</RouterLink
          >
        </h4>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Course</th>
              <th>Created</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody v-if="this.students.length > 0">
            <tr v-for="(student, index) in this.students" :key="index">
              <td>{{ student.id }}</td>
              <td>{{ student.name }}</td>
              <td>{{ student.email }}</td>
              <td>{{ student.phone }}</td>
              <td>{{ student.course }}</td>
              <td>{{ student.created_at }}</td>
              <td>
                <RouterLink
                  :to="{ path: '/students/' + student.id + '/edit' }"
                  class="btn btn-success"
                  >Edit</RouterLink
                >
                <button
                  type="button"
                  @click="deletebtn(student.id)"
                  class="btn btn-danger"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr>
              <td col="7">Loading..</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "students",
  data() {
    return {
      students: [],
    };
  },

  mounted() {
    this.getStudents();
  },
  methods: {
    getStudents() {
      axios.get("http://localhost:8000/api/students").then((res) => {
        this.students = res.data.students;
        console.log(this.students);
      });
    },
    deletebtn(studentID) {
      if (confirm("Are You want to delete data??")) {
        axios
          .delete(`http://localhost:8000/api/students/${studentID}/delete`)
          .then((res) => {
            alert(res.data.message);
            this.getStudents();
          })
          .catch(function (error) {
            if (error.response) {
              if (error.response.status == 404) {
                alert(error.response.data.message);
              }
            }
          });
      }
    },
  },
};
</script>
