<template>
    <div>
        <h3 class="text-center">Adicionar novo Paciente</h3>
        <form @submit.prevent="addpPatient">
            <div class="row  container justify-content-center pt-3 w-100">
                <div class="col-lg-2">
                    <img  width="250px" height="150px" id="preview" v-if="url_picture" :src="url_picture"  class="rounded-circle">
                    <svg v-show="showTempSvg" id="photo_profile" class="rounded-circle" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <div class="pt-3">
                        <input :id="'picture'" @change="changePhoto($event)" type="file">                   
                    </div>
                </div>
            </div>
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
                            <date-picker v-mask="'####-##-##'" v-model="time1" valueType="format"></date-picker>
                        </div>
                    </div>

                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Cpf</label>
                            <input type="text" class="form-control" v-mask="'###.###.###-##'" v-model="patient.cpf">
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
                            <label>Cep</label>
                            <input :id="'cep'" @change="searchCep($event)" type="text" class="form-control" v-mask="'#####-###'" v-model="patient.cep">
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Cidade</label>
                            <input :id="'city'" type="text" class="form-control" v-model="patient.city">
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Cidade</label>
                            <input :id="'state'" type="text" class="form-control" v-model="patient.state">
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Rua</label>
                            <input :id="'street'" type="text" class="form-control" v-model="patient.street">
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Bairro</label>
                            <input :id="'neithbodhood'" type="text" class="form-control" v-model="patient.neighborhood">
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Número</label>
                            <input :id="'number'" type="text" class="form-control" v-model="patient.number">
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Complemento</label>
                            <input :id="'complement'" type="text" class="form-control" v-model="patient.complement">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row  container justify-content-center pt-3 ">
                <div class="col-lg-2 text-center">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
                
            </div>
        </form>
    </div>
</template>
 
<script>
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';

    export default {
        components: { DatePicker },
        data() {
            return {
                patient: {
                    'street' : '',
                    'name' : '',
                    'state': '',
                    'mother_name' : '',
                    'birthdate' : '',
                    'cpf' : '',
                    'cns' : '',
                    'cep' : '',
                    'city' : '',
                    'street' : '',
                    'neithbodhood' : '',
                    'number' : '',
                    'complement' : '',
                    'picture': '',
                   
                },
                url_picture: '',
                showTempSvg: true,
                time1: null,
            }
        },
        methods: {
            addpPatient() {
                let data = new FormData();
                data.append('picture', this.patient.picture);

                this.axios
                    .post('http://localhost:8000/api/paciente', data, {
                        headers: {
                            'Content-Type': `multipart/form-data32323`,
                        }
                    })
                    .then(response => {
                        console.log(response.data)
                        if(response.status === 200){

                        }else{
                            console.log('erro');
                            return;
                            
                        } 
                        console.log('aq');
                        //this.$router.push({ name: 'home' })
                    })
                    .catch(err => {
                        if(err.response.status == 422) {
                            let message = err.response.data.message;
                            Object.entries(err.response.data.errors).forEach(([key, error]) => {
                                error.map((message) => {
                                    console.log(message);
                                });
                            });
                            
                        }
                    })
                    .finally(function(data){
                        console.log(data);
                    })

                    
            },

            searchCep(event){
                let response =  this.axios
                    .get(`http://localhost:8000/api/cep/${this.patient.cep}`)
                    .then(response => {
                        if(response.status === 200){
                            let data = response.data.data;
                            this.patient.street = data.logradouro;
                            this.patient.complement = data.complemento;
                            this.patient.neithbodhood = data.bairro;
                            this.patient.city = data.localidade;
                            this.patient.state = data.uf;
                        }else{

                        }
                    })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)

                console.log(response);
            },
            changePhoto(event){
                const file = event.target.files[0];
                this.patient.picture = event.target.files[0];
                this.url_picture = URL.createObjectURL(file);
                this.showTempSvg = false;
            }

        }
    }
</script>
