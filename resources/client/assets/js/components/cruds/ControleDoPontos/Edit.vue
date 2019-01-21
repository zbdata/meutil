<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Controle do ponto</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <form @submit.prevent="submitForm" novalidate>
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit</h3>
                            </div>

                            <div class="box-body">
                                <back-buttton></back-buttton>
                            </div>

                            <bootstrap-alert />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="data">Data *</label>
                                    <date-picker
                                            :value="item.data"
                                            :config="$root.dpconfigDate"
                                            name="data"
                                            placeholder="Enter Data *"
                                            @dp-change="updateData"
                                            >
                                    </date-picker>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input
                                                    type="checkbox"
                                                    name="falta"
                                                    :value="item.falta"
                                                    :checked="item.falta == true"
                                                    @change="updateFalta"
                                                    >
                                            Falta
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input
                                                    type="checkbox"
                                                    name="feriado"
                                                    :value="item.feriado"
                                                    :checked="item.feriado == true"
                                                    @change="updateFeriado"
                                                    >
                                            Feriado
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="matricula">Matricula *</label>
                                    <v-select
                                            name="matricula"
                                            label="matricula"
                                            @input="updateMatricula"
                                            :value="item.matricula"
                                            :options="usersAll"
                                            />
                                </div>
                            </div>

                            <div class="box-footer">
                                <vue-button-spinner
                                        class="btn btn-primary btn-sm"
                                        :isLoading="loading"
                                        :disabled="loading"
                                        >
                                    Save
                                </vue-button-spinner>
                            </div>
                        </div>
                    </form>
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
    computed: {
        ...mapGetters('ControleDoPontosSingle', ['item', 'loading', 'usersAll']),
    },
    created() {
        this.fetchData(this.$route.params.id)
    },
    destroyed() {
        this.resetState()
    },
    watch: {
        "$route.params.id": function() {
            this.resetState()
            this.fetchData(this.$route.params.id)
        }
    },
    methods: {
        ...mapActions('ControleDoPontosSingle', ['fetchData', 'updateData', 'resetState', 'setData', 'setFalta', 'setFeriado', 'setMatricula']),
        updateData(e) {
            this.setData(e.target.value)
        },
        updateFalta(e) {
            this.setFalta(e.target.checked)
        },
        updateFeriado(e) {
            this.setFeriado(e.target.checked)
        },
        updateMatricula(value) {
            this.setMatricula(value)
        },
        submitForm() {
            this.updateData()
                .then(() => {
                    this.$router.push({ name: 'controle_do_pontos.index' })
                    this.$eventHub.$emit('update-success')
                })
                .catch((error) => {
                    console.error(error)
                })
        }
    }
}
</script>


<style scoped>

</style>
