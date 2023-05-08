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
                                        'text-danger': errors.vehiculo_id,
                                    }"
                                    >Seleccionar vehículo*</label
                                >
                                <el-select
                                    class="d-block"
                                    :class="{
                                        'is-invalid': errors.vehiculo_id,
                                    }"
                                    v-model="faq.vehiculo_id"
                                    clearable
                                >
                                    <el-option
                                        v-for="(item, index) in listVehiculos"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.full_name"
                                    >
                                    </el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.vehiculo_id"
                                    v-text="errors.vehiculo_id[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.caracteristica_id,
                                    }"
                                    >Seleccionar característica de
                                    vehículo*</label
                                >
                                <el-select
                                    class="d-block"
                                    :class="{
                                        'is-invalid': errors.caracteristica_id,
                                    }"
                                    v-model="faq.caracteristica_id"
                                    clearable
                                >
                                    <el-option
                                        v-for="(
                                            item, index
                                        ) in listCaracteristicas"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.caracteristica"
                                    >
                                    </el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.caracteristica_id"
                                    v-text="errors.caracteristica_id[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label
                                    :class="{
                                        'text-danger': errors.pregunta,
                                    }"
                                    >Pregunta FAQs*</label
                                >
                                <el-input
                                    type="textarea"
                                    autosize
                                    placeholder="Pregunta FAQs*"
                                    :class="{
                                        'is-invalid': errors.pregunta,
                                    }"
                                    v-model="faq.pregunta"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.pregunta"
                                    v-text="errors.pregunta[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label
                                    :class="{
                                        'text-danger': errors.respuesta,
                                    }"
                                    >Respuesta FAQs*</label
                                >
                                <vue-editor
                                    v-model="faq.respuesta"
                                    :editorConfig="editorConfig"
                                    class="editor_texto"
                                ></vue-editor>

                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.respuesta"
                                    v-text="errors.respuesta[0]"
                                ></span>
                            </div>
                            <div class="col-md-12"></div>
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
import { VueEditor, Quill } from "vue2-editor";

export default {
    components: {
        VueEditor,
    },
    props: {
        muestra_modal: {
            type: Boolean,
            default: false,
        },
        accion: {
            type: String,
            default: "nuevo",
        },
        faq: {
            type: Object,
            default: {
                id: 0,
                vehiculo_id: "",
                caracteristica_id: "",
                pregunta: "",
                respuesta: "",
            },
        },
    },
    watch: {
        muestra_modal: function (newVal, oldVal) {
            this.errors = [];
            if (newVal) {
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
            listVehiculos: [],
            listCaracteristicas: [],
            editorConfig: {
                placeholder: "Insert text here...",
                modules: {
                    toolbar: [
                        [{ header: [1, 2, false] }],
                        ["bold", "italic", "underline", "strike"],
                        [{ color: [] }, { background: [] }],
                        [{ align: [] }],
                        [{ list: "ordered" }, { list: "bullet" }],
                        ["link", "image"],
                    ],
                    imageResize: {
                        displaySize: true,
                    },
                    imageDrop: true,
                },
            },
        };
    },
    mounted() {
        this.bModal = this.muestra_modal;
        this.getVehiculos();
        this.getCaracteristicas();
    },
    methods: {
        getVehiculos() {
            axios.get("/admin/vehiculos").then((response) => {
                this.listVehiculos = response.data.vehiculos;
            });
        },
        getCaracteristicas() {
            axios.get("/admin/caracteristica_vehiculos").then((response) => {
                this.listCaracteristicas =
                    response.data.caracteristica_vehiculos;
            });
        },
        setRegistroModal() {
            this.enviando = true;
            try {
                this.textoBtn = "Enviando...";
                let url = "/admin/faqs";
                let config = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                let formdata = new FormData();
                formdata.append(
                    "vehiculo_id",
                    this.faq.vehiculo_id ? this.faq.vehiculo_id : ""
                );
                formdata.append(
                    "caracteristica_id",
                    this.faq.caracteristica_id ? this.faq.caracteristica_id : ""
                );
                formdata.append(
                    "pregunta",
                    this.faq.pregunta ? this.faq.pregunta : ""
                );
                formdata.append(
                    "respuesta",
                    this.faq.respuesta ? this.faq.respuesta : ""
                );

                if (this.accion == "edit") {
                    url = "/admin/faqs/" + this.faq.id;
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
                            this.limpiaFaq();
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
        limpiaFaq() {
            this.errors = [];
            this.faq.vehiculo_id = "";
            this.faq.caracteristica_id = "";
            this.faq.pregunta = "";
            this.faq.respuesta = "";
        },
    },
};
</script>

<style>
.editor_texto {
    position: relative;
}

.ql-container {
    overflow: auto;
    height: 70vh!important;
}

iframe.ql-video {
    width: 100%;
    height: 400px;
}
</style>
