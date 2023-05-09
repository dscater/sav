<template>
    <div
        class="card direct-chat direct-chat-primary"
        style="position: relative; left: 0px; top: 0px"
    >
        <div class="card-header ui-sortable-handle">
            <h3 class="card-title">Chat</h3>
            <div class="card-tools">
                <span title="3 New Messages" class="badge badge-primary"
                    >3</span
                >
                <button
                    v-if="visitante == 'no'"
                    type="button"
                    class="btn btn-tool"
                    title="Contacts"
                    data-widget="chat-pane-toggle"
                >
                    <i class="fas fa-comments"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="direct-chat-messages" id="contenedorMensajes">
                <template v-if="oVisitante && oVisitante != null">
                    <div
                        v-if="mensajesChat.length > 0"
                        class="direct-chat-msg"
                        v-for="(item, index) in mensajesChat"
                        :class="{
                            right: item.emisor_id == oUser.id,
                            visitante:
                                item.emisor_id != oUser.id &&
                                item.emisor.tipo == 'VISITANTE',
                        }"
                    >
                        <div class="direct-chat-infos clearfix">
                            <template v-if="item.emisor_id == oUser.id">
                                <span class="direct-chat-name float-left"
                                    >{{ item.emisor.full_name
                                    }}<small
                                        ><i>({{ item.emisor.tipo }})</i></small
                                    ></span
                                >
                            </template>
                            <template v-else>
                                <span class="direct-chat-name float-left"
                                    >{{ item.emisor.full_name
                                    }}<small
                                        ><i>({{ item.emisor.tipo }})</i></small
                                    ></span
                                >
                            </template>
                            <span class="direct-chat-timestamp float-right">{{
                                item.fecha_chat
                            }}</span>
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
                <ul class="contacts-list">
                    <li v-for="(item, index) in listVisitantes">
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
                                        >2/28/2015</small
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
            mensajesChat: [],
            oVisitante: null,
            oUser: JSON.parse(this.user),
            mensaje: "",
        };
    },
    watch: {},
    mounted() {
        this.loadingWindow.close();
        this.scrollAlFinal();
        if (this.visitante == "no") {
            this.getVisitantes();
        } else {
            this.oVisitante = this.oUser.visitante;
            this.getChatVisitante(this.oVisitante.id);
        }
    },
    methods: {
        getVisitantes() {
            axios.get("/admin/visitantes").then((response) => {
                this.listVisitantes = response.data.visitantes;
            });
        },
        getChatVisitante(id) {
            axios
                .get("/admin/chats/getChatVisitante", { params: { id: id } })
                .then((response) => {
                    this.oVisitante = response.data.visitante;
                    this.mensajesChat = response.data.mensajes;
                    $(".direct-chat").removeClass("direct-chat-contacts-open");
                    setTimeout(this.scrollAlFinal, 500);
                });
        },
        enviarMensaje() {
            if (this.mensaje.trim() != "") {
                axios
                    .post("/admin/chats", {
                        user_id: this.oUser.id,
                        visitante_id: this.oVisitante.id,
                        mensaje: this.mensaje,
                    })
                    .then((response) => {
                        this.mensajesChat.push(response.data.nuevo_mensaje);
                        setTimeout(this.scrollAlFinal, 500);
                        this.mensaje = "";
                    });
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

.direct-chat-msg.visitante .direct-chat-infos .direct-chat-name {
    color: rgb(0, 255, 204);
    font-weight: bold;
}
</style>
