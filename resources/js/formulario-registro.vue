<template>
    <div class="text-white">
        <h4 class="text-white text-center">Registro de visitante</h4>
        <p class="login-box-msg text-white font-weight-bold">
            Ingresa tus datos
        </p>
        <div class="form-group">
            <label>Nombre:</label>
            <input
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.nombre }"
                placeholder="Nombre"
                v-model="oVisitante.nombre"
                @keypress.enter="registro()"
                autofocus
            />
            <span
                class="error invalid-feedback"
                v-if="errors.nombre"
                v-text="errors.nombre[0]"
            ></span>
        </div>
        <div class="form-group">
            <label>Correo electrónico:</label>
            <input
                type="text"
                class="form-control"
                :class="{ 'is-invalid': errors.correo }"
                placeholder="Correo electrónico"
                v-model="oVisitante.correo"
                @keypress.enter="registro()"
            />
            <span
                class="error invalid-feedback"
                v-if="errors.correo"
                v-text="errors.correo[0]"
            ></span>
        </div>

        <div class="form-group">
            <label>Contraseña:</label>
            <input
                type="password"
                class="form-control"
                :class="{ 'is-invalid': errors.password }"
                placeholder="Contraseña"
                v-model="oVisitante.password"
                @keypress.enter="registro()"
            />
            <span
                class="error invalid-feedback"
                v-if="errors.password"
                v-text="errors.password[0]"
            ></span>
        </div>

        <div class="form-group">
            <label>Repite la contraseña:</label>
            <input
                type="password"
                class="form-control"
                :class="{ 'is-invalid': errors.password_confirmation }"
                placeholder="Repite la contraseña"
                v-model="oVisitante.password_confirmation"
                @keypress.enter="registro()"
            />
            <span
                class="error invalid-feedback"
                v-if="errors.password_confirmation"
                v-text="errors.password_confirmation[0]"
            ></span>
        </div>
        <div class="row">
            <!-- /.col -->
            <div class="col-12">
                <button
                    type="button"
                    class="btn btn-primary btn-block btn-flat font-weight-bold"
                    @click.prevent="registro()"
                    v-loading.fullscreen.lock="fullscreenLoading"
                >
                    Enviar
                </button>
                <a href="/" class="btn secondary btn-flat btn-block"
                    >Iniciar sesión</a
                >
                <a href="/" class="btn btn-default btn-flat btn-block"
                    >Volver al inicio</a
                >
            </div>
        </div>
    </div>
</template>

<script>
export default {
    /* valores a ejecutar
        1: recarga depagina
        2: redireccion al inicio
    */
    props: ["accion_despues_registro"],
    data() {
        return {
            oVisitante: {
                nombre: "",
                correo: "",
                password: "",
                password_confirmation: "",
            },
            fullscreenLoading: false,
            errors: [],
        };
    },
    methods: {
        registro() {
            this.fullscreenLoading = true;
            axios
                .post("/registro", this.oVisitante)
                .then((res) => {
                    this.errors = [];
                    // let user = res.data.user;
                    this.fullscreenLoading = false;
                    Swal.fire({
                        icon: "success",
                        title: "Registro éxitoso",
                        // title: res.data.msj,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    if (this.accion_despues_registro == 1) {
                        window.location.reload();
                    }
                    if (this.accion_despues_registro == 2) {
                        window.location.href = "/";
                    }
                })
                .catch((error) => {
                    this.fullscreenLoading = false;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        if (error.response && error.response.data.message) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: error.response.data.message,
                                showConfirmButton: false,
                                timer: 2000,
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: "Ocurrió un error inesperado, intentes mas tarde por favor",
                                showConfirmButton: false,
                                timer: 2000,
                            });
                        }
                    }
                });
        },
    },
};
</script>

<style></style>
