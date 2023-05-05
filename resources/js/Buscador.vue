<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 bg-primary p-5 border-top">
                <form action="">
                    <h5 class="text-center text-white">
                        ¿TIENÉS ALGUNA CONSULTA?
                    </h5>
                    <div class="row">
                        <div class="col-md-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Modelo"
                            />
                        </div>
                        <div class="col-md-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Marca"
                            />
                        </div>
                        <div class="col-md-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Tipo"
                            />
                        </div>
                        <div class="col-md-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Año"
                            />
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center text-primary">
                            RESULTADOS DE BÚSQUEDA
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            error: false,
            fullscreenLoading: false,
        };
    },
    methods: {},
};
</script>

<style></style>
