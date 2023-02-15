<template>
    <div>
        <h3 class="text-center">Adicionar novo Paciente</h3>
        <form @submit.prevent="addPatient">
            <div class="row  container justify-content-center pt-3 w-100">
                <div class="col-lg-2">
                    <img width="250px" height="150px" id="preview" v-if="patient.url_picture" :src="patient.url_picture"
                        class="rounded-circle">
                    <svg v-show="showTempSvg" id="photo_profile" class="rounded-circle" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
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
                            <date-picker  v-model="patient.birthdate" valueType="format" format="DD/MM/YYYY"></date-picker>
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
                            <input :id="'zip_code'" @change="searchZipCode($event)" type="text"
                                class="form-control" v-mask="'#####-###'" v-model="patient.address.zip_code">
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Cidade</label>
                            <input :id="'city'" type="text" class="form-control" v-model="patient.address.city">
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Cidade</label>
                            <input :id="'state'" type="text" class="form-control" v-model="patient.address.state">
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Rua</label>
                            <input :id="'street'" type="text" class="form-control" v-model="patient.address.street">
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Número</label>
                            <input :id="'number'" type="text" class="form-control" v-model="patient.address.number">
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Bairro</label>
                            <input :id="'neighborhood'" type="text" class="form-control"
                                v-model="patient.address.neighborhood">
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="form-group">
                            <label>Complemento</label>
                            <input :id="'complement'" type="text" class="form-control"
                                v-model="patient.complement">
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
        components: {
            DatePicker
        },
        data() {
            return {
                patient: {
                    'street': '',
                    'url_picture' : '',
                    'name': '',
                    'mother_name': '',
                    'birthdate': '',
                    'cpf': '',
                    'cns': '',
                    'picture': '',
                    'address' : {
                        'zip_code': '',
                        'city': '',
                        'street': '',
                        'neighborhood': '',
                        'number': '',
                        'complement': '',
                        'state': '',
                    }
                },
                url_picture: '',
                showTempSvg: true,
                time1: null,
            }
        },
        methods: {
            addPatient() {
                let data = new FormData();
                
                //loop through object and load form data
                Object.entries(this.patient).forEach(([key, value]) => {
                    data.append(`${key}`, value);
                });

                Object.entries(this.patient.address).forEach(([key, value]) => {
                    data.append(`address[${key}]`, value);
                });
               
                this.axios
                    .post('http://127.0.0.1:8080/api/paciente', data, {
                        headers: {
                            'Content-Type': `multipart/form-data`,
                        }
                    })
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
                    })
                    .finally(function(data) {
                        console.log(data);
                    })
            },

            searchZipCode(event) {
                let response = this.axios
                    .get(`http://127.0.0.1:8080/api/cep/${this.patient.address.zip_code}`)
                    .then(response => {
                        if (response.status === 200) {
                            let data = response.data.data;
                            this.patient.address.street = data.logradouro;
                            this.patient.address.complement = data.complemento;
                            this.patient.address.neighborhood = data.bairro;
                            this.patient.address.city = data.localidade;
                            this.patient.address.state = data.uf;
                        } else {

                        }
                    })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)

                console.log(response);
            },
            changePhoto(event) {
                const file = event.target.files[0];
                this.patient.picture = event.target.files[0];
                this.patient.url_picture = URL.createObjectURL(file);
                this.showTempSvg = false;
            }

        }
    }
</script>
