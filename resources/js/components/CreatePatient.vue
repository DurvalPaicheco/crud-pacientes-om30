<template>
    <div>
        <h3 class="text-center">Create patient</h3>
        <form @submit.prevent="addpPatient">
            <div class="col-md-12">
                <div class="row ">
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Nome Completo</label>
                            <input type="text" class="form-control" v-model="patient.name">
                        </div>
                    </div>
                    
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Nome da Mãe</label>
                            <input type="text" class="form-control" v-model="patient.mother_name">
                        </div>
                    </div>

                    <div class="col-md-2 mt-2">
                        <div class="form-group">
                            <label>Data Nascimento</label>
                            <date-picker v-model="patient.birthdate" valueType="format"></date-picker>
                        </div>
                    </div>

                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Cpf</label>
                            <input type="text" class="form-control" v-model="patient.cpf">
                        </div>
                    </div>

                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>CNS</label>
                            <input type="text" class="form-control" v-model="patient.cns">
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <h3>Endereço</h3>
            <div class="col-md-12">
                <div class="row ">
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Cidade</label>
                            <input type="text" class="form-control" v-model="patient.city">
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Rua</label>
                            <input type="text" class="form-control" v-model="patient.street">
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Bairro</label>
                            <input type="text" class="form-control" v-model="patient.neighborhood">
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Número</label>
                            <input type="text" class="form-control" v-model="patient.number">
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Complemento</label>
                            <input type="text" class="form-control" v-model="patient.complement">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row  container justify-content-center pt-3 ">
                <div class="col-lg-2">
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </div>
                
            </div>
        </form>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                patient: {}
            }
        },
        methods: {
            addpPatient() {
                this.axios
                    .post('http://localhost:8000/api/paciente', this.patient)
                    .then(response => (
                        this.$router.push({ name: 'home' })
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            }
        }
    }
</script>