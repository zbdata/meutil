<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Controle do ponto</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">View</h3>
                        </div>

                        <div class="box-body">
                            <back-buttton></back-buttton>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                        <tr>
                                            <th>#</th>
                                            <td>{{ item.id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Data</th>
                                            <td>{{ item.data }}</td>
                                            </tr>
                                        <tr>
                                            <th>Falta</th>
                                            <td>{{ item.falta }}</td>
                                            </tr>
                                        <tr>
                                            <th>Feriado</th>
                                            <td>{{ item.feriado }}</td>
                                            </tr>
                                        <tr>
                                            <th>Matricula</th>
                                            <td>
                                                <span class="label label-info" v-if="item.matricula !== null">
                                                    {{ item.matricula.matricula }}
                                                </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
</template>


<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    data() {
        return {
            // Code...
        }
    },
    created() {
        this.fetchData(this.$route.params.id)
    },
    destroyed() {
        this.resetState()
    },
    computed: {
        ...mapGetters('ControleDoPontosSingle', ['item'])
    },
    watch: {
        "$route.params.id": function() {
            this.resetState()
            this.fetchData(this.$route.params.id)
        }
    },
    methods: {
        ...mapActions('ControleDoPontosSingle', ['fetchData', 'resetState'])
    }
}
</script>


<style scoped>

</style>
