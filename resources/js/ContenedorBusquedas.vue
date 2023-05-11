<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center text-primary">
                        RESULTADOS DE BÚSQUEDA
                    </h4>
                    <div
                        class="row"
                        v-if="
                            listResultados.length > 0 && mostrando_faq == false
                        "
                    >
                        <div
                            class="col-md-12"
                            v-for="(item, index) in listResultados"
                        >
                            <div
                                class="card contenedor_faq"
                                @click="muestraInfo(item.id)"
                            >
                                <div class="card-header pregunta">
                                    {{ item.pregunta }}
                                </div>
                                <div class="card-body">
                                    <div
                                        class="contenedor_respuesta"
                                        v-html="item.respuesta + '...'"
                                    ></div>
                                </div>
                                <div class="card-footer">
                                    <div class="info_faq">
                                        <div class="vistas">
                                            <i class="fa fa-eye"></i>
                                            {{ item.vistas }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else>
                        <div class="col-md-12">
                            <h5 class="text-center text-gray">
                                Sin resultados aún...
                            </h5>
                        </div>
                    </div>
                    <div
                        class="row contenedor_faq"
                        v-if="mostrando_faq == true && oFaq"
                    >
                        <div class="col-md-4 mb-2">
                            <button
                                type="button"
                                class="btn btn-default btn-block btn-flat"
                                @click="
                                    mostrando_faq = false;
                                    oFaq = null;
                                "
                            >
                                <i class="fa fa-arrow-left"></i>
                                Volver a resultados
                            </button>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header pregunta">
                                    {{ oFaq.pregunta }}
                                </div>
                                <div
                                    class="card-body"
                                    v-html="oFaq.respuesta"
                                ></div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12 info_faq">
                                            <div class="vistas">
                                                <i class="fa fa-eye"></i>
                                                {{ oFaq.vistas }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <button
                                type="button"
                                class="btn btn-default btn-block btn-flat"
                                @click="
                                    mostrando_faq = false;
                                    oFaq = null;
                                "
                            >
                                <i class="fa fa-arrow-left"></i>
                                Volver a resultados
                            </button>
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
        listResultados: {
            type: Array,
            default: [],
        },
    },
    data() {
        return {
            error: false,
            fullscreenLoading: false,
            mostrando_faq: false,
            oFaq: null,
        };
    },
    mounted() {},
    methods: {
        muestraInfo(id) {
            axios.post("/faqs/incrementaVistas/" + id).then((response) => {
                this.oFaq = response.data.faq;
                this.mostrando_faq = true;
                this.$emit("actualizaLista");
            });
        },
    },
};
</script>

<style>
.contenedor_faq .pregunta {
    color: black;
    font-weight: 900;
}
.contenedor_faq {
    text-decoration: none;
    cursor: pointer;
}
.contenedor_respuesta {
    overflow: hidden;
    height: 100px;
    color: rgb(53, 52, 52);
    font-size: 0.8em;
}
</style>
