<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Usuários</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <form @submit.prevent="submitForm" novalidate>
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Create</h3>
                            </div>

                            <div class="box-body">
                                <back-buttton></back-buttton>
                            </div>

                            <bootstrap-alert />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Nome *</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            placeholder="Enter Nome *"
                                            :value="item.name"
                                            @input="updateName"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="email">E-mail *</label>
                                    <input
                                            type="email"
                                            class="form-control"
                                            name="email"
                                            placeholder="Enter E-mail *"
                                            :value="item.email"
                                            @input="updateEmail"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="password">Senha *</label>
                                    <input
                                            type="password"
                                            class="form-control"
                                            name="password"
                                            placeholder="Enter Senha *"
                                            @input="updatePassword"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="role">Função *</label>
                                    <v-select
                                            name="role"
                                            label="title"
                                            @input="updateRole"
                                            :value="item.role"
                                            :options="rolesAll"
                                            multiple
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="matricula">Matricula *</label>
                                    <input
                                            type="number"
                                            class="form-control"
                                            name="matricula"
                                            placeholder="Enter Matricula *"
                                            :value="item.matricula"
                                            @input="updateMatricula"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="almoco">Almoço *</label>
                                    <date-picker
                                            :value="item.almoco"
                                            :config="$root.dpconfigTime"
                                            name="almoco"
                                            placeholder="Enter Almoço *"
                                            @dp-change="updateAlmoco"
                                            >
                                    </date-picker>
                                </div>
                                <div class="form-group">
                                    <label for="cargahoraria">Carga Horária *</label>
                                    <date-picker
                                            :value="item.cargahoraria"
                                            :config="$root.dpconfigTime"
                                            name="cargahoraria"
                                            placeholder="Enter Carga Horária *"
                                            @dp-change="updateCargahoraria"
                                            >
                                    </date-picker>
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
        ...mapGetters('UsersSingle', ['item', 'loading', 'rolesAll'])
    },
    created() {
        this.fetchRolesAll()
    },
    destroyed() {
        this.resetState()
    },
    methods: {
        ...mapActions('UsersSingle', ['storeData', 'resetState', 'setName', 'setEmail', 'setPassword', 'setRole', 'setMatricula', 'setAlmoco', 'setCargahoraria', 'fetchRolesAll']),
        updateName(e) {
            this.setName(e.target.value)
        },
        updateEmail(e) {
            this.setEmail(e.target.value)
        },
        updatePassword(e) {
            this.setPassword(e.target.value)
        },
        updateRole(value) {
            this.setRole(value)
        },
        updateMatricula(e) {
            this.setMatricula(e.target.value)
        },
        updateAlmoco(e) {
            this.setAlmoco(e.target.value)
        },
        updateCargahoraria(e) {
            this.setCargahoraria(e.target.value)
        },
        submitForm() {
            this.storeData()
                .then(() => {
                    this.$router.push({ name: 'users.index' })
                    this.$eventHub.$emit('create-success')
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
