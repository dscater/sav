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
                <template
                    v-if="oVisitante"
                    v-for="(item, index) in mensajesChat"
                >
                    <div
                        v-if="item.emisor_id == user.id"
                        class="direct-chat-msg right"
                    >
                        <div class="direct-chat-infos clearfix">
                            <span class="direct-chat-name float-left">{{
                                item.emisor.full_name
                            }}</span>
                            <span class="direct-chat-timestamp float-right">{{
                                item.fecha_registro
                            }}</span>
                        </div>

                        <img
                            class="direct-chat-img"
                            :src="item.emisor.path_image"
                            alt="message user image"
                        />

                        <div class="direct-chat-text">{{ item.mensaje }}</div>
                    </div>
                    <div v-else class="direct-chat-msg">
                        <div class="direct-chat-infos clearfix">
                            <span class="direct-chat-name float-left">{{
                                item.receptor.full_name
                            }}</span>
                            <span class="direct-chat-timestamp float-right">{{
                                item.fecha_registro
                            }}</span>
                        </div>

                        <img
                            class="direct-chat-img"
                            :src="item.receptor.path_image"
                            alt="message user image"
                        />

                        <div class="direct-chat-text">{{ item.mensaje }}</div>
                    </div>
                </template>

                <div class="chat_vacio">
                    <h4>Selecciona un chat</h4>
                </div>
            </div>

            <div class="direct-chat-contacts">
                <ul class="contacts-list">
                    <li v-for="(item, index) in listVisitantes">
                        <a href="#" @click="getChatVisitante(item.id)">
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
                                <span class="contacts-list-msg"
                                    >How have you been? I was...</span
                                >
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
                        name="message"
                        placeholder="Type Message ..."
                        class="form-control"
                    />
                    <span class="input-group-append">
                        <button type="button" class="btn btn-primary">
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
    props: ["user", "visitante"],
    data() {
        return {
            loadingWindow: Loading.service({
                fullscreen: this.fullscreenLoading,
            }),
            listVisitantes: [],
            mensajesChat: [],
            oVisitante: null,
        };
    },
    watch: {},
    mounted() {
        this.loadingWindow.close();
        this.scrollAlFinal();
        if (this.visitante == "no") {
            this.getVisitantes();
        } else {
            console.log(user);
            this.oVisitante = user.visitante;
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
                });
        },
        scrollAlFinal() {
            let chatContainer = document.getElementById("contenedorMensajes");
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
    color: lightblue;
    background-color: rgb(41, 41, 41);
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
