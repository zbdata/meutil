<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text">Saldo do Mês</span>
                    <span class="info-box-number">{{getSaldo()}}</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                        <span class="progress-description">
                            70% já completados de 30 Dias
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
        <!-- /.info-box -->
            </div>
            
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Registros de entrada e saída</h3>
                        </div>

                        <div class="box-body">
                            <div class="btn-group">
                                <router-link
                                        v-if="$can(xprops.permission_prefix + 'create')"
                                        :to="{ name: xprops.route + '.create' }"
                                        class="btn btn-success btn-sm"
                                        >
                                    <i class="fa fa-plus"></i> Add new
                                </router-link>

                                <button type="button" class="btn btn-default btn-sm" @click="fetchData">
                                    <i class="fa fa-refresh" :class="{'fa-spin': loading}"></i> Refresh
                                </button>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="row" v-if="loading">
                                <div class="col-xs-4 col-xs-offset-4">
                                    <div class="alert text-center">
                                        <i class="fa fa-spin fa-refresh"></i> Loading
                                    </div>
                                </div>
                            </div>

                            <datatable
                                    v-if="!loading"
                                    :columns="columns"
                                    :data="data"
                                    :total="total"
                                    :query="query"
                                    :xprops="xprops"
                                    />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
</template>


<script>
import { mapGetters, mapActions } from 'vuex'
import DatatableActions from '../../dtmodules/DatatableActions'
import DatatableSingle from '../../dtmodules/DatatableSingle'
import DatatableList from '../../dtmodules/DatatableList'
import DatatableCheckbox from '../../dtmodules/DatatableCheckbox'


export default {
    data() {
        return {
            columns: [
                { title: '#', field: 'id', visible: false, colStyle: 'width: 50px;' },
                { title: 'Data', field: 'data'},
                { title: 'Entrada', field: 'entrada' },
                { title: 'Saida', field: 'saida' },
                { title: 'No dia', field: 'no_dia' },
                { title: 'Saldo', field: 'saldo_dia' },
                { title: 'Falta', field: 'falta', tdComp: DatatableCheckbox, colStyle: 'width: 50px;' },
                { title: 'Feriado', field: 'feriado', tdComp: DatatableCheckbox, colStyle: 'width: 50px;' },
                { title: 'Matricula', field: 'matricula', visible: false, tdComp: DatatableSingle },
                { title: 'Actions', tdComp: DatatableActions, visible: true, thClass: 'text-right', tdClass: 'text-right', colStyle: 'width: 130px;' }
            ],
            query: { sort: 'data', order: 'asc' },
            xprops: {
                module: 'ControleDoPontosIndex',
                route: 'controle_do_pontos',
                permission_prefix: 'controle_do_ponto_'
            },
        }
    },
    created() {
        this.$root.relationships = this.relationships
        this.fetchData()
    },
    destroyed() {
        this.resetState()
    },
    computed: {
        ...mapGetters('ControleDoPontosIndex', ['data', 'total', 'loading', 'relationships']),
    },
    watch: {
        query: {
            handler(query) {
                this.setQuery(query)
            },
            deep: true
        }
    },
    methods: {
        ...mapActions('ControleDoPontosIndex', ['fetchData', 'setQuery', 'resetState']),
        getSaldo: function(){  
            return this.$data.saldo;
        }
    }
}
</script>


<style scoped>

</style>
