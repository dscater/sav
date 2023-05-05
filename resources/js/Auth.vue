<template>
    <div class="login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card border border-primary">
                <div class="card-header text-center">
                    <img :src="logo" alt="Logo" />
                    <router-link :to="{ name: 'login' }" class="h1 text-white"
                        ><b v-text="empresa"></b
                    ></router-link>
                </div>
                <div class="card-body">
                    <p class="login-box-msg text-white font-weight-bold">
                        Ingresa tu usuario y contraseña para inicar sesión
                    </p>

                    <div class="input-group mb-3">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Correo"
                            v-model="usuario"
                            @keypress.enter="login()"
                            autofocus
                        />
                        <div class="input-group-append">
                            <div class="input-group-text bg-primary">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input
                            type="password"
                            class="form-control"
                            placeholder="Contraseña"
                            v-model="password"
                            @keypress.enter="login()"
                        />
                        <div class="input-group-append">
                            <div class="input-group-text bg-primary">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <label class="text-white mr-3"
                            >Visitante<input
                                type="radio"
                                name="tipo"
                                v-model="tipo"
                                value="visitante"
                                style="
                                    height: 25px;
                                    width: 25px;
                                    display: block;
                                    margin: auto;
                                "
                        /></label>
                        <label class="text-white ml-3"
                            >Administración<input
                                type="radio"
                                name="tipo"
                                v-model="tipo"
                                value="administracion"
                                style="
                                    height: 25px;
                                    width: 25px;
                                    display: block;
                                    margin: auto;
                                "
                        /></label>
                    </div>
                    <div class="row" v-if="error">
                        <div class="col-12">
                            <div class="callout callout-danger">
                                <h5>¡Error!</h5>
                                <p>El usuario o contraseña son incorrectos</p>
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-12 text-center mb-2">
                                <a :href="recuperar_contrasena"
                                    >¿Olvidó su contraseña?</a
                                >
                            </div>
                        </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button
                                type="button"
                                class="btn btn-primary btn-block btn-flat font-weight-bold"
                                @click.prevent="login()"
                                v-loading.fullscreen.lock="fullscreenLoading"
                            >
                                Acceder
                            </button>
                            <a href="/" class="btn secondary btn-flat btn-block"
                                >Registrarse</a
                            >
                            <a
                                href="/"
                                class="btn btn-default btn-flat btn-block"
                                >Volver al inicio</a
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        empresa: { String, default: "Nombre Empresa" },
        logo: {
            String,
            default:
                "https://www.logodesign.net/logo/eye-and-house-5806ld.png?size=2&industry=All",
        },
        configuracion: {
            String,
            default: "",
        },
        recuperar_contrasena: {
            String,
            default: "/recuperar_contrasena",
        },
    },
    data() {
        return {
            usuario: "",
            password: "",
            tipo: "visitante",
            error: false,
            fullscreenLoading: false,
        };
    },
    methods: {
        login() {
            this.fullscreenLoading = true;
            axios
                .post("/login", {
                    usuario: this.usuario,
                    password: this.password,
                    tipo: this.tipo,
                })
                .then((res) => {
                    if (this.tipo == "administracion") {
                        let user = res.data.user;
                        setTimeout(() => {
                            this.obtienePermisos(user);
                        }, 50);
                    } else {
                        window.location.href = "/";
                    }
                })
                .catch((error) => {
                    this.error = true;
                    this.password = "";
                    console.log(error);
                    this.fullscreenLoading = false;
                });
        },
        obtienePermisos(user) {
            axios.get("/admin/usuarios/getPermisos/" + user.id).then((res) => {
                this.error = false;
                this.$router.push({ name: "inicio" });
                localStorage.setItem("configuracion", this.configuracion);
                localStorage.setItem("permisos", JSON.stringify(res.data));
                localStorage.setItem("user", JSON.stringify(user));
                location.reload();
            });
        },
    },
};
</script>

<style>
.login-page {
    background: #00000081;
}

.login-page .card {
    border-radius: 0px;
    box-shadow: 0px 0px 1px 1px var(--primary);
    background: var(--transparente);
}
.login-page .card-header {
    border-bottom: solid 1px var(--primary);
}
</style>
