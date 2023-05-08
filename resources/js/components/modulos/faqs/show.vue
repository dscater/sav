<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>FAQs</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 v-text="oFaq.pregunta"></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Respuesta:</h4>
                                    </div>
                                    <div
                                        class="col-md-12"
                                        v-html="oFaq.respuesta"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pb-3">
                    <div class="col-md-3">
                        <router-link
                            :to="{ name: 'faqs.index' }"
                            class="btn btn-default btn-block btn-flat"
                            ><i class="fa fa-arrow-left"></i>
                            Volver</router-link
                        >
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    props: ["id"],
    data() {
        return {
            permisos: localStorage.getItem("permisos"),
            loadingWindow: Loading.service({
                fullscreen: this.fullscreenLoading,
            }),
            oFaq: {
                id: 0,
                vehiculo_id: "",
                caracteristica_id: "",
                pregunta: "",
                respuesta: "",
            },
        };
    },
    mounted() {
        this.loadingWindow.close();
        this.getFaq();
    },
    methods: {
        getFaq() {
            axios.get("/admin/faqs/" + this.id).then((response) => {
                this.oFaq = response.data.faq;
            });
        },
        formatoFecha(date) {
            return this.$moment(String(date)).format("DD/MM/YYYY");
        },
    },
};
</script>

<style></style>
