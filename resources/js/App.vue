<template>
    <div class="container"> 
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse ">
                <div class="navbar-nav">
                    <router-link to="/" class="nav-item nav-link"><button class="btn btn-sm btn-primary">Listagem de Pacientes</button></router-link>
                    <router-link to="/create" class="nav-item nav-link"> <button class="btn btn-sm btn-info">Adicionar novo</button></router-link>
                </div>
            </div>
        </nav>
        <router-view> </router-view>
    </div>
</template>
 
<script>
    export default {}
</script>