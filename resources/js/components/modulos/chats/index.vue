<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Chat</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" style="height: 80vh">
                        <Chat
                            :user="JSON.stringify(user)"
                            :visitante="'no'"
                        ></Chat>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Chat from "../../../Chat.vue";
export default {
    components: { Chat },
    data() {
        return {
            user: JSON.parse(localStorage.getItem("user")),
            permisos: localStorage.getItem("permisos"),
            loadingWindow: Loading.service({
                fullscreen: this.fullscreenLoading,
            }),
        };
    },
    watch: {},
    mounted() {
        this.loadingWindow.close();
    },
    methods: {},
};
</script>

<style></style>
