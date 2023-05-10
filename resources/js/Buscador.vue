<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 bg-primary p-5 border-top">
                <form action="">
                    <h5 class="text-center text-white">
                        ¿TIENÉS ALGUNA CONSULTA?
                    </h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-groy">
                                <label>Marca</label>
                                <el-select
                                    class="d-block"
                                    placeholder="Marca"
                                    filterable
                                >
                                    <el-option
                                        v-for="(item, index) in listMarcas"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.marca"
                                    ></el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-groy">
                                <label>Modelo</label>
                                <el-select
                                    class="d-block"
                                    placeholder="Modelo"
                                    filterable
                                >
                                    <el-option
                                        v-for="(item, index) in listModelos"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.modelo"
                                    ></el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-groy">
                                <label>Tipo</label>
                                <el-select
                                    class="d-block"
                                    placeholder="Tipo"
                                    filterable
                                >
                                    <el-option
                                        v-for="(item, index) in listTipos"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.tipo"
                                    ></el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-groy">
                                <label>Año</label>
                                <el-select
                                    class="d-block"
                                    placeholder="Año"
                                    filterable
                                >
                                    <el-option
                                        v-for="(item, index) in listAnios"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.anio"
                                    ></el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center text-primary">
                            RESULTADOS DE BÚSQUEDA
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            error: false,
            fullscreenLoading: false,
            listMarcas: [],
            listModelos: [],
            listTipos: [],
            listAnios: [],
        };
    },
    mounted() {
        this.getMarcas();
        this.getModelos();
        this.getTipos();
        this.getAnios();
    },
    methods: {
        getMarcas() {
            axios.get("/marcas/getMarcas").then((response) => {
                this.listMarcas = response.data.marcas;
            });
        },
        getModelos() {
            axios.get("/modelos/getModelos").then((response) => {
                this.listModelos = response.data.modelos;
            });
        },
        getTipos() {
            axios.get("/tipos/getTipos").then((response) => {
                this.listTipos = response.data.tipos;
            });
        },
        getAnios() {
            axios.get("/anios/getAnios").then((response) => {
                this.listAnios = response.data.anios;
            });
        },
    },
};
</script>

<style></style>
