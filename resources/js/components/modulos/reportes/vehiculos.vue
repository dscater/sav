<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Reportes - Lista de Vehículos</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="ml-auto mr-auto col-md-5">
                                    <form>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label
                                                    :class="{
                                                        'text-danger':
                                                            errors.filtro,
                                                    }"
                                                    >Seleccione*</label
                                                >
                                                <el-select
                                                    v-model="oReporte.filtro"
                                                    filterable
                                                    placeholder="Seleccione"
                                                    class="d-block"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.filtro,
                                                    }"
                                                >
                                                    <el-option
                                                        v-for="item in listFiltro"
                                                        :key="item"
                                                        :label="item"
                                                        :value="item"
                                                    >
                                                    </el-option>
                                                </el-select>
                                                <span
                                                    class="error invalid-feedback"
                                                    v-if="errors.filtro"
                                                    v-text="errors.filtro[0]"
                                                ></span>
                                            </div>
                                        </div>
                                        <div
                                            class="row"
                                            v-if="oReporte.filtro == 'Filtrar'"
                                        >
                                            <div class="form-group col-md-12">
                                                <label
                                                    :class="{
                                                        'text-danger':
                                                            errors.marca,
                                                    }"
                                                    >Marca*</label
                                                >
                                                <el-select
                                                    v-model="oReporte.marca"
                                                    filterable
                                                    placeholder="Seleccione"
                                                    class="d-block"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.marca,
                                                    }"
                                                >
                                                    <el-option
                                                        v-for="item in listMarcas"
                                                        :key="item.id"
                                                        :value="item.id"
                                                        :label="item.marca"
                                                    >
                                                    </el-option>
                                                </el-select>
                                                <span
                                                    class="error invalid-feedback"
                                                    v-if="errors.marca"
                                                    v-text="errors.marca[0]"
                                                ></span>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label
                                                    :class="{
                                                        'text-danger':
                                                            errors.tipo,
                                                    }"
                                                    >Tipo*</label
                                                >
                                                <el-select
                                                    v-model="oReporte.tipo"
                                                    filterable
                                                    placeholder="Seleccione"
                                                    class="d-block"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.tipo,
                                                    }"
                                                >
                                                    <el-option
                                                        v-for="item in listTipos"
                                                        :key="item.id"
                                                        :value="item.id"
                                                        :label="item.tipo"
                                                    >
                                                    </el-option>
                                                </el-select>
                                                <span
                                                    class="error invalid-feedback"
                                                    v-if="errors.tipo"
                                                    v-text="errors.tipo[0]"
                                                ></span>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label
                                                    :class="{
                                                        'text-danger':
                                                            errors.modelo,
                                                    }"
                                                    >Modelo*</label
                                                >
                                                <el-select
                                                    v-model="oReporte.modelo"
                                                    filterable
                                                    placeholder="Seleccione"
                                                    class="d-block"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.modelo,
                                                    }"
                                                >
                                                    <el-option
                                                        v-for="item in listModelos"
                                                        :key="item.id"
                                                        :value="item.id"
                                                        :label="item.modelo"
                                                    >
                                                    </el-option>
                                                </el-select>
                                                <span
                                                    class="error invalid-feedback"
                                                    v-if="errors.modelo"
                                                    v-text="errors.modelo[0]"
                                                ></span>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label
                                                    :class="{
                                                        'text-danger':
                                                            errors.anio,
                                                    }"
                                                    >Año*</label
                                                >
                                                <el-select
                                                    v-model="oReporte.anio"
                                                    filterable
                                                    placeholder="Seleccione"
                                                    class="d-block"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.anio,
                                                    }"
                                                >
                                                    <el-option
                                                        v-for="item in listAnios"
                                                        :key="item.id"
                                                        :value="item.id"
                                                        :label="item.anio"
                                                    >
                                                    </el-option>
                                                </el-select>
                                                <span
                                                    class="error invalid-feedback"
                                                    v-if="errors.anio"
                                                    v-text="errors.anio[0]"
                                                ></span>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <el-button
                                                type="primary"
                                                class="bg-primary w-full"
                                                :loading="enviando"
                                                @click="generaReporte()"
                                                >{{ textoBtn }}</el-button
                                            >
                                        </div>
                                        <div class="col-md-12">
                                            <el-button
                                                type="default"
                                                class="w-full mt-1"
                                                @click="limpiarFormulario()"
                                                >Reiniciar</el-button
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loadingWindow: Loading.service({
                fullscreen: this.fullscreenLoading,
            }),
            errors: [],
            oReporte: {
                filtro: "Todos",
                marca: "Todos",
                tipo: "Todos",
                modelo: "Todos",
                anio: "Todos",
            },
            aFechas: [],
            enviando: false,
            textoBtn: "Generar Reporte",
            listFiltro: ["Todos", "Filtrar"],
            listTipos: ["ADMINISTRADOR", "MECÁNICO"],
            listMarcas: [],
            listTipos: [],
            listModelos: [],
            listAnios: [],
            errors: [],
        };
    },
    mounted() {
        this.loadingWindow.close();
        this.getMarcas();
        this.getTipos();
        this.getModelos();
        this.getAnios();
    },
    methods: {
        getMarcas() {
            axios.get("/admin/marcas").then((response) => {
                this.listMarcas = response.data.marcas;
                this.listMarcas.unshift({
                    id: "Todos",
                    marca: "Todos",
                });
            });
        },
        getTipos() {
            axios.get("/admin/tipos").then((response) => {
                this.listTipos = response.data.tipos;
                this.listTipos.unshift({
                    id: "Todos",
                    tipo: "Todos",
                });
            });
        },
        getModelos() {
            axios.get("/admin/modelos").then((response) => {
                this.listModelos = response.data.modelos;
                this.listModelos.unshift({
                    id: "Todos",
                    modelo: "Todos",
                });
            });
        },
        getAnios() {
            axios.get("/admin/anios").then((response) => {
                this.listAnios = response.data.anios;
                this.listAnios.unshift({
                    id: "Todos",
                    anio: "Todos",
                });
            });
        },
        limpiarFormulario() {
            this.oReporte.filtro = "Todos";
        },
        generaReporte() {
            this.enviando = true;
            let config = {
                responseType: "blob",
            };
            axios
                .post("/admin/reportes/vehiculos", this.oReporte, config)
                .then((res) => {
                    this.errors = [];
                    this.enviando = false;
                    let pdfBlob = new Blob([res.data], {
                        type: "application/pdf",
                    });
                    let urlReporte = URL.createObjectURL(pdfBlob);
                    window.open(urlReporte);
                })
                .catch(async (error) => {
                    let responseObj = await error.response.data.text();
                    responseObj = JSON.parse(responseObj);
                    console.log(error);
                    this.enviando = false;
                    if (error.response) {
                        if (error.response.status === 422) {
                            this.errors = responseObj.errors;
                        }
                        if (
                            error.response.status === 420 ||
                            error.response.status === 419 ||
                            error.response.status === 401
                        ) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: responseObj.message,
                                showConfirmButton: false,
                                timer: 2000,
                            });
                            window.location = "/";
                        }
                    }
                });
        },
    },
};
</script>

<style></style>
