<template>
    <div>
        <h2 class="text-center">Listagem de Pacientes</h2>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Detail</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="patient in patients" :key="patient.id">
                <td>{{ patient.id }}</td>
                <td>{{ patient.name }}</td>
                <td>{{ patient.detail }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'edit', params: { id: patient.id }}" class="btn btn-success">Edit</router-link>
                        <button class="btn btn-danger" @click="deletepatient(patient.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                patients: []
            }
        },
        created() {
            this.axios
                .get('http://localhost:8000/api/paciente/')
                .then(response => {
                    this.patients = response.data;
                });
        },
        methods: {
            deletepatient(id) { 
                this.axios
                    .delete(`http://localhost:8000/api/paciente/${id}`)
                    .then(response => {
                        let i = this.patients.map(data => data.id).indexOf(id);
                        this.patients.splice(i, 1)
                    });
            }
        }
    }
</script>