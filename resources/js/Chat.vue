<template>
    <div
        class="card direct-chat direct-chat-primary"
        style="position: relative; left: 0px; top: 0px"
    >
        <div class="card-header ui-sortable-handle">
            <h3 class="card-title">Chat</h3>
            <div class="card-tools">
                <span v-if="visitante == 'no'">
                    Sin leer:
                    <span
                        title="3 New Messages"
                        class="badge badge-primary"
                        v-text="sin_leer"
                    ></span>
                </span>
                <span v-if="visitante == 'no'">
                    Actual:
                    <strong v-text="getNombreChat"></strong>
                </span>
                <button
                    v-if="visitante == 'no'"
                    type="button"
                    class="btn btn-tool"
                    title="Contacts"
                    data-widget="chat-pane-toggle"
                    @click="getListadoVisitantes"
                >
                    <i class="fas fa-comments"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <div
                class="direct-chat-messages"
                id="contenedorMensajes"
                data-activo="no"
            >
                <template v-if="oVisitante && oVisitante != null">
                    <div
                        v-if="mensajesChat.length > 0"
                        class="direct-chat-msg"
                        v-for="(item, index) in mensajesChat"
                        :class="{
                            right: item.emisor_id == oUser.id,
                        }"
                    >
                        <div class="direct-chat-infos clearfix">
                            <span class="direct-chat-name float-left"
                                >{{ item.emisor.full_name }}
                                <small
                                    ><i>({{ item.emisor.tipo }})</i></small
                                ></span
                            >
                            <span class="direct-chat-timestamp float-right"
                                ><small v-if="item.emisor_id == oUser.id"
                                    ><strong>{{ item.estado }}</strong></small
                                >
                                {{ item.fecha_chat }}</span
                            >
                        </div>
                        <img
                            class="direct-chat-img"
                            :src="item.emisor.path_image"
                            alt="message user image"
                        />
                        <div class="direct-chat-text">
                            {{ item.mensaje }}
                        </div>
                    </div>
                    <div v-else class="chat_vacio">
                        <h4>Sin mensajes aún...</h4>
                    </div>
                </template>
                <template v-else>
                    <div class="seleccionar_visitante">
                        <h4>Selecciona un chat</h4>
                    </div>
                </template>
            </div>

            <div class="direct-chat-contacts">
                <div class="row">
                    <div class="col-md-12 m-2">
                        <input
                            type="text"
                            placeholder="Buscar..."
                            v-model="filtro_contactos"
                            class="form-control rounded-0"
                            @keyup.prevent="buscarChat"
                            @change="buscarChat"
                        />
                    </div>
                </div>
                <ul class="contacts-list">
                    <li
                        v-for="(item, index) in listVisitantes"
                        :class="{
                            enviado:
                                item.detalle_ultimo_mensaje.chat.estado ==
                                'ENVIADO',
                        }"
                    >
                        <a href="#" @click.prevent="getChatVisitante(item.id)">
                            <img
                                class="contacts-list-img"
                                :src="item.path_image"
                                alt="Avatar"
                            />
                            <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                    {{ item.nombre }}
                                    <small
                                        class="contacts-list-date float-right"
                                        >{{
                                            item.detalle_ultimo_mensaje.fecha
                                        }}</small
                                    >
                                </span>
                                <span class="contacts-list-msg">{{
                                    item.detalle_ultimo_mensaje.sw
                                        ? item.detalle_ultimo_mensaje.chat
                                              .mensaje
                                        : "Sin mensajes aún..."
                                }}</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card-footer">
            <form action="#" method="post">
                <div class="input-group">
                    <input
                        type="text"
                        v-model="mensaje"
                        name="message"
                        placeholder="Escribe un mensaje..."
                        class="form-control"
                        @keypress.enter.prevent="enviarMensaje"
                    />
                    <span class="input-group-append">
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click.prevent="enviarMensaje"
                        >
                            Enviar
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    props: {
        user: {
            type: String,
            required: true,
        },
        visitante: {
            type: String,
            default: "si",
        },
    },
    data() {
        return {
            loadingWindow: Loading.service({
                fullscreen: this.fullscreenLoading,
            }),
            listVisitantes: [],
            auxListVisitantes: [],
            mensajesChat: [],
            oVisitante: null,
            oUser: JSON.parse(this.user),
            mensaje: "",
            filtro_contactos: "",
            sin_leer: 0,
            ultimo_chat_id: 0,
            intervalNuevosMensajes: null,
            array_verica_envio_id: [],
            intervalVerificaEstados: null,
            intervalListaActualizada: null,
            intervalGetVisitantes: null,
        };
    },
    computed: {
        getNombreChat() {
            if (this.oVisitante) {
                return this.oVisitante.nombre;
            }
            return "";
        },
    },
    watch: {},
    mounted() {
        this.loadingWindow.close();
        this.scrollAlFinal();
        let self = this;
        if (this.visitante == "no") {
            this.getVisitantes();
            this.intervalGetVisitantes = setInterval(self.getVisitantes, 2500);
        } else {
            this.oVisitante = this.oUser.visitante;
            this.getChatVisitante(this.oVisitante.id);
            // setInterval(self.sin_leer, 2500);
        }
    },
    methods: {
        getVisitantes() {
            axios.get("/admin/visitantes").then((response) => {
                this.listVisitantes = response.data.visitantes;
                this.auxListVisitantes = this.listVisitantes;
                this.getSinLeer();
            });
        },
        getListadoVisitantes() {
            if (!$(".direct-chat").hasClass("direct-chat-contacts-open")) {
                clearInterval(this.intervalGetVisitantes);
                this.getVisitantes();
            } else {
                let self = this;
                this.intervalGetVisitantes = setInterval(
                    self.getVisitantes,
                    2500
                );
            }
        },
        getSinLeer() {
            axios.get("/admin/chats/getInfoChat").then((response) => {
                this.sin_leer = response.data.sin_leer;
            });
        },
        getChatVisitante(id) {
            axios
                .get("/admin/chats/getChatVisitante", { params: { id: id } })
                .then((response) => {
                    this.oVisitante = response.data.visitante;
                    this.mensajesChat = response.data.mensajes;
                    this.sin_leer = response.data.sin_leer;
                    $(".direct-chat").removeClass("direct-chat-contacts-open");
                    if (this.mensajesChat.length > 0) {
                        this.ultimo_chat_id =
                            this.mensajesChat[this.mensajesChat.length - 1].id;
                    }
                    if (this.visitante == "no") {
                        $("#contenedorMensajes").attr("data-activo", "si");
                    }
                    let self = this;
                    this.intervalListaActualizada = setInterval(function () {
                        self.getListaActualizada(id);
                    }, 45000);
                    setTimeout(function () {
                        self.scrollAlFinal();
                        self.intervalNuevosMensajes = setInterval(
                            self.getNuevosMensajes,
                            2000
                        );
                    }, 500);
                });
        },
        getListaActualizada(id) {
            axios
                .get("/admin/chats/getChatVisitante", { params: { id: id } })
                .then((response) => {
                    this.mensajesChat = response.data.mensajes;
                    if (this.mensajesChat.length > 0) {
                        this.ultimo_chat_id =
                            this.mensajesChat[this.mensajesChat.length - 1].id;
                    }
                    let self = this;
                    setTimeout(function () {
                        self.scrollAlFinal();
                    }, 500);
                });
        },
        getNuevosMensajes() {
            axios
                .get("/admin/chats/getNuevosMensajes", {
                    params: {
                        id: this.oVisitante.id,
                        ultimo_chat_id: this.ultimo_chat_id,
                        activo: $("#contenedorMensajes").attr("data-activo"),
                    },
                })
                .then((response) => {
                    if (response.data.mensajes.length > 0) {
                        this.ultimo_chat_id =
                            response.data.mensajes[
                                response.data.mensajes.length - 1
                            ].id;
                        this.mensajesChat = this.mensajesChat.concat(
                            response.data.mensajes
                        );
                    }
                    this.sin_leer = response.data.sin_leer;
                    let self = this;
                    setTimeout(self.scrollAlFinal, 150);
                });
        },
        buscarChat() {
            if (this.filtro_contactos.trim() != "") {
                let resultado = this.listVisitantes.filter((elem) => {
                    return elem.nombre
                        .toLowerCase()
                        .includes(this.filtro_contactos.toLowerCase());
                });

                this.listVisitantes = resultado;
            } else {
                this.listVisitantes = this.auxListVisitantes;
            }
        },
        enviarMensaje() {
            if (this.mensaje.trim() != "") {
                clearInterval(this.intervalNuevosMensajes);
                clearInterval(this.intervalListaActualizada);
                axios
                    .post("/admin/chats", {
                        user_id: this.oUser.id,
                        visitante_id: this.oVisitante.id,
                        mensaje: this.mensaje,
                    })
                    .then((response) => {
                        this.mensajesChat.push(response.data.nuevo_mensaje);
                        this.ultimo_chat_id = response.data.nuevo_mensaje.id;
                        this.array_verica_envio_id.push(
                            response.data.nuevo_mensaje.id
                        );
                        let self = this;
                        this.intervalVerificaEstados = setInterval(
                            this.verificaEstadoEnvios,
                            2500
                        );
                        setTimeout(function () {
                            self.scrollAlFinal();
                            self.intervalNuevosMensajes = setInterval(
                                self.getNuevosMensajes,
                                2000
                            );
                        }, 500);
                        this.mensaje = "";
                    });
            }
        },
        verificaEstadoEnvios() {
            if (this.array_verica_envio_id.length > 0) {
                this.array_verica_envio_id.forEach((elem, index) => {
                    axios
                        .get("/admin/chats/verifica_estado_chat/" + elem)
                        .then((response) => {
                            if (response.data) {
                                const mensajesChatActualizados =
                                    this.mensajesChat.map((mensaje) => {
                                        if (mensaje.id === elem) {
                                            return {
                                                ...mensaje,
                                                estado: "RECIBIDO",
                                            };
                                        }
                                        return mensaje;
                                    });
                                this.mensajesChat = mensajesChatActualizados;
                                this.array_verica_envio_id.splice(index, 1);
                            }
                        });
                });
            } else {
                clearInterval(this.intervalVerificaEstados);
            }
        },
        scrollAlFinal() {
            let chatContainer = document.getElementById("contenedorMensajes");
            $("#contenedorMensajes").parent(".card-body").scrollTop = $(
                "#contenedorMensajes"
            ).parent(".card-body").scrollHeight;
            chatContainer.scrollTop = chatContainer.scrollHeight;
        },
    },
};
</script>
<style>
.direct-chat.direct-chat-primary {
    height: 100%;
}
#contenedorMensajes {
    height: 100% !important;
}
.chat_vacio {
    height: 100%;
    color: rgb(51, 51, 51);
    background-color: rgb(138, 137, 137);
    display: flex;
    justify-content: center;
    align-items: center;
}
.seleccionar_visitante {
    height: 100%;
    color: lightblue;
    background-color: rgb(41, 41, 41);
    display: flex;
    justify-content: center;
    align-items: center;
}

.direct-chat-msg .direct-chat-infos .direct-chat-name {
    font-weight: bold;
}

.contacts-list > li.enviado {
    background-color: rgb(0, 115, 255);
}
</style>
