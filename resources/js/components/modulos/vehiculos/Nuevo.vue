<template>
    <div
        class="modal fade"
        :class="{ show: bModal }"
        id="modal-default"
        aria-modal="true"
        role="dialog"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                        @click="cierraModal"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.marca_id,
                                    }"
                                    >Seleccionar marca*</label
                                >
                                <el-select
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid': errors.marca_id,
                                    }"
                                    v-model="vehiculo.marca_id"
                                    filterable
                                    clearable
                                >
                                    <el-option
                                        v-for="(item, index) in listMarcas"
                                        :key="index"
                                        :value="item.id"
                                        :label="item.marca"
                                    >
                                    </el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.marca_id"
                                    v-text="errors.marca_id[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.tipo_id,
                                    }"
                                    >Seleccionar tipo*</label
                                >
                                <el-select
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid': errors.tipo_id,
                                    }"
                                    v-model="vehiculo.tipo_id"
                                    filterable
                                    clearable
                                >
                                    <el-option
                                        v-for="(item, index) in listTipos"
                                        :key="index"
                                        :value="item.id"
                                        :label="item.tipo"
                                    >
                                    </el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.tipo_id"
                                    v-text="errors.tipo_id[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.anio_id,
                                    }"
                                    >Seleccionar año*</label
                                >
                                <el-select
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid': errors.anio_id,
                                    }"
                                    v-model="vehiculo.anio_id"
                                    filterable
                                    clearable
                                >
                                    <el-option
                                        v-for="(item, index) in listAnios"
                                        :key="index"
                                        :value="item.id"
                                        :label="item.anio"
                                    >
                                    </el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.anio_id"
                                    v-text="errors.anio_id[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.modelo_id,
                                    }"
                                    >Seleccionar modelo*</label
                                >
                                <el-select
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid': errors.modelo_id,
                                    }"
                                    v-model="vehiculo.modelo_id"
                                    filterable
                                    clearable
                                >
                                    <el-option
                                        v-for="(item, index) in listModelos"
                                        :key="index"
                                        :value="item.id"
                                        :label="item.modelo"
                                    >
                                    </el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.modelo_id"
                                    v-text="errors.modelo_id[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.descripcion,
                                    }"
                                    >Descripción*</label
                                >
                                <el-input
                                    type="textarea"
                                    autosize
                                    placeholder="Descripción"
                                    :class="{
                                        'is-invalid': errors.descripcion,
                                    }"
                                    v-model="vehiculo.descripcion"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.descripcion"
                                    v-text="errors.descripcion[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.imagen,
                                    }"
                                    >Imagen referencial</label
                                >
                                <input
                                    type="file"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': errors.imagen,
                                    }"
                                    ref="input_file"
                                    @change="cargaImagen"
                                />
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.imagen"
                                    v-text="errors.imagen[0]"
                                ></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-dismiss="modal"
                        @click="cierraModal"
                    >
                        Cerrar
                    </button>
                    <el-button
                        type="primary"
                        class="bg-primary"
                        :loading="enviando"
                        @click="setRegistroModal()"
                        >{{ textoBoton }}</el-button
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        muestra_modal: {
            type: Boolean,
            default: false,
        },
        accion: {
            type: String,
            default: "nuevo",
        },
        vehiculo: {
            type: Object,
            default: {
                id: 0,
                marca_id: "",
                tipo_id: "",
                anio_id: "",
                modelo_id: "",
                descripcion: "",
                imagen: null,
            },
        },
    },
    watch: {
        muestra_modal: function (newVal, oldVal) {
            this.errors = [];
            if (newVal) {
                this.$refs.input_file.value = null;
                this.bModal = true;
            } else {
                this.bModal = false;
            }
        },
    },
    computed: {
        tituloModal() {
            if (this.accion == "nuevo") {
                return "NUEVO REGISTRO";
            } else {
                return "MODIFICAR REGISTRO";
            }
        },
        textoBoton() {
            if (this.accion == "nuevo") {
                return "Registrar";
            } else {
                return "Actualizar";
            }
        },
    },
    data() {
        return {
            user: JSON.parse(localStorage.getItem("user")),
            bModal: this.muestra_modal,
            enviando: false,
            errors: [],
            listMarcas: [],
            listTipos: [],
            listAnios: [],
            listModelos: [],
        };
    },
    mounted() {
        this.bModal = this.muestra_modal;
        this.getMarcas();
        this.getTipos();
        this.getAnios();
        this.getModelos();
    },
    methods: {
        cargaImagen(e) {
            this.vehiculo.imagen = e.target.files[0];
        },
        getMarcas() {
            axios.get("/admin/marcas").then((response) => {
                this.listMarcas = response.data.marcas;
            });
        },
        getTipos() {
            axios.get("/admin/tipos").then((response) => {
                this.listTipos = response.data.tipos;
            });
        },
        getAnios() {
            axios.get("/admin/anios").then((response) => {
                this.listAnios = response.data.anios;
            });
        },
        getModelos() {
            axios.get("/admin/modelos").then((response) => {
                this.listModelos = response.data.modelos;
            });
        },
        setRegistroModal() {
            this.enviando = true;
            try {
                this.textoBtn = "Enviando...";
                let url = "/admin/vehiculos";
                let config = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                let formdata = new FormData();

                formdata.append(
                    "marca_id",
                    this.vehiculo.marca_id ? this.vehiculo.marca_id : ""
                );
                formdata.append(
                    "tipo_id",
                    this.vehiculo.tipo_id ? this.vehiculo.tipo_id : ""
                );
                formdata.append(
                    "anio_id",
                    this.vehiculo.anio_id ? this.vehiculo.anio_id : ""
                );
                formdata.append(
                    "modelo_id",
                    this.vehiculo.modelo_id ? this.vehiculo.modelo_id : ""
                );
                formdata.append(
                    "descripcion",
                    this.vehiculo.descripcion ? this.vehiculo.descripcion : ""
                );
                formdata.append(
                    "imagen",
                    this.vehiculo.imagen ? this.vehiculo.imagen : ""
                );

                if (this.accion == "edit") {
                    url = "/admin/vehiculos/" + this.vehiculo.id;
                    formdata.append("_method", "PUT");
                }
                axios
                    .post(url, formdata, config)
                    .then((res) => {
                        this.enviando = false;
                        if (res.data.sw) {
                            Swal.fire({
                                icon: "success",
                                title: res.data.msj,
                                showConfirmButton: false,
                                timer: 1500,
                            });
                            this.limpiaVehiculo();
                            this.$emit("envioModal");
                            this.errors = [];
                            if (this.accion == "edit") {
                                this.textoBtn = "Actualizar";
                            } else {
                                this.textoBtn = "Registrar";
                            }
                        } else {
                            Swal.fire({
                                icon: "info",
                                title: "Atención",
                                html: res.data.msj,
                                showConfirmButton: false,
                                timer: 2000,
                            });
                        }
                    })
                    .catch((error) => {
                        this.enviando = false;
                        if (this.accion == "edit") {
                            this.textoBtn = "Actualizar";
                        } else {
                            this.textoBtn = "Registrar";
                        }
                        if (error.response) {
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors;
                            }
                            if (
                                error.response.status === 420 ||
                                error.response.status === 419 ||
                                error.response.status === 401
                            ) {
                                window.location = "/";
                            }
                            if (error.response.status === 500) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    html: error.response.data.message,
                                    showConfirmButton: false,
                                    timer: 2000,
                                });
                            }
                        }
                    });
            } catch (e) {
                this.enviando = false;
                console.log(e);
            }
        },
        // Dialog/modal
        cierraModal() {
            this.bModal = false;
            this.$emit("close");
        },
        limpiaVehiculo() {
            this.errors = [];
            this.vehiculo.marca_id = "";
            this.vehiculo.tipo_id = "";
            this.vehiculo.anio_id = "";
            this.vehiculo.modelo_id = "";
            this.vehiculo.descripcion = "";
            this.vehiculo.imagen = null;
        },
    },
};
</script>

<style></style>
