<template>
    <div>
        <h2 class="text-center">Listagem de Pacientes</h2>
        <div class="table-responsive-lg">
            <table class="table table-striped">
                <thead class="thead-dark">
                <tr>
                    <th width="10%">ID</th>
                    <th width="40%">Name</th>
                    <th width="20%">Status</th>
                    <th width="30%">Ações</th>
                </tr>
                </thead>
                <tbody>
                <tr  v-for="patient in patients" :key="patient.id">
                    <td class="">{{ patient.id }}</td>
                    <td>{{ patient.name }}</td>
                    <td> 
                        <span v-if="patient.deleted === true" class="badge badge-secondary" style="background-color:red">Inativo</span>
                        <span v-if="patient.deleted === false" class="badge badge-secondary" style="background-color:green">Ativo</span>
                    </td>
                    <td>
                        <div class="" role="group">
                            <router-link v-if="patient.deleted === false" :to="{name: 'edit', params: { id: patient.id }}" class="btn btn-success">Edit</router-link>
                            <button v-if="patient.deleted === false" class="btn btn-danger" @click="inactivePatient(patient.id)">Inativar</button>
                            <button v-if="patient.deleted === true" class="btn btn-info" @click="activatePatient(patient.id)">Ativar</button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
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
                .get('http://127.0.0.1:8080/api/paciente/')
                .then(response => {
                    this.patients = response.data;
                })
                .catch(err => {
                    let message = err.response.data.message;
                    let errors = '';
                    if (err.response.status == 422) {
                        if(err.response.data.errors){
                            Object.entries(err.response.data.errors).forEach(([key, error]) => {
                                error.map((message) => {
                                    errors += `${message}<br>`;
                                });
                            });
                        }

                    }

                    this.$swal(message, errors, 'info');
                });
        },
        methods: {
            inactivePatient(id) { 
                this.axios
                    .delete(`http://127.0.0.1:8080/api/paciente/${id}`)
                    .then(response => {
                        // let i = this.patients.map(data => data.id).indexOf(id);
                        // this.patients.splice(i, 1)
                        if (response.status === 200) {
                            let data = response.data;
                            this.$swal(data.message,'',  'success').then(response => {
                                this.$router.push({ name: 'home' })
                            });
                        } 
                    }).catch(err => {
                        let message = err.response.data.message;
                        let errors = '';
                        if (err.response.status == 422) {
                            if(err.response.data.errors){
                                Object.entries(err.response.data.errors).forEach(([key, error]) => {
                                    error.map((message) => {
                                        errors += `${message}<br>`;
                                    });
                                });
                            }

                        }

                        this.$swal(message, errors, 'info');
                    });
                this.getPatients();    
                
            },
            activatePatient(id) { 
                this.axios
                    .post(`http://127.0.0.1:8080/api/paciente/activate/${id}`)
                    .then(response => {
                        if (response.status === 200) {
                            let data = response.data;
                            this.$swal(data.message,'',  'success').then(response => {
                                this.$router.push({ name: 'home' })
                            });
                        } 
                    })
                    .catch(err => {
                        let message = err.response.data.message;
                        let errors = '';
                        if (err.response.status == 422) {
                            if(err.response.data.errors){
                                Object.entries(err.response.data.errors).forEach(([key, error]) => {
                                    error.map((message) => {
                                        errors += `${message}<br>`;
                                    });
                                });
                            }

                        }

                        this.$swal(message, errors, 'info');
                    });
                this.getPatients();    
                
            },
            getPatients(){
                this.axios
                    .get('http://127.0.0.1:8080/api/paciente/')
                    .then(response => {
                        this.patients = response.data;
                    });
            }
        }
    }
</script>