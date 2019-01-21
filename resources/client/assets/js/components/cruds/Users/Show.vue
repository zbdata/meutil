<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Usuários</h1>
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
                                            <th>Nome</th>
                                            <td>{{ item.name }}</td>
                                            </tr>
                                        <tr>
                                            <th>E-mail</th>
                                            <td>{{ item.email }}</td>
                                            </tr>
                                        <tr>
                                            <th>Função</th>
                                            <td>
                                                <span class="label label-info" v-for="role in item.role">
                                                    {{ role.title }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Matricula</th>
                                            <td>{{ item.matricula }}</td>
                                            </tr>
                                        <tr>
                                            <th>Almoço</th>
                                            <td>{{ item.almoco }}</td>
                                            </tr>
                                        <tr>
                                            <th>Carga Horária</th>
                                            <td>{{ item.cargahoraria }}</td>
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
        ...mapGetters('UsersSingle', ['item'])
    },
    watch: {
        "$route.params.id": function() {
            this.resetState()
            this.fetchData(this.$route.params.id)
        }
    },
    methods: {
        ...mapActions('UsersSingle', ['fetchData', 'resetState'])
    }
}
</script>


<style scoped>

</style>
